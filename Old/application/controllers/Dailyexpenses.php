<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dailyexpenses extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Daily Expenses Details';

		$this->load->model('model_billing');
		$this->load->model('model_registration');
		$this->load->model('model_dailyexpenses');
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
        $this->render_template('Dailyexpenses/index', $this->data);
	} 
	public function fetchbillingData()
	{
		$result = array('data' => array());

     
	    $data = $this->model_dailyexpenses->getDailyBillingData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		    $is_admin = ($user_id == 1) ? true :false;
		
		     $buttons .= '<button type="button" class="btn btn-default" onclick="removeDailyExpensive('.$value['id'].')" data-toggle="modal" data-target="#removeDailyExpensive1"><i class="fa fa-trash"></i></button>';
    	     $buttons .= '<button type="button" class="btn btn-default" onclick="editDailyExpensive('.$value['id'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    	    
    	    $date = date('d/m/Y',strtotime($value['date']));
			$date_time = $date;
			   
    	    $result['data'][$key] = array( 
				$date_time, 
                $value['opening_balance'],
                $value['total_income'],
                $value['total_expenses'],
                $value['closing_balance'], 
                $value['expenses_category'],
                $value['expenses_remark'],
                $value['payment_mode'],
                $value['remark'],
                $value['person_name'],
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
         $expenses_category_fil = $this->input->get('expenses_category_fil');
       
	    $data = $this->model_dailyexpenses->getBillingDatabyFilter($start_date,$end_date,$expenses_category_fil); 
		
		
    foreach ($data as $key => $value) {

			// button
			$buttons = '';
            $consignor = '';
            $vehicle = '';
            $user_id = $this->session->userdata('id');
		    $is_admin = ($user_id == 1) ? true :false;
		
		    $buttons .= '<button type="button" class="btn btn-default" onclick="removeDailyExpensive('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>';
    	     $buttons .= '<button type="button" class="btn btn-default" onclick="editDailyExpensive('.$value['id'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
    	    $date = date('d/m/Y',strtotime($value['date']));
			$date_time = $date;
			   
    	    $result['data'][$key] = array( 
				$date_time, 
                $value['opening_balance'],
                $value['total_income'],
                $value['total_expenses'],
                $value['closing_balance'], 
                $value['expenses_category'],
                $value['expenses_remark'],
                $value['payment_mode'],
                $value['remark'],
                $value['person_name'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
  
 
    public function fetchbillingDataById($id)
	{
		if($id) {
			$data = $this->model_dailyexpenses->getDailyBillingData($id);
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

        $this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('expenses_category', 'Expenses Category', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        $date = date('Y-m-d',strtotime($this->input->post('date')));
        
        $data = $this->model_dailyexpenses->getDailyBillingData();
        
        $lastdate = $data[0]['date'];
        
        
        if($date < $lastdate)
        {
        
          $date = date('Y-m-d',strtotime($this->input->post('date')));
        $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($date);
        
         
        if(isset($databydate))
        {
           $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($date);
        }
        else
        {
            $lastdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate);
            
                if(isset($databydate))
                {
                   $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate);
                }
                else
                {
                    $lastdate1 = date('Y-m-d', strtotime('-1 day', strtotime($lastdate)));
                    $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate1);
                    
                    if(isset($databydate))
                {
                   $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate1);
                }
                else
                {
                $lastdate2 = date('Y-m-d', strtotime('-1 day', strtotime($lastdate1)));
                $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate2);
                    
                    if(isset($databydate))
                {
                   $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate2);
                }
                else
                {
                    $lastdate3 = date('Y-m-d', strtotime('-1 day', strtotime($lastdate2)));
                    $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate3);
                }
            
                if(isset($databydate))
                {
                   $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate3);
                }
                else
                {
                    $lastdate4 = date('Y-m-d', strtotime('-1 day', strtotime($lastdate3)));
                    $databydate = $this->model_dailyexpenses->getDailyBillingLastDatabyDate($lastdate4);
                }
            }
            }
            
            
        }
         
        $opening_balancedate = $databydate['opening_balance'];
        $closing_balancedate1 = $databydate['closing_balance']; 
       
        
        $databydaten = $this->model_dailyexpenses->getDailyBillingLastDatabyallDate($date);
        
            $total_income =  $this->input->post('total_income');
            $total_expenses =  $this->input->post('total_expenses');  

        if($total_income > 0)
        {
            $closing_balancedate = $closing_balancedate1+$total_income;
        }
        
        if($total_expenses > 0)
        {
            $closing_balancedate = $closing_balancedate1-$total_expenses;
        }
            $iExpensesId = $databydate['iExpensesId']+1;
             $data = array
	           (
	           'iExpensesId' => $iExpensesId,
        	    'date' => $date,
        	    'opening_balance' => $closing_balancedate1,
        		'total_income' => $total_income,
        		'total_expenses' => $total_expenses,
        		'closing_balance' => $closing_balancedate,
        		'expenses_category' => $this->input->post('expenses_category'),
        		'expenses_remark' => $this->input->post('expenses_remark'),
        		'payment_mode' => $this->input->post('payment_mode'),
        		'person_name' => $this->input->post('person_name'),
        		'remark' => $this->input->post('remark'), 
        	  );
           $create = $this->model_dailyexpenses->create($data); 
           	if($create == true) {
            		$response['success'] = true;
            		$response['messages'] = 'Succesfully created';
            	}
            	else {
            		$response['success'] = false;
            		$response['messages'] = 'Error in the database while creating the brand information';			
            	}
            
        
          foreach ($databydaten as $key => $databydate1) {
        
             $total_income =  $this->input->post('total_income');
            $total_expenses =  $this->input->post('total_expenses');  
            
                $nid = $databydate1['id'];
            
            
            
            if($total_income != '')
            {
                 $nopening_balance = $databydate1['opening_balance'] + $total_income;
            }
            else if($total_expenses != '')
            {
               $nopening_balance = $databydate1['opening_balance'] - $total_expenses;
            }
            else
            {
                $nopening_balance = $databydate1['opening_balance'];
            }
            $total_income1 = $databydate1['total_income'];
            if($total_income1 != '')
            {
               $nclosing_balance =  $total_income1 + $nopening_balance;
            }
            
            $total_expenses1 = $databydate1['total_expenses'];
            if($total_expenses1 != '')
            {
               $nclosing_balance =  $nopening_balance - $total_expenses1;
            }
            $iExpensesId = $databydate1['iExpensesId'] + 1;
            
          $data = array( 
                        'iExpensesId' => $iExpensesId,
                	    'opening_balance' => $nopening_balance,
                		'closing_balance' => $nclosing_balance
        	        	);
           $update = $this->model_dailyexpenses->update($data, $nid);
            
        }
             
        
        }
        else
        {
            
             
             $data = $this->model_dailyexpenses->getDailyBillingData();
            if($data[0]['closing_balance'] > 0)
            {
                $opening_balance = $data[0]['closing_balance'];
            }
            else
            {
                $opening_balance = 0;
            }
        
            $total_income =  $this->input->post('total_income');
        $total_expenses =  $this->input->post('total_expenses');  

        if($total_income > 0)
        {
            $closing_balance = $opening_balance+$total_income;
        }
        
        if($total_expenses > 0)
        {
            $closing_balance = $opening_balance-$total_expenses;
        }
        $iExpensesId = $data[0]['iExpensesId']+1;
        
 	    if ($this->form_validation->run() == TRUE) 
	    {
	           $data = array
	           (
	               'iExpensesId' => $iExpensesId,
            	    'date' => $date,
            	    'opening_balance' => $opening_balance,
            		'total_income' => $total_income,
            		'total_expenses' => $total_expenses,
            		'closing_balance' => $closing_balance,
            		'expenses_category' => $this->input->post('expenses_category'),
            		'expenses_remark' => $this->input->post('expenses_remark'),
            		'payment_mode' => $this->input->post('payment_mode'),
            		'person_name' => $this->input->post('person_name'),
            		'remark' => $this->input->post('remark'), 
        	   );
                $create = $this->model_dailyexpenses->create($data);
             	if($create == true) {
            		$response['success'] = true;
            		$response['messages'] = 'Succesfully created';
            	}
            	else {
            		$response['success'] = false;
            		$response['messages'] = 'Error in the database while creating the brand information';			
            	}
        }
        else 
        {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
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
		  
            $this->form_validation->set_rules('edit_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('edit_expenses_category', 'Expenses Category', 'trim|required');
		
		    $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) 
	            {
	                
	                 $date = date('Y-m-d',strtotime($this->input->post('edit_date')));
	                
	                if($date == '1970-01-01')
	                {
	                    $date = '';
	                }
	                else
	                {
	                    $date = $date;
	                }
	                 
	                 
	                    $dataget = $this->model_dailyexpenses->getDailyBillingData($id);
	                    
                        $iExpensesId = $dataget['iExpensesId'];
                        $old_opening_balance = $dataget['opening_balance'];
                        $old_total_income= $dataget['total_income'];
                        $old_total_expenses = $dataget['total_expenses'];
                        $old_closing_balance = $dataget['closing_balance'];
                        
                        $opening_balance = $this->input->post('edit_opening_balance');
                		$total_income = $this->input->post('edit_total_income');
                		$total_expenses =  $this->input->post('edit_total_expenses');
                		$closing_balance = $this->input->post('edit_closing_balance');
	                    
	                 $today = date('Y-m-d');
	                 $lastdataget = $this->model_dailyexpenses->getDailyBillingLastEntry();
	                 
	                   $iExpenses_lastId = $lastdataget['iExpensesId'];
	                 
	                 $incomeplus = 0;
	                 $incomeminus = 0;
	                  
	                 
	                    if($closing_balance > $old_closing_balance)
	                     {
	                         $incomeplus = $closing_balance-$old_closing_balance;
	                     }
	                     else if($old_closing_balance > $closing_balance)
	                     {
	                         $incomeminus = $old_closing_balance-$closing_balance;
	                     }
	                  
	                    $newopening_balance = 0;
	                    $newclosing_balance = 0;
	                 for($e=$iExpensesId;$e<=$iExpenses_lastId;$e++)
	                 {
	                     $dataget1 = $this->model_dailyexpenses->getDailyBillingDatabyiExpensesId($e);
                         $openingbalance = $dataget1['opening_balance'];
	                     $closingbalance = $dataget1['closing_balance'];
	                     
	                     if($incomeplus > 0)
	                     {
	                         $newopening_balance = (int)$openingbalance + (int)$incomeplus;
	                         $newclosing_balance = (int)$closingbalance + (int)$incomeplus;
	                     }
	                     elseif($incomeminus > 0)
	                     {
	                         $newopening_balance = (int)$openingbalance - (int)$incomeminus;
	                         $newclosing_balance = (int)$closingbalance - (int)$incomeminus;
	                     }
	                      
	                     $data3 = array( 
                    	    'opening_balance' => $newopening_balance,
                    	 	'closing_balance' => $newclosing_balance, 
            	        	);
                           $update = $this->model_dailyexpenses->updatebyiExpensesId($data3, $e);
	        	      }
	                  
        	            $data = array( 
                	    'opening_balance' => $this->input->post('edit_opening_balance'),
                		'total_income' => $this->input->post('edit_total_income'),
                		'total_expenses' => $this->input->post('edit_total_expenses'),
                		'closing_balance' => $this->input->post('edit_closing_balance'),
                		'expenses_category' => $this->input->post('edit_expenses_category'),
                		'expenses_remark' => $this->input->post('edit_expenses_remark'),
                		'payment_mode' => $this->input->post('edit_payment_mode'),
                		'person_name' => $this->input->post('edit_person_name'),
                		'remark' => $this->input->post('edit_remark'), 
        	        	);
                
	        	$update = $this->model_dailyexpenses->update($data, $id);
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
		    
		    
	                    $dataget = $this->model_dailyexpenses->getDailyBillingData($id);
	                    
                        $iExpensesId = $dataget['iExpensesId'];
                        $old_opening_balance = $dataget['opening_balance'];
                        $old_total_income= $dataget['total_income'];
                        $old_total_expenses = $dataget['total_expenses'];
                        $old_closing_balance = $dataget['closing_balance'];
                         
	                 $today = date('Y-m-d');
	                 $lastdataget = $this->model_dailyexpenses->getDailyBillingLastEntry();
	                 
	                   $iExpenses_lastId = $lastdataget['iExpensesId'];
	                 
	                 $incomeplus = 0;
	                 $incomeminus = 0;
	                  
	                 
	                    if($old_closing_balance > $old_opening_balance)
	                     {
	                         $incomeplus = $old_closing_balance-$old_opening_balance;
	                     }
	                     else if($old_opening_balance > $old_closing_balance)
	                     {
	                         $incomeminus = $old_opening_balance-$old_closing_balance;
	                     }
	                  
	                    $newopening_balance = 0;
	                    $newclosing_balance = 0;
	                    $niExpensesId = $iExpensesId+1;
    	                 for($e = $niExpensesId;$e<=$iExpenses_lastId;$e++)
    	                 {
    	                     $dataget1 = $this->model_dailyexpenses->getDailyBillingDatabyiExpensesId($e);
                             $openingbalance = $dataget1['opening_balance'];
    	                     $closingbalance = $dataget1['closing_balance'];
    	                     $newE = $e-1;
    	                     if($incomeplus > 0)
    	                     {
    	                         $newopening_balance = (int)$openingbalance - (int)$incomeplus;
    	                         $newclosing_balance = (int)$closingbalance - (int)$incomeplus;
    	                     }
    	                     elseif($incomeminus > 0)
    	                     {
    	                         $newopening_balance = (int)$openingbalance + (int)$incomeminus;
    	                         $newclosing_balance = (int)$closingbalance + (int)$incomeminus;
    	                     }
    	                      
    	                     $data3 = array( 
                        	    'opening_balance' => $newopening_balance,
                        	 	'closing_balance' => $newclosing_balance,
                        	 	'iExpensesId' => $newE,
                	        	);
                               $update = $this->model_dailyexpenses->updatebyiExpensesId($data3, $e);
    	        	      }
		     
			$delete = $this->model_dailyexpenses->remove($id);

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
}