<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Finallabreports extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'All Reports';
        
       $this->load->model('model_company'); 
       $this->load->model('model_users');
       $this->load->model('model_labreports');
        
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Report';
		$this->render_template('finalreports/index', $this->data);		
	}
	
    function export()
    {
        
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
       if($start_date != '' && $end_date != '')
       {
		    $data['orders'] = $this->model_labreports->getOrdersDatabyFilter($start_date,$end_date);
       }
       else
       {
            $data['orders'] = $data = $this->model_labreports->getOrdersData();
       }
		
	 
        $this->load->view('orders/export', $data);    
    } 
    
     
	public function fetchOrdersData()
	{
		$result = array('data' => array());

		$data = $this->model_labreports->getfinalallOrdersData();
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
            $url = '';
            
            if($value['report_type'] == 'cc_core')
            {
                $url = 'concretecore/update/'.$value['iReportId'];
            }
            else if($value['report_type'] == 'bitumen_loose')
            {
                $url = 'bitumenloose/update/'.$value['iReportId'];
            }
            else if($value['report_type'] == 'bitumen_core')
            {
                $url = 'bitumencore/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'interlocking')
            {
                $url = 'interlockingtiles/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'cc_cube')
            {
                $url = 'cubereport/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'water')
            {
                $url = 'water/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'ferrocover')
            {
                $url = 'ferrocover/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'mainhole_cover')
            {
                $url = 'mainholecover/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'concretebeam')
            {
                $url = 'concretebeam/update/'.$value['iReportId'];
            }
             else
            if($value['report_type'] == 'bricks')
            {
                $url = 'bricks/update/'.$value['iReportId'];
            }        
            else
            {
                $url = '';
            }
             
            
			if(in_array('viewOrder', $this->permission) && $url != '') 
			{
				$buttons .= '<a href="'.base_url($url).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}
            if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			$status = '';
			 
            if($value['status'] == 'Complete' || $value['status'] == 'complete')
            {
                $status = '<span class="label label-success">Approved</span>';
            }
            else if($value['status'] == 'Pending' || $value['status'] == 'pending')
            {
				$status = '<span class="label label-warning">Pending</span>';
			}
			else if($value['status'] == 'Cancel' || $value['status'] == 'cancel')
			{
				$status = '<span class="label label-danger">Cancel</span>';
			}
 
 
            
            $uid_no = '<a href="'.base_url($url).'">'.$value['uid_no'].'</a>';
            
            
            $date = date('d M Y',strtotime($value['create_date']));
			$date_time = $date;
                
			    $result['data'][$key] = array(
				$date_time,
				$uid_no,
				$value['ulr_no'],
				$value['customer_details'],
				$value['agency_name'],
				$value['reference_no'],
				$value['material_details'],
				$value['source_location'],
				$value['work_order_no'],
			    $value['sample_date'],
			    $value['sample_tested_date'], 
				$status,
				$buttons
		    	);
	 
}
		echo json_encode($result);
	    
	}
 	public function fetchOrdersFilterData()
	{
	   $result = array('data' => array());
	   $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_labreports->getfinalallOrdersDataFilter($start_date,$end_date); 
 
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
            $url = '';
            
            if($value['report_type'] == 'cc_core')
            {
                $url = 'concretecore/update/'.$value['iReportId'];
            }
            else if($value['report_type'] == 'bitumen_loose')
            {
                $url = 'bitumenloose/update/'.$value['iReportId'];
            }
            else if($value['report_type'] == 'bitumen_core')
            {
                $url = 'bitumencore/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'interlocking')
            {
                $url = 'interlockingtiles/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'cc_cube')
            {
                $url = 'cubereport/update/'.$value['iReportId'];
            }
            else
            if($value['report_type'] == 'water')
            {
                $url = 'water/update/'.$value['iReportId'];
            }
            else
            {
                $url = '';
            }
             
            
			if(in_array('viewOrder', $this->permission) && $url != '') 
			{
				$buttons .= '<a href="'.base_url($url).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}
            if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			$status = '';
			 
            if($value['status'] == 'Complete' || $value['status'] == 'complete')
            {
                $status = '<span class="label label-success">Approved</span>';
            }
            else if($value['status'] == 'Pending' || $value['status'] == 'pending')
            {
				$status = '<span class="label label-warning">Pending</span>';
			}
			else if($value['status'] == 'Cancel' || $value['status'] == 'cancel')
			{
				$status = '<span class="label label-danger">Cancel</span>';
			}
 
 
            
            $uid_no = '<a href="'.base_url($url).'">'.$value['uid_no'].'</a>';
            
            
            $date = date('d M Y',strtotime($value['create_date']));
			$date_time = $date;
                
			    $result['data'][$key] = array(
				$date_time,
				$uid_no,
				$value['customer_details'],
				$value['agency_name'],
				$value['reference_no'],
				$value['material_details'],
				$value['source_location'],
				$value['work_order_no'],
			    $value['sample_date'],
			    $value['sample_tested_date'], 
				$status,
				$buttons
		    	);
	 
}
		echo json_encode($result);
	    
	}
	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$iReportId = $this->input->post('iReportId');

        $response = array();
        if($iReportId) {
            $delete = $this->model_labreports->finalreportremove($iReportId);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}
 
 
 
   
}