<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Registration Details';

		$this->load->model('model_registration');
		$this->load->model('model_labreports');
		$this->load->model('model_billing');
		$this->load->model('model_users');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
	    
		if(!in_array('viewRegistration', $this->permission)) 
		{
			redirect('dashboard', 'refresh');
		}
        $result = $this->model_registration->getBillingData();
        $user_id = $this->session->userdata('id');
        $groupdata = $this->model_users->getUserGroup($user_id); 
         $groupid = $groupdata['id']; 
        $this->data['groupid'] = $groupid;
        $this->data['results'] = $result;
        $this->render_template('registration/index', $this->data);
	}
 
	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	public function fetchbillingData()
	{
		$result = array('data' => array());
        $user_id = $this->session->userdata('id');
        $groupdata = $this->model_users->getUserGroup($user_id); 
        $groupid = $groupdata['id']; 
           
        if($groupid == 1 || $groupid == 8)
        {
        	$data = $this->model_registration->getBillingData();
        }
        else
        {
        	$data = $this->model_registration->getlabBillingData();
        }
	
		 
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            
            
		    $is_admin = ($user_id == 1) ? true :false;
		      $url = '';
		      
		      $getallreportid = $this->getallreportsid($value['uid_no']); 
		      
            
		 	if(in_array('viewRegistration', $this->permission)) 
    			{
    			    if($user_id == 1)
    			    {
    				    $buttons .= '<button type="button" class="btn btn-default" onclick="editRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    			    }
    			    else
    			    {
    			            $buttons .= '<button type="button" class="btn btn-default" onclick="editRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    			    }
    			}
    			
    			if(in_array('viewOrder', $this->permission)) 
			    {
				    $buttons.= $getallreportid;
			    }
			
    			if(in_array('deleteRegistration', $this->permission)) 
    			{
    				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#removeRegistrationModal"><i class="fa fa-trash"></i></button>
    				';
    			}	
		     
		     
			    
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
		 
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_registration->getBillingDatabyFilter($start_date,$end_date); 
		
		$user_id = $this->session->userdata('id');
        $groupdata = $this->model_users->getUserGroup($user_id); 
        $groupid = $groupdata['id']; 
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		    $is_admin = ($user_id == 1) ? true :false;
		      $url = '';
            $data1 = $this->model_labreports->getuidDataapprovedstatus($value['uid_no']);
            if(isset($data1[0]['status'])){
               
                if($data1[0]['status'] == 'Complete')
                {
                
                      if($data1[0]['report_type'] == 'cc_core')
                    {
                        $url = 'concretecore/printDiv/'.$data1[0]['iReportId'];
                    }
                    else if($data1[0]['report_type'] == 'bitumen_loose')
                    {
                        $url = 'bitumenloose/printDiv/'.$data1[0]['iReportId'];
                    }
                    else if($data1[0]['report_type'] == 'bitumen_core')
                    {
                        $url = 'bitumencore/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'interlocking')
                    {
                        $url = 'interlockingtiles/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'cc_cube')
                    {
                        $url = 'cubereport/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'water')
                    {
                        $url = 'water/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'ferro_cover')
                    {
                        $url = 'ferrocover/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'mainhole_cover')
                    {
                        $url = 'mainholecover/printDiv/'.$data1[0]['iReportId'];
                    }
                    else
                    if($data1[0]['report_type'] == 'concretebeam')
                    {
                        $url = 'concretebeam/printDiv/'.$data1[0]['iReportId'];
                    }
                     
                    else
                    {
                        $url = '';
                    }
               }
                else
                {
                    $url = '';
                }
            }
            else
            {
                $url = '';
            }
		 	if(in_array('viewRegistration', $this->permission)) 
    			{
    			    if($user_id == 1)
    			    {
    				    $buttons .= '<button type="button" class="btn btn-default" onclick="editRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    			    }
    			    else
    			    {
    			            $buttons .= '<button type="button" class="btn btn-default" onclick="editRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    			    }
    			}
    			
    			if(in_array('viewOrder', $this->permission) && $url != '') 
			    {
				$buttons .= '<a href="'.base_url($url).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			    }
			
    			if(in_array('deleteRegistration', $this->permission)) 
    			{
    				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeRegistration('.$value['iClientId'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    				';
    			}	
		     
		       
            $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			
             
                $name_of_work =  substr($value['name_of_work'], 0, 80)."..";
             
            
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
                    $scan_copy1 = '<a href="'.$value['scan_copy_1'].'" target="_blank"> Copy 2</a></br>';
                }
                else
                {
                   $scan_copy1 = ''; 
                }
                if($value['scan_copy_2'] != '')
                {
                    $scan_copy2 = '<a href="'.$value['scan_copy_2'].'" target="_blank"> Copy 3</a></br>';
                }
                else
                {
                   $scan_copy2 = ''; 
                }
                if($value['scan_copy_3'] != '')
                {
                    $scan_copy3 = '<a href="'.$value['scan_copy_3'].'" target="_blank"> Copy 4</a></br>';
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


    public function getallreportsid($uid_no)
    {
        
        $data1 = $this->model_labreports->getuidDataapprovedstatus($uid_no);
            $buttons1 = '';
            foreach ($data1 as $key => $value1) {
                  if(isset($value1['status'])){
                   
                    if($value1['status'] == 'Complete')
                    {
                    
                        if($value1['report_type'] == 'cc_core')
                        {
                            $url = 'concretecore/printDiv/'.$value1['iReportId'];
                        }
                        else if($value1['report_type'] == 'bitumen_loose')
                        {
                            $url = 'bitumenloose/printDiv/'.$value1['iReportId'];
                        }
                        else if($value1['report_type'] == 'bitumen_core')
                        {
                            $url = 'bitumencore/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'interlocking')
                        {
                            $url = 'interlockingtiles/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'cc_cube')
                        {
                            $url = 'cubereport/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'water')
                        {
                            $url = 'water/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'ferro_cover')
                        {
                            $url = 'ferrocover/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'mainhole_cover')
                        {
                            $url = 'mainholecover/printDiv/'.$value1['iReportId'];
                        }
                        else
                        if($value1['report_type'] == 'concretebeam')
                        {
                            $url = 'concretebeam/printDiv/'.$value1['iReportId'];
                        }
                         
                        else
                        {
                            $url = '';
                        }
                   }
                    else
                    {
                        $url = '';
                    }
                }
                else
                {
                    $url = '';
                }
                $buttons1 .= '<a href="'.base_url($url).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
            }
            return $buttons1;
    }
    function export()
    {
        
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
       if($start_date != '' && $end_date != '')
       {
		    $data['registration'] = $this->model_registration->getBillingDatabyFilter($start_date,$end_date);
       }
       else
       {
            $data['registration'] = $this->model_registration->getBillingData();
       }
	    $this->load->view('registration/export', $data);    
    }
    
    public function fetchbillingDataById($id)
	{
		if($id) {
			$data = $this->model_registration->getBillingData($id);
			echo json_encode($data);
		}

		return false;
	}
	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
        
		if(!in_array('createRegistration', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('agency_name', 'Agency Name', 'trim|required');
		$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        $date_time = date('Y-m-d',strtotime($this->input->post('date')));
        
        $month = date('M',strtotime($this->input->post('date')));
        
 	    $prepared_date = date('Y-m-d',strtotime($this->input->post('prepared_date')));
        $dispatch_date = date('Y-m-d',strtotime($this->input->post('dispatch_date')));
	                
        if($date_time == '1970-01-01')
        {
            $date_time1 = '';
        }
        else
        {
            $date_time1 = $date_time;
        }
        
        if($prepared_date == '1970-01-01')
        {
            $prepared_date1 = '';
        }
        else
        {
            $prepared_date1 = $prepared_date;
        }
        
        if($dispatch_date == '1970-01-01')
        {
            $dispatch_date1 = '';
        }
        else
        {
            $dispatch_date1 = $dispatch_date;
        }
        
        
        
                if ($this->form_validation->run() == TRUE) 
        	    {
        	           $upload_image = $this->upload_report(); 
             if(!empty($upload_image[0]['file_name'])){
                 $upload_image0 = $upload_image[0]['file_name'];
             }
             else
             {
                 $upload_image0 = '';
             }
             
                    $data = array(
            	    'received_date' => $date_time1,
            	    'month' => $month,
            	    'agency_name' => $this->input->post('agency_name'),
            		'reporting_address' => $this->input->post('reporting_address'),
            		 'mobile_no' => $this->input->post('mobile_no'),  
                    'new_back' => $this->input->post('new_back'), 
                    'new_back_1' => $this->input->post('new_back_1'),
                    'new_back_2' => $this->input->post('new_back_2'),
                    'new_back_3' => $this->input->post('new_back_3'),
                    'new_back_4' => $this->input->post('new_back_4'), 
                    'sample_test' => $this->input->post('sample_test'), 
                    'sample_details' => $this->input->post('sample_details'),
                    'sample_details_1' => $this->input->post('sample_details_1'),
                    'sample_details_2' => $this->input->post('sample_details_2'),
                    'sample_details_3' => $this->input->post('sample_details_3'),
                    'sample_details_4' => $this->input->post('sample_details_4'),
            		'qty' => $this->input->post('qty'),
            		'qty_1' => $this->input->post('qty_1'),
            		'qty_2' => $this->input->post('qty_2'),
            		'qty_3' => $this->input->post('qty_3'),
            		'qty_4' => $this->input->post('qty_4'),
            		'witness' => $this->input->post('witness'),
            	    'prepared_date' => $prepared_date1,
            		'dispatch_date' => $dispatch_date1,
            		'report_no' => $this->input->post('report_no'),
            		'field_person_name' => $this->input->post('field_person_name'),
            	    'sample_remark' => $this->input->post('sample_remark'),
            		'remark' => $this->input->post('remark'),
                    'advance_payment' => $this->input->post('advance_payment'),
                    'balance_dues' => $this->input->post('balance_dues'),
                    'total_payment' => $this->input->post('total_payment'),
                    'payment_followup' => $this->input->post('payment_followup'),
                    'financial_remark' => $this->input->post('financial_remark'),
                    'mode_of_payment' => $this->input->post('mode_of_payment'),
                    'name_of_work' => $this->input->post('name_work'),
                    'work' => $this->input->post('work'),
                    'work_order_no' => $this->input->post('work_orders_no'),
                    'reference' => $this->input->post('references'),
                    'report_status' => $this->input->post('report_status'),
                    'report_copy' => $upload_image0,
                    'gst_no' => $this->input->post('gst_no'),
                    'sample_nos' => $this->input->post('sample_nos'),
                    'scan_copy' => $this->input->post('scan_copy_image'),
                    'scan_copy_1' => $this->input->post('scan_copy_image1'),
                    'scan_copy_2' => $this->input->post('scan_copy_image2'),
                    'scan_copy_3' => $this->input->post('scan_copy_image3'),
                    'scan_copy_4' => $this->input->post('scan_copy_image4'),
                    'assign_to' => $this->input->post('assign_to'),
            	);
                   
                   $datareg = $this->model_registration->getBillingDatalastsno($date_time1);
                   
                	$create = $this->model_registration->create($data);
                	$insert_id = $this->db->insert_id();
                	 
                	$lastsno = $datareg['sno'];
                	$date1 = date('d');
                	$month1 = date('m');
                	
                	
                	/*
                	if($date1 == '01' && $month1 == '01' )
                	{
                	    $newsno = 1;
                	}
                	else
                	{
                	    $newsno = $lastsno+1;
                	}
                	*/
                	
                	  $newsno = $lastsno+1;
                	
                	  $ID = str_pad($newsno, 5, '0', STR_PAD_LEFT);
                	 
                	$year = date('Y');
                    $uid_no = 'NAMO/MC/'.$year.'/'.$ID; 
                	 $data1 = array
                	 (
                	     'month' => $month,
            	         'uid_no' => $uid_no,
            	         'sno' => $newsno,
            	     );
            	      
                	$create = $this->model_registration->update($data1,$insert_id);
                	
                	
                	$data2 = array
                	 (
            	        'uid_no' => $uid_no,
            	        'sample_details' => $this->input->post('sample_details'),
            	        'status' => 'Pending',
            	        'date' => $date_time1,
            	     );
                	$create = $this->model_registration->create_report($data2);
                	
                	
                	
                	$data3 = array
                	(
                	    'uid_no' => $uid_no,
                	    'advance_amount' => $this->input->post('advance_payment'),
                        'due_amount' => $this->input->post('balance_dues'),
                        'bill_amount' => $this->input->post('total_payment'), 
                        'remark' => $this->input->post('financial_remark'), 
            	    );
                    $create = $this->model_billing->create($data3);
                   
                    $bill_amount =  $this->input->post('total_payment');
                    $advance_amount = $this->input->post('advance_payment');
                    $due_amount = $this->input->post('balance_dues');
                    $agency_name = $this->input->post('agency_name');
                    //$mobile_no = $this->input->post('mobile_no');
            		 
                    if($bill_amount > 0 && $advance_amount > 0 && $due_amount >0)
                    {
                        $message1 = "Hello ".$agency_name.",
We have received your payment of Rs".$advance_amount.". Your remaining amount is Rs".$due_amount.".
You may pay by visiting our office. 
Thank you
From Namotech";

        // $mobile_no =   $data['mobile_no'];
            $mobile_no =   '918114428016,'.$data['mobile_no'];
            $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
        	$name = 'test';
        	$amount = '110';
        	// Message details
        	$numbers = array($mobile_no);
        	$sender = urlencode('NAMOTH');  
        	$message =  urlencode($message1); 
        	$numbers = implode(',', $numbers);
         
        	// Prepare data for POST request
        	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
        	// Send the POST request with cURL
        	$ch = curl_init('https://api.textlocal.in/send/');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$response1 = curl_exec($ch);
        	
        	//print_r($response);
        	curl_close($ch);
                   
                    }
                    else if($bill_amount > 0 && $advance_amount > 0 && $due_amount == 0)
                    {
                        $message1 = "Hello ".$agency_name.",
We have received your payment of Rs".$advance_amount.".
Thank you
From Namotech";

// $mobile_no =   $data['mobile_no'];
            $mobile_no =   '918114428016,'.$data['mobile_no'];
            $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
        	$name = 'test';
        	$amount = '110';
        	// Message details
        	$numbers = array($mobile_no);
        	$sender = urlencode('NAMOTH');  
        	$message =  urlencode($message1); 
        	$numbers = implode(',', $numbers);
         
        	// Prepare data for POST request
        	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
        	// Send the POST request with cURL
        	$ch = curl_init('https://api.textlocal.in/send/');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$response1 = curl_exec($ch);
        	
        	//print_r($response);
        	curl_close($ch);
                   
                    }
                    
                    
                    
                   
                 	if($create == true) {
                		$response['success'] = true;
                		$response['messages'] = 'Succesfully created';
                	}
                	else {
                		$response['success'] = false;
                		$response['messages'] = 'Error in the database while creating the brand information';			
                	}
                }
                 else {
                	$response['success'] = false;
                	foreach ($_POST as $key => $value) {
                		$response['messages'][$key] = form_error($key);
                	}
                }
             
        	
        	 

        echo json_encode($response);

	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateRegistration', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

        $user_id = $this->session->userdata('id');
		$response = array();

		if($id) {
		  
            $this->form_validation->set_rules('edit_agency_name', 'Agency Name', 'trim|required');
			$this->form_validation->set_rules('edit_mobile_no', 'Mobile Number', 'trim|required');
     
    		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
    		
		    if ($this->form_validation->run() == TRUE) 
	            {
	                
	                 
        $date_time = date('Y-m-d',strtotime($this->input->post('edit_date')));
        
        $month = date('M',strtotime($this->input->post('edit_date')));
        
 	    $prepared_date = date('Y-m-d',strtotime($this->input->post('edit_prepared_date')));
        $dispatch_date = date('Y-m-d',strtotime($this->input->post('edit_dispatch_date')));
	                
        if($date_time == '1970-01-01')
        {
            $date_time1 = '';
        }
        else
        {
            $date_time1 = $date_time;
        }
        
        if($prepared_date == '1970-01-01')
        {
            $prepared_date1 = '';
        }
        else
        {
            $prepared_date1 = $prepared_date;
        }
        
        if($dispatch_date == '1970-01-01')
        {
            $dispatch_date1 = '';
        }
        else
        {
            $dispatch_date1 = $dispatch_date;
        }
        
       	$olddata1 = $this->model_registration->getBillingData($id);
        $report_copy = $_FILES['edit_report_copy']['name'];
        if($report_copy != '')
        {
              $upload_image = $this->upload_editreport(); 
             if(!empty($upload_image[0]['file_name'])){
                 $report_copyn = $upload_image[0]['file_name'];
             }
             else
             {
                 $report_copyn = '';
             }
        }
        else
        {
            $report_copyn = $this->input->post('edit_old_report_copy');
        }
        if($olddata1)
        {
             
            $olddata = array(
                'uid_no' => $olddata1['uid_no'],
                'ulr_no' => $olddata1['ulr_no'],
                'received_date' => $olddata1['received_date'],
                'agency_name' => $olddata1['agency_name'],
                'reporting_address' => $olddata1['reporting_address'],
                'mobile_no' => $olddata1['mobile_no'],
                'dist' => $olddata1['dist'],
                'payment_followup' => $olddata1['payment_followup'],
                'new_back' => $olddata1['new_back'],
                'sample_details' => $olddata1['sample_details'],
                'qty' => $olddata1['qty'],
                'witness' => $olddata1['witness'],
                'prepared_date' => $olddata1['prepared_date'],
                'dispatch_date' => $olddata1['dispatch_date'],
                'report_no' => $olddata1['report_no'],
                'field_person_name' =>$olddata1['field_person_name'],
                'sample_remark' => $olddata1['sample_remark'],
                'remark' => $olddata1['remark'],
                'advance_payment' => $olddata1['advance_payment'],
                'balance_dues' => $olddata1['balance_dues'],
                'total_payment' => $olddata1['total_payment'],
                'payment_followup' => $olddata1['payment_followup'],
                'financial_remark' => $olddata1['financial_remark'],
                'mode_of_payment' => $this->input->post('edit_mode_of_payment'),
                'name_of_work' => $olddata1['name_of_work'],
                'work_order_no' => $olddata1['work_order_no'],
                'reference' => $olddata1['reference'],
                
                'updated_by' => $user_id,
                
            	);
	            $update1 = $this->model_registration->create_registrationcopy($olddata);
        }
    
     
        	       $data = array(
                        'agency_name' => $this->input->post('edit_agency_name'),
                        'reporting_address' => $this->input->post('edit_reporting_address'),
                        'mobile_no' => $this->input->post('edit_mobile_no'),
                        'dist' => $this->input->post('edit_dist'),
                        'payment_followup' => $this->input->post('edit_payment_followup'),
                        'new_back' => $this->input->post('edit_new_back'),
                        'new_back_1' => $this->input->post('edit_new_back_1'),
                        'new_back_2' => $this->input->post('edit_new_back_2'),
                        'new_back_3' => $this->input->post('edit_new_back_3'),
                        'new_back_4' => $this->input->post('edit_new_back_4'),
                         'sample_test' => $this->input->post('edit_sample_test'),
                        'sample_details' => $this->input->post('edit_sample_details'),
                        'sample_details_1' => $this->input->post('edit_sample_details_1'),
                        'sample_details_2' => $this->input->post('edit_sample_details_2'),
                        'sample_details_3' => $this->input->post('edit_sample_details_3'),
                        'sample_details_4' => $this->input->post('edit_sample_details_4'),
                		'qty' => $this->input->post('edit_qty'),
                		'qty_1' => $this->input->post('edit_qty_1'),
                		'qty_2' => $this->input->post('edit_qty_2'),
                		'qty_3' => $this->input->post('edit_qty_3'),
                		'qty_4' => $this->input->post('edit_qty_4'), 
                        'witness' => $this->input->post('edit_witness'), 
                        'prepared_date' => $prepared_date1,
                        'dispatch_date' => $dispatch_date1,
                        'report_no' => $this->input->post('edit_report_no'),
                        'field_person_name' => $this->input->post('edit_field_person_name'),
                        'sample_remark' => $this->input->post('edit_sample_remark'),
                        'remark' => $this->input->post('edit_remark'),
                        'work' => $this->input->post('edit_work'),
                        'advance_payment' => $this->input->post('edit_advance_payment'),
                        'balance_dues' => $this->input->post('edit_balance_dues'),
                        'total_payment' => $this->input->post('edit_total_payment'),
                        'payment_followup' => $this->input->post('edit_payment_followup'), 
                        'financial_remark' => $this->input->post('edit_financial_remark'),
                        'mode_of_payment' => $this->input->post('edit_mode_of_payment'),
                        'name_of_work' => $this->input->post('edit_name_work'),
                        'work_order_no' => $this->input->post('edit_work_orders_no'),
                        'reference' => $this->input->post('edit_references'),
                        'report_status' => $this->input->post('edit_report_status'), 
                        'gst_no' => $this->input->post('edit_gst_no'),
                        'sample_nos' => $this->input->post('edit_sample_nos'),
                        'assign_to' => $this->input->post('edit_assign_to'),
                        'report_copy' => $report_copyn,
                    	);
	               $update = $this->model_registration->update($data, $id);
	        	
	        	/************sms send */
	        	    $bill_amount =  $this->input->post('edit_total_payment');
                    $advance_amount = $this->input->post('edit_advance_payment');
                    $due_amount = $this->input->post('edit_balance_dues');
                    $agency_name = $this->input->post('edit_agency_name');
                    $mobile_no1 = $this->input->post('edit_mobile_no');
					
					 
    					if($bill_amount > 0 && $advance_amount > 0 && $due_amount > 0)
                        {
                            $message1 = "Hello ".$agency_name.",
    We have received your payment of Rs".$advance_amount.". Your remaining amount is Rs".$due_amount.".
    You may pay by visiting our office. 
    Thank you
    From Namotech";
    
            // $mobile_no =   $data['mobile_no'];
                $mobile_no =   '918114428016,'.$mobile_no1;
                $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
            	$name = 'test';
            	$amount = '110';
            	// Message details
            	$numbers = array($mobile_no);
            	$sender = urlencode('NAMOTH');  
            	$message =  urlencode($message1); 
            	$numbers = implode(',', $numbers);
             
            	// Prepare data for POST request
            	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
             
            	// Send the POST request with cURL
            	$ch = curl_init('https://api.textlocal.in/send/');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$response1 = curl_exec($ch);
            	
            	//print_r($response);
            	curl_close($ch);
                       
                        }
                        else if($bill_amount > 0 && $advance_amount > 0 && $due_amount == 0)
                        {
                            $message1 = "Hello ".$agency_name.",
    We have received your payment of Rs".$advance_amount.".
    Thank you
    From Namotech";
    
    // $mobile_no =   $data['mobile_no'];
                $mobile_no =   '918114428016,'.$mobile_no1;
                $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
            	$name = 'test';
            	$amount = '110';
            	// Message details
            	$numbers = array($mobile_no);
            	$sender = urlencode('NAMOTH');  
            	$message =  urlencode($message1); 
            	$numbers = implode(',', $numbers);
             
            	// Prepare data for POST request
            	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
             
            	// Send the POST request with cURL
            	$ch = curl_init('https://api.textlocal.in/send/');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$response1 = curl_exec($ch);
            	
            	//print_r($response);
            	curl_close($ch);
                       
                        }
                    
                    /*********************/
                    
	        	    $uid_no = $olddata1['uid_no'];
	        	    $data3 = array
                	(
                	    
                	    'advance_amount' => $this->input->post('edit_advance_payment'),
                        'due_amount' => $this->input->post('edit_balance_dues'),
                        'bill_amount' => $this->input->post('edit_total_payment'), 
                        'remark' => $this->input->post('edit_financial_remark'), 
                        'payment_followup' => $this->input->post('edit_payment_followup'),
            	    );
                    $create = $this->model_billing->updatebyuid($data3,$uid_no);
                    
                    
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteRegistration', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$id = $this->input->post('id');
		$response = array();
		if($id) {
			$delete = $this->model_registration->remove($id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}
    public function upload()
    {  
            $upload_image = $this->upload_image(); 
             if(!empty($upload_image[0]['file_name'])){
                 $upload_image0 = $upload_image[0]['file_name'];
             }
             else
             {
                 $upload_image0 = '';
             }
             if(!empty($upload_image[1]['file_name'])){
                 $upload_image1 = $upload_image[1]['file_name'];
             }
             else
             {
                 $upload_image1 = '';
             }
             if(!empty($upload_image[2]['file_name'])){
                 $upload_image2 = $upload_image[2]['file_name'];
             }
             else
             {
                 $upload_image2 = '';
             }
             if(!empty($upload_image[3]['file_name'])){
                 $upload_image3 = $upload_image[3]['file_name'];
             }
             else
             {
                 $upload_image3 = '';
             }
             if(!empty($upload_image[4]['file_name'])){
                 $upload_image4 = $upload_image[4]['file_name'];
             }
             else
             {
                 $upload_image4 = '';
             }
            	$data = array(
            		'image' => base_url().'assets/images/scan_copy/'.$upload_image0,
            		'image1' => base_url().'assets/images/scan_copy/'.$upload_image1,
            		'image2' => base_url().'assets/images/scan_copy/'.$upload_image2,
            		'image3' => base_url().'assets/images/scan_copy/'.$upload_image3,
            		'image4' => base_url().'assets/images/scan_copy/'.$upload_image4,
            	);

        	$create = $this->model_registration->createscan_copy($data);
        	if($create == true) {
        
                $data1['success'] = true;
               
                $data1['image'] =  $upload_image0;
                $data1['image1'] =  $upload_image1;
                $data1['image2'] =  $upload_image2;
                $data1['image3'] =  $upload_image3;
                $data1['image4'] =  $upload_image4;
                $data1['messages'] = "Successfully Update"; 
            }
        	else {
        		$data1['success'] = false;
                $data1['messages'] = "Refersh the page again !";  
        	}
        echo json_encode($data1); 
    }
 
 	public function upload_image()
    {
    	$this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['scan_copy']['name']);
        for($i=0; $i<$cpt; $i++)
        {           
            $_FILES['scan_copy']['name']= $files['scan_copy']['name'][$i];
            $_FILES['scan_copy']['type']= $files['scan_copy']['type'][$i];
            $_FILES['scan_copy']['tmp_name']= $files['scan_copy']['tmp_name'][$i];
            $_FILES['scan_copy']['error']= $files['scan_copy']['error'][$i];
            $_FILES['scan_copy']['size']= $files['scan_copy']['size'][$i];    
    
            $this->upload->initialize($this->set_upload_options());
            $this->upload->do_upload('scan_copy');
            $dataInfo[] = $this->upload->data();
           
        }
         return $dataInfo;
    }
	private function set_upload_options()
    {   
        //upload an image options
        $config = array();
        $config['upload_path'] = 'assets/images/scan_copy';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;
    
        return $config;
    }
    
    public function upload_report()
    {
    	$this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
                   
            $_FILES['report_copy']['name']= $files['report_copy']['name'];
            $_FILES['report_copy']['type']= $files['report_copy']['type'];
            $_FILES['report_copy']['tmp_name']= $files['report_copy']['tmp_name'];
            $_FILES['report_copy']['error']= $files['report_copy']['error'];
            $_FILES['report_copy']['size']= $files['report_copy']['size'];    
    
            $this->upload->initialize($this->set_upload_report_options());
            $this->upload->do_upload('report_copy');
            $dataInfo[] = $this->upload->data();
        
         return $dataInfo;
    }
    
     public function upload_editreport()
    {
    	$this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
                   
            $_FILES['edit_report_copy']['name']= $files['edit_report_copy']['name'];
            $_FILES['edit_report_copy']['type']= $files['edit_report_copy']['type'];
            $_FILES['edit_report_copy']['tmp_name']= $files['edit_report_copy']['tmp_name'];
            $_FILES['edit_report_copy']['error']= $files['edit_report_copy']['error'];
            $_FILES['edit_report_copy']['size']= $files['edit_report_copy']['size'];    
    
            $this->upload->initialize($this->set_upload_report_options());
            $this->upload->do_upload('edit_report_copy');
            $dataInfo[] = $this->upload->data();
        
         return $dataInfo;
    }
    
    private function set_upload_report_options()
    {   
        //upload an image options
        $config = array();
        $config['upload_path'] = 'assets/images/report_copy';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;
    
        return $config;
    }

}