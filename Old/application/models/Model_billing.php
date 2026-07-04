<?php 

class Model_billing extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	 

	/* get the brand data */
	public function getBillingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM billing WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM billing  order by id desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}

 
    public function getBillingDatabystatusFilter($start_date,$end_date)
	{
	    $start_date1 = date('d-M-Y',strtotime($start_date));
	    $end_date1 = date('d-M-Y',strtotime($end_date));
	     
        $sql = "SELECT * FROM billing where date_time >='".$start_date1."' AND date_time <= '".$end_date1."' order by id desc";
        
        $query = $this->db->query($sql);
    	return $query->result_array();
	}
	
  

	public function create($data)
	{
	    if($data) {
			$insert = $this->db->insert('billing', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
		public function createsmslog($data)
	{
	    if($data) {
			$insert = $this->db->insert('sms_reminder_log', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('billing', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updatebyuid($data, $id)
	{
		if($data && $id) {
			$this->db->where('uid_no', $id);
			$update = $this->db->update('billing', $data);
			return ($update == true) ? true : false;
		}
	}
	
	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('billing');
			return ($delete == true) ? true : false;
		}
	}
	 
public function updateregbilling($data, $id)
	{
		if($data && $id) {
			$this->db->where('iClientId', $id);
			$update = $this->db->update('client_registration', $data);
			return ($update == true) ? true : false;
		}
	}

}