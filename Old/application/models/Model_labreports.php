<?php 

class Model_labreports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    
    /*********final reports get */
    public function updateulrno($data, $id)
	{
		if($data && $id) {
			$this->db->where('uid_no', $id);
			$update = $this->db->update('client_registration', $data);
		 	  
			return ($update == true) ? true : false;
		}
	}
    public function todaytotalreports()
	{
        $startdate = date('Y-m-d 00:00:00');
        $enddate = date('Y-m-d 23:59:59');
	    
		$sql = "SELECT * FROM reports where create_date > '".$startdate."' AND create_date < '".$enddate."'";
		$query = $this->db->query($sql);  
	    return $query->num_rows();
	}
	 

	 public function totalpendingreport()
	{ 
		$sql = "SELECT * FROM reports as r where r.`status`='Pending'";
		$query = $this->db->query($sql);  
	    return $query->num_rows();
	}
	
    public function getuidDataapprovedstatus($uid_no)
	{ 
		 $sql = "SELECT * FROM reports as r where r.`uid_no`='".$uid_no."' ORDER BY r.create_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getfinalallOrdersData()
	{ 
		$sql = "SELECT * FROM reports as r where 1=1 ORDER BY r.create_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
    public function getfinalallOrdersDataFilter($startdate,$enddate)
	{ 
	    $startdate = date('Y-m-d 00:00:00',strtotime($startdate));
        $enddate = date('Y-m-d 23:59:59',strtotime($enddate));
		$sql = "SELECT * FROM reports as r where r.create_date >= '".$startdate."' AND r.create_date <= '".$enddate."' group by r.uid_no ORDER BY r.create_date DESC";
		$query = $this->db->query($sql);
		 //	print_r($this->db->last_query());
		return $query->result_array();
	}
    
    public function cancel($id)
	{
		if($id) {
		    
		    $data = array(
		        
            'status' => 'Cancel',
            'cancel_remark' => $this->input->post('cancel_remark'),
            );

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
			
	 
			$this->db->where('iReportId', $id);
			$update = $this->db->update('all_reports', $data);
			
		 
			return ($update == true) ? true : false;
		}
	}



    public function approve($id)
	{
		if($id) {
		    
		    $data = array(
            'status' => 'Complete');

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
			
			$this->db->where('iReportId', $id);
			$update = $this->db->update('all_reports', $data);
			
			return ($update == true) ? true : false;
		}
	}

    /* end*/
    
    /**** CC CUBE *********/
    
	public function createcube()
	{
		$user_id = $this->session->userdata('id');
	  	 
        
       	$ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
       $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	     'report_type' => 'cc_cube',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
 
 	    $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
            
    	return ($order_id) ? $order_id : false;
	}

    public function createreport($data)
    {
        if($data) {
			$insert = $this->db->insert('cube_reports', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatecubereport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iCubeId', $id);
			$update = $this->db->update('cube_reports', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
    
    public function getcubeOrdersData($id = null)
	{
		if($id) {
		 $sql = "SELECT * FROM reports as r INNER JOIN `cube_reports` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

		$sql = "SELECT * FROM reports as r INNER JOIN `cube_reports` as c ON r.iReportId = c.iReportId where `report_type` = 'cc_cube' group by  r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

       public function getcubeOrdersDataFilter($start_date,$end_date)
	{
	    $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
	     
        $sql = "SELECT * FROM reports as r INNER JOIN `cube_reports` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
	
    public function getcubeDataByregistration($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration where  uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatecube($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
            
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function cuberemove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('reports');
            return ($delete == true) ? true : false;
		}
	}
	
	/* CC CUBE END */
	/******* Bitumen Loose Start***/
	public function createbitumenloose()
	{
		$user_id = $this->session->userdata('id');
 $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'bitumen_loose',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
  $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createbitumenloosereport($data)
    {
        if($data) {
			$insert = $this->db->insert('bitumenloose_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatebitumenloosereport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iBitumenlId', $id);
			$update = $this->db->update('bitumenloose_report', $data);
	    
			return ($update == true) ? true : false;
		}
	}
     
     public function getbitumenlooseOrdersDataFilter($start_date,$end_date)
	{
	     $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `bitumenloose_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getbitumenlooseOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `bitumenloose_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `bitumenloose_report` as c ON r.iReportId = c.iReportId where report_type = 'bitumen_loose' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getbitumenlooseDataByregistration($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration where  uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

			$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatebitumenloose($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
 
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function bitumenlooseremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('bitumenloose_report');
            return ($delete == true) ? true : false;
		}
	}
	 
	
	/****** Bitumen Loose End ***/
 
 
	/******* Bitumen Core Start***/
	public function createbitumencore()
	{
		    $user_id = $this->session->userdata('id');
	  	    
       	$ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'bitumen_core',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
  $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createbitumencorereport($data)
    {
        if($data) {
			$insert = $this->db->insert('bitumencore_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatebitumencorereport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iBitumenCId', $id);
			$update = $this->db->update('bitumencore_report', $data);
		  	//print_r($this->db->last_query());
		   
			return ($update == true) ? true : false;
		}
	}
     
    public function getbitumencoreOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `bitumencore_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
	
    public function getbitumencoreOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `bitumencore_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `bitumencore_report` as c ON r.iReportId = c.iReportId where report_type = 'bitumen_core' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getbitumencoreDataByregistration($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		//$sql = "SELECT * FROM client_registration where sample_details = 'bitumen_core' ORDER BY iClientId DESC";
		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatebitumencore($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
  
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function bitumencoreremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('bitumencore_report');
            return ($delete == true) ? true : false;
		}
	}
	 
	
	/****** Bitumen Core End ***/
 
    /********Interlocaking Tiles Start */ 
	public function createinterlockingtiles()
	{
		$user_id = $this->session->userdata('id');
	   
    	$ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'interlocking',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
  $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createinterlockingtilesreport($data)
    {
        if($data) {
			$insert = $this->db->insert('interlockingtiles_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updateinterlockingtilesreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iTilesId', $id);
			$update = $this->db->update('interlockingtiles_report', $data);
		  	//print_r($this->db->last_query());
		   
			return ($update == true) ? true : false;
		}
	}
     
      public function getinterlockingtilesOrdersDataFilter($start_date,$end_date)
	{
	   $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `interlockingtiles_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
	
    public function getinterlockingtilesOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `interlockingtiles_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `interlockingtiles_report` as c ON r.iReportId = c.iReportId  where report_type = 'interlocking' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getinterlockingtilesDataByregistration($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

	$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updateinterlockingtiles($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
  
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function interlockingtilesremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('interlockingtiles_report');
            return ($delete == true) ? true : false;
		}
	}
 
 
    /*******Interlocaking Tiles End */
    
    /********* Concrete core start*********/
    
    public function createconcretecore()
	{
		$user_id = $this->session->userdata('id');
	   	$ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
       
			
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'cc_core',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
   $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createconcretecorereport($data)
    {
        if($data) {
			$insert = $this->db->insert('concretecore_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updateconcretecorereport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iCoreId', $id);
			$update = $this->db->update('concretecore_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getconcretecoreOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `concretecore_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getconcretecoreOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `concretecore_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `concretecore_report` as c ON r.iReportId = c.iReportId where report_type = 'cc_core' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getconcretecoreDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updateconcretecore($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
                       
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function concretecoreremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('concretecore_report');
            return ($delete == true) ? true : false;
		}
	}
	 
	
    
    /**********cc core end***************/
    
    /********** Water ***************/
     public function createwater()
	{
		$user_id = $this->session->userdata('id');
	   
    $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
     $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
         
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'water',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
   $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createwaterreport($data)
    {
        if($data) {
			$insert = $this->db->insert('water_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatewaterreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iWaterId', $id);
			$update = $this->db->update('water_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getwaterOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `water_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getwaterOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `water_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `water_report` as c ON r.iReportId = c.iReportId where report_type = 'water' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getwaterDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatewater($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function waterremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
				$this->db->where('iReportId', $id);
			$delete = $this->db->delete('water_report');
            return ($delete == true) ? true : false;
		}
	}
	  
    /**********Water ***************************/
    
    /*********Main hole cover **************/
    
     public function createmainholecover()
	{
		$user_id = $this->session->userdata('id');
	  	 
    $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
      $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'mainhole_cover',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
   $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createmainholecoverreport($data)
    {
        if($data) {
			$insert = $this->db->insert('mainholecover_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatemainholecoverreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iMainholeId', $id);
			$update = $this->db->update('mainholecover_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getmainholecoverOrdersDataFilter($start_date,$end_date)
	{
	     $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `mainholecover_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getmainholecoverOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `mainholecover_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `mainholecover_report` as c ON r.iReportId = c.iReportId where report_type = 'mainhole_cover' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getmainholecoverDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatemainholecover($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
            
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function mainholecoverremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('mainholecover_report');
            return ($delete == true) ? true : false;
		}
	}
	  
     
     /***********End*********************/
    
    /*********** Ferro Cover ***********/
    
     public function createferrocover()
	{
		$user_id = $this->session->userdata('id');
	  	 
    	$ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'ferrocover',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
   $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createferrocoverreport($data)
    {
        if($data) {
			$insert = $this->db->insert('ferrocover_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updateferrocoverreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iFerroId', $id);
			$update = $this->db->update('ferrocover_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getferrocoverOrdersDataFilter($start_date,$end_date)
	{
	    $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `ferrocover_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
        //print_r($this->db->last_query());
    	return $query->result_array();
	}
	
    public function getferrocoverOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `ferrocover_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `ferrocover_report` as c ON r.iReportId = c.iReportId where report_type = 'ferrocover' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getferrocoverDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updateferrocover($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
            
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'), 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function ferrocoverremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('ferrocover_report');
            return ($delete == true) ? true : false;
		}
	}
	  
    /***********Ferro Cover End *************/
     
     /*********** Concrete Beam ***************/ 
    
    public function createconcretebeam()
	{
		$user_id = $this->session->userdata('id');
	   
    $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
        
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'concrete_beam',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
   $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createconcretebeamreport($data)
    {
        if($data) {
			$insert = $this->db->insert('concretebeam_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updateconcretebeamreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iBeamId', $id);
			$update = $this->db->update('concretebeam_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getconcretebeamOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `concretebeam_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getconcretebeamOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `concretebeam_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `concretebeam_report` as c ON r.iReportId = c.iReportId where report_type = 'concrete_beam' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getconcretebeamDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updateconcretebeam($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
                       
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function concretebeamremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('concretebeam_report');
            return ($delete == true) ? true : false;
		}
	}
	
	
   	public function finalreportremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete = $this->db->delete('reports');
		    return ($delete == true) ? true : false;
		}
	}
	
	
	 
	 
     /*********** Concrete Beam End *****************/
     
      /********** Bricks ***************/
     public function createbricks()
	{
		$user_id = $this->session->userdata('id');
	   
        $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
         
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'bricks',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
        $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createbricksreport($data)
    {
        if($data) {
			$insert = $this->db->insert('bricks_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatebricksreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iBricksId', $id);
			$update = $this->db->update('bricks_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getbricksOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `bricks_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getbricksOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `bricks_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `bricks_report` as c ON r.iReportId = c.iReportId where report_type = 'bricks' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getbricksDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatebricks($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function bricksremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
				$this->db->where('iReportId', $id);
			$delete = $this->db->delete('bricks_report');
            return ($delete == true) ? true : false;
		}
	}
	  
    /**********Bricks ***************************/
    
          /********** Mes ***************/
     public function createmes()
	{
		$user_id = $this->session->userdata('id');
	   
        $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
         
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'mes',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
        $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createmesreport($data)
    {
        if($data) {
			$insert = $this->db->insert('mes_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatemesreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iMesId', $id);
			$update = $this->db->update('mes_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getmesOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `mes_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getmesOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `mes_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `mes_report` as c ON r.iReportId = c.iReportId where report_type = 'mes' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

     
    public function getmesDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatemes($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function mesremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
				$this->db->where('iReportId', $id);
			$delete = $this->db->delete('mes_report');
            return ($delete == true) ? true : false;
		}
	}
	  
    /**********Mes ***************************/
    
    
      /********** Sand ***************/
     public function createsand()
	{
		$user_id = $this->session->userdata('id');
	   
        $ulr_no = $this->input->post('ulr_no');
    	$uid_no = $this->input->post('uid_no');
        
        $sql = "SELECT * FROM ulr_link where uid_no = '".$uid_no."' AND ulr_no = '".$ulr_no."'";
	    $query = $this->db->query($sql);
		$data =  $query->row_array(); 
		$year = date('Y',strtotime($data['date']));
		$ID = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        $ulr_no = 'NCS/LAB/'.$year.'/'.$ID;
        
         
        
    	$data = array( 
    		'uid_no' => $this->input->post('uid_no'),
    		'ulr_no' =>  $ulr_no,
    		'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    	    'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'user_id' => $user_id,
    	    'report_type' => 'sand',
    		'status' => 'Pending'
    	);

		$insert = $this->db->insert('reports', $data);
		$order_id = $this->db->insert_id();
        $data1 = array( 
    		'iReportId' => $order_id,
     	);
      	$this->db->where('uid_no', $this->input->post('uid_no'));
	    $update = $this->db->update('all_reports', $data1);
    	return ($order_id) ? $order_id : false;
	}

    public function createsandreport($data)
    {
        if($data) {
			$insert = $this->db->insert('sand_report', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatesandreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iSandId', $id);
			$update = $this->db->update('sand_report', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
     
      public function getsandOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM reports as r INNER JOIN `sand_report` as c ON r.iReportId = c.iReportId where r.create_date >='".$start_date."' AND r.create_date <= '".$end_date."' group by r.iReportId ORDER BY r.iReportId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
    public function getsandOrdersData($id = null)
	{
		if($id) {
		  $sql = "SELECT * FROM reports as r INNER JOIN `sand_report` as c ON r.iReportId = c.iReportId WHERE c.iReportId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM reports as r INNER JOIN `sand_report` as c ON r.iReportId = c.iReportId where report_type = 'sand' group by r.iReportId ORDER BY r.iReportId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
    public function getsandDataByregistration($id = null)
	{
		if($id) {
			  $sql = "SELECT * FROM client_registration where   uid_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where 1=1 ORDER BY iClientId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    
     public function updatesand($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
             
			$data = array(
            'customer_details' => $this->input->post('customer_details'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reference_no' => $this->input->post('reference_no'),
    		'material_details' => $this->input->post('material_details'),
    		'source_location' => $this->input->post('source_location'),
    		'work_order_no' => $this->input->post('work_order_no'),
    		 
    		'sample_date' => $this->input->post('sample_date'),
    		'sample_tested_date' => $this->input->post('sample_tested_date'),
    		'dispatch_date' => $this->input->post('dispatch_date'),
    		'sampled_by' => $this->input->post('sampled_by'), 
    		'environment_condition' => $this->input->post('environment_condition'),
    	    'updated_by' => $user_id,
            'updated_date' => strtotime (date('Y-m-d h:i:s'))
	    	);

			$this->db->where('iReportId', $id);
			$update = $this->db->update('reports', $data);
            return true;
		}
	}
   
   	public function sandremove($id)
	{
		if($id) {
			$this->db->where('iReportId', $id);
			$delete1 = $this->db->delete('reports');
				$this->db->where('iReportId', $id);
			$delete = $this->db->delete('sand_report');
            return ($delete == true) ? true : false;
		}
	}
	  
    /**********Sand ***************************/
    
}