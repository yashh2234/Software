<?php

class Model_jobs extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function erp_tables_ready()
	{
		$tables = array('jobs', 'workflow_templates', 'workflow_stages', 'job_workflow_instances', 'job_stage_history', 'job_timeline', 'job_assignments', 'activity_logs');

		foreach ($tables as $table) {
			if(!$this->db->table_exists($table)) {
				return false;
			}
		}

		return true;
	}

	public function get_jobs()
	{
		if(!$this->erp_tables_ready()) {
			return array();
		}

		$this->db->select('jobs.*, workflow_templates.name as workflow_name, workflow_stages.name as stage_name, users.firstname, users.lastname');
		$this->db->from('jobs');
		$this->db->join('workflow_templates', 'workflow_templates.id = jobs.workflow_template_id', 'left');
		$this->db->join('workflow_stages', 'workflow_stages.id = jobs.current_stage_id', 'left');
		$this->db->join('users', 'users.id = jobs.assigned_user_id', 'left');
		$this->db->order_by('jobs.id', 'DESC');

		return $this->db->get()->result_array();
	}

	public function get_job_by_uid($uid_no)
	{
		if(!$this->erp_tables_ready()) {
			return null;
		}

		$this->db->select('jobs.*, workflow_templates.name as workflow_name, workflow_stages.name as stage_name, workflow_stages.sla_hours, users.firstname, users.lastname');
		$this->db->from('jobs');
		$this->db->join('workflow_templates', 'workflow_templates.id = jobs.workflow_template_id', 'left');
		$this->db->join('workflow_stages', 'workflow_stages.id = jobs.current_stage_id', 'left');
		$this->db->join('users', 'users.id = jobs.assigned_user_id', 'left');
		$this->db->where('jobs.uid_no', $uid_no);

		return $this->db->get()->row_array();
	}

	public function uid_exists($uid_no)
	{
		$this->db->where('uid_no', $uid_no);
		return $this->db->count_all_results('jobs') > 0;
	}

	public function get_active_workflow_templates()
	{
		if(!$this->db->table_exists('workflow_templates')) {
			return array();
		}

		$this->db->where('active', 1);
		$this->db->order_by('is_default', 'DESC');
		$this->db->order_by('name', 'ASC');
		return $this->db->get('workflow_templates')->result_array();
	}

	public function get_users()
	{
		$this->db->select('id, firstname, lastname, username');
		$this->db->from('users');
		$this->db->order_by('firstname', 'ASC');
		return $this->db->get()->result_array();
	}

	public function get_start_stage($workflow_template_id)
	{
		$this->db->where('workflow_template_id', $workflow_template_id);
		$this->db->where('active', 1);
		$this->db->group_start();
		$this->db->where('is_start', 1);
		$this->db->or_where('sequence_no', 1);
		$this->db->group_end();
		$this->db->order_by('is_start', 'DESC');
		$this->db->order_by('sequence_no', 'ASC');
		return $this->db->get('workflow_stages')->row_array();
	}

	public function ensure_default_stages($workflow_template_id)
	{
		$this->db->where('workflow_template_id', $workflow_template_id);
		$count = $this->db->count_all_results('workflow_stages');

		if($count > 0) {
			return;
		}

		$stages = array(
			array('name' => 'UID Created', 'code' => 'uid_created', 'sequence_no' => 1, 'sla_hours' => 4, 'is_start' => 1),
			array('name' => 'Sample / Technical Assignment', 'code' => 'assignment', 'sequence_no' => 2, 'sla_hours' => 24),
			array('name' => 'Testing / Execution', 'code' => 'testing', 'sequence_no' => 3, 'sla_hours' => 72),
			array('name' => 'Report Review', 'code' => 'report_review', 'sequence_no' => 4, 'sla_hours' => 24, 'requires_approval' => 1),
			array('name' => 'Billing / Dispatch', 'code' => 'billing_dispatch', 'sequence_no' => 5, 'sla_hours' => 24),
			array('name' => 'Completed', 'code' => 'completed', 'sequence_no' => 6, 'is_end' => 1)
		);

		foreach ($stages as $stage) {
			$stage['workflow_template_id'] = $workflow_template_id;
			$this->db->insert('workflow_stages', $stage);
		}
	}

	public function create_job($data, $created_by)
	{
		$this->ensure_default_stages($data['workflow_template_id']);
		$stage = $this->get_start_stage($data['workflow_template_id']);

		if(!$stage) {
			return false;
		}

		$due_date = null;
		if(!empty($stage['sla_hours'])) {
			$due_date = date('Y-m-d H:i:s', strtotime('+'.(int)$stage['sla_hours'].' hours'));
		}

		$job = array(
			'uid_no' => $data['uid_no'],
			'client_id' => isset($data['client_id']) ? $data['client_id'] : null,
			'legacy_registration_id' => isset($data['legacy_registration_id']) ? $data['legacy_registration_id'] : null,
			'workflow_template_id' => $data['workflow_template_id'],
			'current_stage_id' => $stage['id'],
			'title' => $data['title'],
			'project_type' => $data['project_type'],
			'priority' => $data['priority'],
			'current_status' => 'active',
			'assigned_user_id' => $data['assigned_user_id'],
			'expected_completion_date' => $data['expected_completion_date'],
			'created_by' => $created_by
		);

		$this->db->trans_start();
		$this->db->insert('jobs', $job);
		$job_id = $this->db->insert_id();

		$this->db->insert('job_workflow_instances', array(
			'job_id' => $job_id,
			'workflow_template_id' => $data['workflow_template_id'],
			'status' => 'active'
		));

		$this->db->insert('job_stage_history', array(
			'job_id' => $job_id,
			'to_stage_id' => $stage['id'],
			'status' => 'active',
			'notes' => 'UID job created with workflow selection.',
			'changed_by' => $created_by
		));

		$this->db->insert('job_timeline', array(
			'job_id' => $job_id,
			'event_type' => 'job_created',
			'title' => 'UID created',
			'description' => 'Workflow started at '.$stage['name'].'.',
			'actor_user_id' => $created_by
		));

		if(!empty($data['assigned_user_id'])) {
			$this->db->insert('job_assignments', array(
				'job_id' => $job_id,
				'stage_id' => $stage['id'],
				'assigned_by' => $created_by,
				'assigned_to' => $data['assigned_user_id'],
				'due_date' => $due_date,
				'priority' => $data['priority'],
				'status' => 'assigned',
				'remarks' => 'Initial owner assigned during UID creation.'
			));
		}

		$this->db->insert('activity_logs', array(
			'job_id' => $job_id,
			'user_id' => $created_by,
			'action' => 'job_created',
			'entity_type' => 'jobs',
			'entity_id' => $job_id,
			'ip_address' => $this->input->ip_address(),
			'user_agent' => substr($this->input->user_agent(), 0, 255)
		));

		$this->db->trans_complete();

		return $this->db->trans_status() ? $job_id : false;
	}

	public function get_timeline($job_id)
	{
		$this->db->select('job_timeline.*, users.firstname, users.lastname');
		$this->db->from('job_timeline');
		$this->db->join('users', 'users.id = job_timeline.actor_user_id', 'left');
		$this->db->where('job_timeline.job_id', $job_id);
		$this->db->order_by('job_timeline.created_at', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_assignments($job_id)
	{
		$this->db->select('job_assignments.*, users.firstname, users.lastname, workflow_stages.name as stage_name');
		$this->db->from('job_assignments');
		$this->db->join('users', 'users.id = job_assignments.assigned_to', 'left');
		$this->db->join('workflow_stages', 'workflow_stages.id = job_assignments.stage_id', 'left');
		$this->db->where('job_assignments.job_id', $job_id);
		$this->db->order_by('job_assignments.id', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_legacy_registration($uid_no)
	{
		if(!$this->db->table_exists('client_registration')) {
			return null;
		}

		$this->db->where('uid_no', $uid_no);
		return $this->db->get('client_registration')->row_array();
	}
}
