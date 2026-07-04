<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Duereports extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Due Reports';
        
       $this->load->model('model_company'); 
       $this->load->model('model_users');
       $this->load->model('model_labreports');
       $this->load->model('model_registration');
        
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Due Report';
		$this->render_template('duereports/index', $this->data);		
	}
	 
     
	public function fetchOrdersData()
	{
		$result = array('data' => array());

	
		
		$result = array('data' => array());
        $user_id = $this->session->userdata('id');
        $groupdata = $this->model_users->getUserGroup($user_id); 
        $groupid = $groupdata['id']; 
       
        
		$data = $this->model_registration->getfinalallDueOrdersData();
		 
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            
            
		    $is_admin = ($user_id == 1) ? true :false;
		      $url = '';
		       
            $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  $name_of_work =  $value['name_of_work'];
            
            
            if($value['total_payment'] != '')
            {
                $total_payment = $value['total_payment'];
            }
            else
            {
                $total_payment = '<p style="background-color:yellow;padding:5px;">Payment Not Update</p>';
            }
            $uid_no = '<a href="javascript:void(0);" onclick="editRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal">'.$value['uid_no'].'</a>';
             if($value['scan_copy'] != '')
                {
                    $scan_copy0 = '<a href="'.$value['scan_copy'].'" target="_blank">Copy 1</a></br>';
                }
                else
                {
                   $scan_copy0 = ''; 
                }
                if($value['scan_copy_1'] != '')
                {
                    $scan_copy1 = '<a href="'.$value['scan_copy_1'].'" target="_blank">Copy 2</a></br>';
                }
                else
                {
                   $scan_copy1 = ''; 
                }
                if($value['scan_copy_2'] != '')
                {
                    $scan_copy2 = '<a href="'.$value['scan_copy_2'].'" target="_blank">Copy 3</a></br>';
                }
                else
                {
                   $scan_copy2 = ''; 
                }
                if($value['scan_copy_3'] != '')
                {
                    $scan_copy3 = '<a href="'.$value['scan_copy_3'].'" target="_blank">Copy 4</a></br>';
                }
                else
                {
                   $scan_copy3 = ''; 
                }
                if($value['scan_copy_4'] != '')
                {
                    $scan_copy4 = '<a href="'.$value['scan_copy_4'].'" target="_blank">Copy 5</a></br>';
                }
                else
                {
                   $scan_copy4 = ''; 
                }
                 
                
                $scan_copy = $scan_copy0.$scan_copy1.$scan_copy2.$scan_copy3.$scan_copy4;
                
                 
                  if($value['report_copy'] != '')
                {
                    $report_copy = '<a href="'.base_url().'assets/images/report_copy/'.$value['report_copy'].'" target="_blank">View Report</a>';
                }
                else
                {
                   $report_copy = ''; 
                }
                
            if($groupid == 1 || $groupid == 8)
            {
                $result['data'][$key] = array(
			        $uid_no,
                    $date_time,
    		        $value['agency_name'],
    		        $value['reporting_address'], 
    				$value['mobile_no'],
                    $name_of_work,	
                    $value['sample_details'],
                    $total_payment,
                   	$value['advance_payment'],
                   	$value['balance_dues'], 
    			    $scan_copy,
    			    $report_copy,
                    $buttons 
			    );
            }
            else
            { 
                $result['data'][$key] = array(
    			        $uid_no,
                        $date_time,
                        $value['agency_name'],
                        $value['reporting_address'], 
                        $value['mobile_no'],
                        $name_of_work,	
                        $value['sample_details'],
                        $scan_copy,
                       	$report_copy
    			);
            }
            
			
		} // /foreach

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