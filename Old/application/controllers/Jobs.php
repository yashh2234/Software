<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'UID Jobs';
		$this->load->model('model_jobs');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->data['erp_ready'] = $this->model_jobs->erp_tables_ready();
		$this->data['jobs'] = $this->model_jobs->get_jobs();
		$this->render_template('jobs/index', $this->data);
	}

	public function create()
	{
		$this->data['erp_ready'] = $this->model_jobs->erp_tables_ready();
		$this->data['workflows'] = $this->model_jobs->get_active_workflow_templates();
		$this->data['users'] = $this->model_jobs->get_users();

		if(!$this->data['erp_ready']) {
			$this->session->set_flashdata('error', 'ERP tables are not installed yet. Apply docs/enterprise_erp_extension_schema.sql first.');
			redirect('jobs', 'refresh');
		}

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('uid_no', 'UID No.', 'trim|required');
			$this->form_validation->set_rules('workflow_template_id', 'Workflow', 'trim|required|integer');
			$this->form_validation->set_rules('title', 'Job Title', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() == TRUE) {
				$uid_no = $this->input->post('uid_no', true);

				if($this->model_jobs->uid_exists($uid_no)) {
					$this->data['error'] = 'A job already exists for this UID.';
				}
				else {
					$job_data = array(
						'uid_no' => $uid_no,
						'workflow_template_id' => (int)$this->input->post('workflow_template_id'),
						'title' => $this->input->post('title', true),
						'project_type' => $this->input->post('project_type', true),
						'priority' => $this->input->post('priority', true),
						'assigned_user_id' => $this->input->post('assigned_user_id') ? (int)$this->input->post('assigned_user_id') : null,
						'expected_completion_date' => $this->input->post('expected_completion_date') ? $this->input->post('expected_completion_date') : null
					);

					$job_id = $this->model_jobs->create_job($job_data, $this->session->userdata('id'));

					if($job_id) {
						$this->session->set_flashdata('success', 'UID job created and workflow started.');
						redirect('jobs/view/'.$uid_no, 'refresh');
					}

					$this->data['error'] = 'Unable to create UID job. Please verify the workflow setup.';
				}
			}
		}

		$this->render_template('jobs/create', $this->data);
	}

	public function view($uid_no = null)
	{
		if(!$uid_no) {
			redirect('jobs', 'refresh');
		}

		$uid_no = urldecode($uid_no);
		$job = $this->model_jobs->get_job_by_uid($uid_no);

		if(!$job) {
			$this->session->set_flashdata('error', 'UID job was not found.');
			redirect('jobs', 'refresh');
		}

		$this->data['job'] = $job;
		$this->data['timeline'] = $this->model_jobs->get_timeline($job['id']);
		$this->data['assignments'] = $this->model_jobs->get_assignments($job['id']);
		$this->data['legacy_registration'] = $this->model_jobs->get_legacy_registration($job['uid_no']);
		$this->render_template('jobs/view', $this->data);
	}
}
