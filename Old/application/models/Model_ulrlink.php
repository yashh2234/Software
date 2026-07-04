<?php 

class Model_ulrlink extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

   public function getUlrData($date)
   {
        $start_date = date('Y-m-d',strtotime($date));
        
        
        $sql = "SELECT * FROM ulr_link where date ='".$start_date."'";
    	$query = $this->db->query($sql);
     
    	return $query->result_array();
   }
   public function getulrnobyuid($uid)
   {
        
        $sql = "SELECT * FROM ulr_link where uid_no ='".$uid."'";
    	$query = $this->db->query($sql);
     
    	return $query->result_array();
   }
   public function getallOrdersData()
   { 
       $sql = "SELECT * FROM ulr_link";
         //$sql = "SELECT * FROM ulr_link where uid_no != ''";
    	$query = $this->db->query($sql); 
    	return $query->result_array();
   }
   
   public function getallFilterOrdersData($start_date,$end_date)
   { 
       $start_date = date('Y-m-d',strtotime($start_date)); 
       $end_date = date('Y-m-d',strtotime($end_date));
       $sql = "SELECT * FROM ulr_link where date BETWEEN '".$start_date."' AND '".$end_date."'";
         //$sql = "SELECT * FROM ulr_link where uid_no != ''";
    	$query = $this->db->query($sql); 
    	return $query->result_array();
   }
   
   
   public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('ulr_link', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
	
	
   public function getolderUlrData($id)
   {
        
        $sql = "SELECT * FROM ulr_copy where ulr_no = '".$id."'";
    	$query = $this->db->query($sql); 
    	return $query->result_array();
   }
   
   
    public function getulrdatarow($ulr_no = null)
	{
		if($ulr_no) {
			$sql = "SELECT * FROM ulr_link where  ulr_no = ?";
			$query = $this->db->query($sql, array($ulr_no));
		  	return $query->row_array();
		}
 
	}
	
   public function getDataByregistration($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration where  uid_no = ?";
			$query = $this->db->query($sql, array($id));
		 
			return $query->row_array();
		
		}
 
	}
	public function checkassinguidno($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM ulr_link where  uid_no != '' AND ulr_no = ?";
			$query = $this->db->query($sql, array($id));
		  
			return $query->row_array();
		
		}
 
	}
	
	public function checkassingulrno($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM ulr_link where  uid_no = ?";
			$query = $this->db->query($sql, array($id));
			 
		return $query->result_array();
		 
		}
 
	}
	public function createnewulr($data)
    {
        if($data) {
			$insert = $this->db->insert('ulr_link', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function copyolduidrecords($data)
    {
        if($data) {
			$insert = $this->db->insert('ulr_copy', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    
    
    
    public function updateulrno($data, $id,$date)
	{
		if($data && $id && $date) {
			$this->db->where('ulr_no', $id);
			$this->db->where('date', $date);
			$update = $this->db->update('ulr_link', $data);
		 	 
			return ($update == true) ? true : false;
		}
	}
    public function remove($id)
	{

		if($id) 
		{
		 	$data = array(
            'uid_no' => '',
    		'name_of_department' => '', 
    		'name_of_agency' => '',
    		'name_of_project' => '',
    		'sample_details' => '',
    	 	);

			$this->db->where('id', $id);
			$update = $this->db->update('ulr_link', $data);
            return true;
		}
	}
   
}