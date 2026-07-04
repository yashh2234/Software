<?php 

class Model_purchaseorder extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    
   
	public function createpurchaseorder()
	{
	    $user_id = $this->session->userdata('id'); 
	      $date = date('Y-m-d',strtotime($this->input->post('date')));
	         $vendor_ref_date = date('Y-m-d',strtotime($this->input->post('vendor_ref_date')));
	    
    	$data = array(  
    		'date' =>  $date,
    		'purchase_order' => $this->input->post('purchase_order'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reporting_address' => $this->input->post('reporting_address'),
    		'vendor_ref_no' => $this->input->post('vendor_ref_no'), 
    		'vendor_ref_date' => $vendor_ref_date, 
    		'total_amount' => $this->input->post('total_amount'), 
    		'total_discount' => $this->input->post('total_discount'),
    		'transportation' => $this->input->post('transportation'),
    		'advance_amount' => $this->input->post('advance_amount'),
    		'gst_amount' => $this->input->post('gst_amount'),
    		'net_amount' => $this->input->post('net_amount'),
    		'remark' => $this->input->post('remark'), 
    	    'user_id' => $user_id,  
    	);

		$insert = $this->db->insert('purchaseorder', $data);
		$order_id = $this->db->insert_id(); 
    	return ($order_id) ? $order_id : false;
	}

    public function createpurchaseorderlist($data)
    {
        if($data) {
			$insert = $this->db->insert('purchaseorder_list', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updatepurchaseorderreport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iPlid', $id);
			$update = $this->db->update('purchaseorder_list', $data);
		  	//print_r($this->db->last_query());
		   
			return ($update == true) ? true : false;
		}
	}
     
    public function getpurchaseorderOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM purchaseorder as p INNER JOIN `purchaseorder_list` as pl ON p.iPurchaseorderId = pl.iPurchaseorderId where p.date >='".$start_date."' AND p.date <= '".$end_date."' group by pl.iPurchaseorderId ORDER BY r.iPurchaseorderId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
	
    public function getpurchaseorderOrdersData($id = null)
	{
		if($id) {
		    $sql = "SELECT * FROM purchaseorder as p INNER JOIN `purchaseorder_list` as pl ON p.iPurchaseorderId = pl.iPurchaseorderId WHERE p.iPurchaseorderId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM purchaseorder as p INNER JOIN `purchaseorder_list` as pl ON p.iPurchaseorderId = pl.iPurchaseorderId where 1=1 group by pl.iPurchaseorderId ORDER BY p.iPurchaseorderId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

     
    
     public function updatepurchaseorder($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
    $date = date('Y-m-d',strtotime($this->input->post('date')));
	         $vendor_ref_date = date('Y-m-d',strtotime($this->input->post('vendor_ref_date')));
	         
			$data = array(
            'date' =>  $date,
    		'purchase_order' => $this->input->post('purchase_order'),
    		'agency_name' => $this->input->post('agency_name'), 
    		'reporting_address' => $this->input->post('reporting_address'),
    		'vendor_ref_no' => $this->input->post('vendor_ref_no'), 
    		'vendor_ref_date' => $vendor_ref_date, 
    		'total_amount' => $this->input->post('total_amount'), 
    		'total_discount' => $this->input->post('total_discount'),
    		'transportation' => $this->input->post('transportation'),
    		'advance_amount' => $this->input->post('advance_amount'),
    		'gst_amount' => $this->input->post('gst_amount'),
    		'net_amount' => $this->input->post('net_amount'),
    		'remark' => $this->input->post('remark'), 
	    	);

			$this->db->where('iPurchaseorderId', $id);
			$update = $this->db->update('purchaseorder', $data);
            return true;
		}
	}
   
   	public function purchaseorderremove($id)
	{
		if($id) {
			$this->db->where('iPurchaseorderId', $id);
			$delete1 = $this->db->delete('purchaseorder');
			$this->db->where('iPurchaseorderId', $id);
			$delete = $this->db->delete('purchaseorder_list');
            return ($delete == true) ? true : false;
		}
	}
	 
	
	/****** Bitumen Core End ***/ 
     
}