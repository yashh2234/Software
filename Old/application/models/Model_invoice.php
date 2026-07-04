<?php 

class Model_invoice extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    
   
	public function createinvoice()
	{
	    $user_id = $this->session->userdata('id'); 
            $date = date('Y-m-d',strtotime($this->input->post('date')));
            $report_date = date('Y-m-d',strtotime($this->input->post('report_date')));
            $work_order_date = date('Y-m-d',strtotime($this->input->post('work_order_date')));
	          
    	$data = array(  
    		'date' =>  $date,
    		'invoice_no' => $this->input->post('invoice_no'),
    		'work_order_no' => $this->input->post('work_order_no'), 
    		'report_no' => $this->input->post('report_no'),
    		'report_date' => $report_date,
    		'work_order_date' => $work_order_date,
    		'agency_name' => $this->input->post('agency_name'), 
    		'agency_gst' => $this->input->post('agency_gst'),
    		'reporting_address' => $this->input->post('reporting_address'),
    		'agency_state' => $this->input->post('agency_state'),
    		'terms_of_delivery' => $this->input->post('terms_of_delivery'),
    		'total_amount' => $this->input->post('total_amount'), 
    		'total_discount' => $this->input->post('total_discount'),
    		'transportation' => $this->input->post('transportation'),
    		'advance_amount' => $this->input->post('advance_amount'),
    		'sgst_amount' => $this->input->post('sgst_amount'),
    		'cgst_amount' => $this->input->post('cgst_amount'),
    		'gst_amount' => $this->input->post('gst_amount'),
    		'net_amount' => $this->input->post('net_amount'), 
    	    'user_id' => $user_id,  
    	); 
		$insert = $this->db->insert('invoices', $data);
		$order_id = $this->db->insert_id(); 
    	return ($order_id) ? $order_id : false;
	}

    public function createinvoicelist($data)
    {
        if($data) {
			$insert = $this->db->insert('invoice_list', $data);
		//	print_r($this->db->last_query());
		
			return ($insert == true) ? true : false;
		}
    }
    public function updateinvoicereport($data, $id)
	{
		if($data && $id) {
			$this->db->where('iIlid', $id);
			$update = $this->db->update('invoice_list', $data);
		  	//print_r($this->db->last_query());
		   
			return ($update == true) ? true : false;
		}
	}
     
    public function getinvoiceOrdersDataFilter($start_date,$end_date)
	{
	  $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
	    $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
        $sql = "SELECT * FROM invoices as p INNER JOIN `invoice_list` as pl ON p.iInvoiceId = pl.iInvoiceId where p.date >='".$start_date."' AND p.date <= '".$end_date."' group by pl.iInvoiceId ORDER BY r.iInvoiceId DESC";
    	$query = $this->db->query($sql);
    	return $query->result_array();
	}
	
	
    public function getinvoiceOrdersData($id = null)
	{
		if($id) {
		    $sql = "SELECT * FROM invoices as p INNER JOIN `invoice_list` as pl ON p.iInvoiceId = pl.iInvoiceId WHERE p.iInvoiceId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

	    $sql = "SELECT * FROM invoices as p INNER JOIN `invoice_list` as pl ON p.iInvoiceId = pl.iInvoiceId where 1=1 group by pl.iInvoiceId ORDER BY p.iInvoiceId DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

     
    
     public function updateinvoice($id)
	{

		if($id) 
		{
			$user_id = $this->session->userdata('id');
			// fetch the order data 
              $date = date('Y-m-d',strtotime($this->input->post('date')));
            $report_date = date('Y-m-d',strtotime($this->input->post('report_date')));
            $work_order_date = date('Y-m-d',strtotime($this->input->post('work_order_date')));
	          
    	    $data = array(  
    		'date' =>  $date,
    		'invoice_no' => $this->input->post('invoice_no'),
    		'work_order_no' => $this->input->post('work_order_no'), 
    		'report_no' => $this->input->post('report_no'),
    		'report_date' => $report_date,
    		'work_order_date' => $work_order_date,
    		'agency_name' => $this->input->post('agency_name'), 
    		'agency_gst' => $this->input->post('agency_gst'),
    		'reporting_address' => $this->input->post('reporting_address'),
    		'agency_state' => $this->input->post('agency_state'),
    		'terms_of_delivery' => $this->input->post('terms_of_delivery'),
    		'total_amount' => $this->input->post('total_amount'), 
    		'total_discount' => $this->input->post('total_discount'),
    		'transportation' => $this->input->post('transportation'),
    		'advance_amount' => $this->input->post('advance_amount'),
    		'sgst_amount' => $this->input->post('sgst_amount'),
    		'cgst_amount' => $this->input->post('cgst_amount'),
    		'gst_amount' => $this->input->post('gst_amount'),
    		'net_amount' => $this->input->post('net_amount'), 
    	    'user_id' => $user_id,  
    	);

			$this->db->where('iInvoiceId', $id);
			$update = $this->db->update('invoices', $data);
            return true;
		}
	}
   
   	public function invoiceremove($id)
	{
		if($id) {
			$this->db->where('iInvoiceId', $id);
			$delete1 = $this->db->delete('invoices');
			$this->db->where('iInvoiceId', $id);
			$delete = $this->db->delete('invoice_list');
            return ($delete == true) ? true : false;
		}
	}
	 
	
	/****** Bitumen Core End ***/ 
     
}