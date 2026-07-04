<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Billing extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Billing Details';

		$this->load->model('model_billing');
		$this->load->model('model_registration'); 
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewBilling', $this->permission)) 
		{
			redirect('dashboard', 'refresh');
		}
 	 
    	// Process your response here
    	//echo $response; 
    	
        $result = $this->model_billing->getBillingData();
        $this->data['results'] = $result;
        $this->render_template('Billing/index', $this->data);
	}
 public function dueBilling()
	{
		if(!in_array('viewBilling', $this->permission)) 
		{
			redirect('dashboard', 'refresh');
		}
	  
        $result = $this->model_billing->getBillingData();
        $this->data['results'] = $result;
        $this->render_template('Billing/duebilling', $this->data);
	}
	public function dueBillingreport()
	{
		if(!in_array('viewBilling', $this->permission)) 
		{
			redirect('dashboard', 'refresh');
		}
	  
        $result = $this->model_billing->getBillingData();
        $this->data['results'] = $result;
        $this->render_template('Billing/duebillingreport', $this->data);
	}
 public function paymentnotUpdate()
	{
		if(!in_array('viewBilling', $this->permission)) 
		{
			redirect('dashboard', 'refresh');
		}
	 
        $result = $this->model_billing->getBillingData();
        $this->data['results'] = $result;
        $this->render_template('Billing/paymentnotupdate', $this->data);
	}
 
	public function fetchbillingData()
	{
		$result = array('data' => array());

    	//	$data = $this->model_billing->getBillingData();
	$data = $this->model_registration->getBillingData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;
		
		    $buttons .= '<button type="button" class="btn btn-default" onclick="editBilling('.$value['iClientId'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    			  
		    //$buttons .= '<button type="button" class="btn btn-default" onclick="removeBilling('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    	    if($value['balance_dues'] > 0)
    	    {
    	        $buttons .= '<button type="button" class="btn btn-primary">Reminder</button>';
    	    }
    	    else
    	    {
    	        $buttons .= '';
    	    }
    	     $customer_details = '';
    	    if($value['balance_dues'] == '' && $value['total_payment'] == '')
            {
                $customer_details = '<div class="red"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] > 0 && $value['total_payment'] != '')
            {
                $customer_details = '<div class="yellow"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] == 0)
            {
                $customer_details = '<div class="green"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else
            {
                 $customer_details = '<div><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            
    	    $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  
    	    $result['data'][$key] = array(
			    $value['uid_no'],
				$date_time,
				$customer_details,
				$value['mobile_no'],
				$value['total_payment'],
				$value['advance_payment'],
				$value['balance_dues'], 
				$value['payment_followup'],
				$value['remark'],
					$value['sample_details'],
				$value['qty'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
 
 
    
    public function fetchbillingFilterData()
	{
		$result = array('data' => array());

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_registration->getBillingDatabyFilter($start_date,$end_date); 
		
		
    	//	$data = $this->model_billing->getBillingData();
//	$data = $this->model_registration->getBillingData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;
		
		    //$buttons .= '<button type="button" class="btn btn-default" onclick="removeBilling('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    	    if($value['balance_dues'] > 0)
    	    {
    	        $buttons .= '<button type="button" class="btn btn-primary">Reminder</button>';
    	    }
    	    else
    	    {
    	        $buttons .= '';
    	    }
    	     $customer_details = '';
    	    if($value['balance_dues'] == '' && $value['total_payment'] == '')
            {
                $customer_details = '<div class="red"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] > 0 && $value['total_payment'] != '')
            {
                $customer_details = '<div class="yellow"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] == 0)
            {
                $customer_details = '<div class="green"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else
            {
                 $customer_details = '<div><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            
    	    $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  
    	    $result['data'][$key] = array(
			    $value['uid_no'],
				$date_time,
				$customer_details,
				$value['mobile_no'],
				$value['total_payment'],
				$value['advance_payment'],
				$value['balance_dues'], 
				$value['payment_followup'],
				$value['remark'],
					$value['sample_details'],
				$value['qty'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
 	public function fetchbillingduebalanceData()
	{
		$result = array('data' => array());

    	//	$data = $this->model_billing->getBillingData();
	$data = $this->model_registration->getBillingbalanceData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;
		
		    //$buttons .= '<button type="button" class="btn btn-default" onclick="removeBilling('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    	    if($value['balance_dues'] > 0)
    	    {
    	        $buttons .= '<button type="button" class="btn btn-primary" onclick="sendmessage('.$value['iClientId'].')" data-toggle="modal" data-target="#sendBrandModal">Reminder</button>';
    	    }
    	    else
    	    {
    	        $buttons .= '';
    	    }
    	     $customer_details = '';
    	    if($value['balance_dues'] == '' && $value['total_payment'] == '')
            {
                $customer_details = '<div class="red"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] > 0 && $value['total_payment'] != '')
            {
                $customer_details = '<div class="yellow"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] == 0)
            {
                $customer_details = '<div class="green"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else
            {
                 $customer_details = '<div><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            
    	    $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  
    	    $result['data'][$key] = array(
			    $value['uid_no'],
				$date_time,
				$customer_details,
				$value['mobile_no'],
				$value['total_payment'],
				$value['advance_payment'],
				$value['balance_dues'], 
				$value['payment_followup'],
				$value['remark'],
				$value['sample_details'],
				$value['qty'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
 
 	public function fetchbillingduereportbalanceData()
	{
		$result = array('data' => array());

    	//	$data = $this->model_billing->getBillingData();
	$data = $this->model_registration->getBillingbalancereportData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;
		
		    //$buttons .= '<button type="button" class="btn btn-default" onclick="removeBilling('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    	    if($value['balance_dues'] > 0)
    	    {
    	        $buttons .= '<button type="button" class="btn btn-primary" onclick="sendmessage('.$value['iClientId'].')" data-toggle="modal" data-target="#sendBrandModal">Reminder</button>';
    	    }
    	    else
    	    {
    	        $buttons .= '';
    	    }
    	     $customer_details = '';
    	    if($value['balance_dues'] == '' && $value['total_payment'] == '')
            {
                $customer_details = '<div class="red"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] > 0 && $value['total_payment'] != '')
            {
                $customer_details = '<div class="yellow"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] == 0)
            {
                $customer_details = '<div class="green"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else
            {
                 $customer_details = '<div><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            
    	    $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  
    	    $result['data'][$key] = array(
			    $value['uid_no'],
				$date_time,
				$customer_details,
				$value['mobile_no'],
				$value['total_payment'],
				$value['advance_payment'],
				$value['balance_dues'], 
				$value['payment_followup'],
				$value['remark'],
				$value['sample_details'],
				$value['qty'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
 
 	public function fetchbillingpaymentnotupdateData()
	{
		$result = array('data' => array());

    	//	$data = $this->model_billing->getBillingData();
	$data = $this->model_registration->getBillingpaymentnotupdateData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;
		
		    //$buttons .= '<button type="button" class="btn btn-default" onclick="removeBilling('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
    	    if($value['balance_dues'] > 0)
    	    {
    	        $buttons .= '<button type="button" class="btn btn-primary">Reminder</button>';
    	    }
    	    else
    	    {
    	        $buttons .= '';
    	    }
    	     $customer_details = '';
    	    if($value['balance_dues'] == '' && $value['total_payment'] == '')
            {
                $customer_details = '<div class="red"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] > 0 && $value['total_payment'] != '')
            {
                $customer_details = '<div class="yellow"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else if($value['balance_dues'] == 0)
            {
                $customer_details = '<div class="green"><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            else
            {
                 $customer_details = '<div><p><b>'.$value['agency_name'].'</b></br>'.$value['reporting_address'].'</p></div>';
            }
            
    	    $date = date('d/m/Y',strtotime($value['received_date']));
			$date_time = $date;
			  
    	    $result['data'][$key] = array(
			    $value['uid_no'],
				$date_time,
				$customer_details,
				$value['mobile_no'],
				$value['total_payment'],
				$value['advance_payment'],
				$value['balance_dues'], 
				$value['payment_followup'],
				$value['remark'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
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
        
		if(!in_array('createBilling', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

        $this->form_validation->set_rules('uid_no', 'Uid Number', 'trim|required');
		$this->form_validation->set_rules('bill_no', 'Bill Number', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

                  $amount_received_date = date('Y-m-d',strtotime($this->input->post('amount_received_date')));
         	         
         	    
         	      if ($this->form_validation->run() == TRUE) 
        	       {
        	           $data = array
        	           (
                	    'uid_no' => $this->input->post('uid_no'),
                	    'bill_no' => $this->input->post('bill_no'),
                		'bill_amount' => $this->input->post('bill_amount'),
                		'advance_amount' => $this->input->post('advance_amount'),
                		'mode_of_payment' => $this->input->post('mode_of_payment'),
                		'amount_received' => $this->input->post('amount_received'),
                		'amount_received_date' => $this->input->post('amount_received_date'),
                		'due_amount' => $this->input->post('due_amount'),
                		'discount' => $this->input->post('discount'),
                		'remark' => $this->input->post('remark'),
                	  );
                   
                	$create = $this->model_billing->create($data);
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
		if(!in_array('updateBilling', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

        $user_id = $this->session->userdata('id');
		$response = array();

		if($id) {
		 
		 
            $this->form_validation->set_rules('edit_uid_no', 'Uid Number', 'trim|required');
		     
		    $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) 
	            {
	                
	                 $amount_received_date = date('Y-m-d',strtotime($this->input->post('edit_amount_received_date')));
	                
	                if($amount_received_date == '01-Jan-1970')
	                {
	                    $amount_received_date1 = '';
	                }
	                else
	                {
	                    $amount_received_date1 = $amount_received_date;
	                }
	                 
        	            $data = array(
                            'uid_no' => $this->input->post('edit_uid_no'),
                            'total_payment' => $this->input->post('edit_total_payment'),
                            'balance_dues' => $this->input->post('edit_balance_dues'),
                            'advance_payment' => $this->input->post('edit_advance_payment'),
                            'payment_followup' => $this->input->post('edit_payment_followup'),
                            'financial_remark' => $this->input->post('edit_financial_remark'), 
                            'mode_of_payment' => $this->input->post('edit_mode_of_payment'), 
        	        	);

	        	$update = $this->model_billing->updateregbilling($data, $id);
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
		if(!in_array('deleteBilling', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$id = $this->input->post('id');
		$response = array();
		if($id) {
			$delete = $this->model_billing->remove($id);

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

    public function sendmessage()
    {
        	$id = $this->input->post('id');
        	$billingdata = $this->model_registration->getBillingData($id);
		 
		     $username =   $billingdata['agency_name'];
             $balance_amount =   $billingdata['balance_dues'];
             $mobile_no =   $billingdata['mobile_no'];
             //$mobile_no =   '919636625996';
             $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
        	$name = 'test';
        	 $amount = '110';
        	// Message details
        	$numbers = array($mobile_no);
        	$sender = urlencode('NAMOTH'); 
        	
        		$message =  urlencode("Hello ".$username.",
This is a friendly reminder,your payment of Rs".$balance_amount." is due.
You may pay by visiting our office.
Ignore if paid already.
Thank you
From Namotech");

 
 
        	$numbers = implode(',', $numbers);
         
        	// Prepare data for POST request
        	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
        	// Send the POST request with cURL
        	$ch = curl_init('https://api.textlocal.in/send/');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$response = curl_exec($ch);
        	
        	/*print_r($response);*/
        	curl_close($ch);
        	
        	
        	            $data = array(
        	            'iClientId' => $id,
                	    'sent_date' => $date = date('Y-m-d H:i:s'),
                		'total_amount' => $billingdata['total_payment'],
                		'advance_amount' => $billingdata['advance_payment'],
                		'balance_amount' => $billingdata['balance_dues'], 
        	        	);
	        $create = $this->model_billing->createsmslog($data);
           	$response1 = array();
           if($create == true) {
				$response1['success'] = true;
				$response1['messages'] = "Successfully Send Reminder Message ";	
			}
			else {
				$response1['success'] = false;
				$response1['messages'] = "Error!";
			}
	 
        echo json_encode($response1);
    }
    
    
    public function allsendmessage()
    {
        	 
        	$billingdata = $this->model_registration->getBillingbalanceData();
		 
		 	foreach ($billingdata as $key => $value) {

            $username =   $value['agency_name'];
            $balance_amount =   $value['balance_dues'];
            $mobile_no =   $value['mobile_no'];
            //$mobile_no =   '919636625996';
            $apiKey = urlencode('NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=');
        	$numbers = array($mobile_no);
        	$sender = urlencode('NAMOTH'); 
        	
        		$message =  urlencode("Hello ".$username.",
This is a friendly reminder,your payment of Rs".$balance_amount." is due.
You may pay by visiting our office.
Ignore if paid already.
Thank you
From Namotech");

            $numbers = implode(',', $numbers);
         
        	// Prepare data for POST request
        	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
        	// Send the POST request with cURL
        	$ch = curl_init('https://api.textlocal.in/send/');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$response = curl_exec($ch);
        	
        	/*print_r($response);*/
        	curl_close($ch);
        	
        	
            $data = array(
            'iClientId' => $value['iClientId'],
    	    'sent_date' => $date = date('Y-m-d H:i:s'),
    		'total_amount' => $value['total_payment'],
    		'advance_amount' => $value['advance_payment'],
    		'balance_amount' => $value['balance_dues'], 
        	);
	        $create = $this->model_billing->createsmslog($data);
	        
		 	}
           	$response1 = array();
            if($create == true) {
            	$response1['success'] = true;
            	$response1['messages'] = "Successfully Send Reminder Message ";	
            }
            else {
            	$response1['success'] = false;
            	$response1['messages'] = "Error!";
            }
	    
        echo json_encode($response1);
    }
}