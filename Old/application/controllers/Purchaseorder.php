<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorder extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Bitumen Extraction Core Reports';
        
       $this->load->model('model_company'); 
       $this->load->model('model_users');
       $this->load->model('model_purchaseorder');
       
        
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewBilling', $this->permission)) {
            redirect('dashboard', 'refresh');
        } 
		$this->data['page_title'] = 'Manage Report';
		$this->render_template('purchaseorder/index', $this->data);		
	} 
	public function fetchPurchaseOrdersData()
	{
		$result = array('data' => array());

		$data = $this->model_purchaseorder->getpurchaseorderOrdersData();
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewBilling', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iPurchaseorderId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateBilling', $this->permission)) {
				$buttons .= ' <a href="'.base_url('purchaseorder/update/'.$value['iPurchaseorderId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteBilling', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iPurchaseorderId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewBilling', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iPurchaseorderId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			  
            $date = date('d M Y',strtotime($value['date']));
            
			$date_time = $date; 
			    $result['data'][$key] = array(
				$date_time,
				$value['agency_name'],
				$value['reporting_address'],
				$value['purchase_order'],
				$value['vendor_ref_no'],
				$value['vendor_ref_date'], 
				$buttons, 
		    	);
	 
        }
		echo json_encode($result);
	    
	}
  
	 public function fetchPurchaseOrdersFilterData()
	{
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_purchaseorder->getpurchaseorderOrdersDataFilter($start_date,$end_date);
		 
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewBilling', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iPurchaseorderId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateBilling', $this->permission)) {
				$buttons .= ' <a href="'.base_url('purchaseorder/update/'.$value['iPurchaseorderId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteBilling', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iPurchaseorderId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewBilling', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iPurchaseorderId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			  
            $date = date('d M Y',strtotime($value['date']));
            
			$date_time = $date; 
			    $result['data'][$key] = array(
				$date_time,
				$value['agency_name'],
				$value['reporting_address'],
					$value['purchase_order'],
				$value['vendor_ref_no'],
				$value['vendor_ref_date'], 
				$buttons, 
		    	);
	 
        }
		echo json_encode($result);
	    
	}
  
	public function create()
	{
		if(!in_array('createBilling', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Create Purchase Order'; 
		$this->form_validation->set_rules('purchase_order', 'Purchase Order Number', 'trim|required');
	 	$this->form_validation->set_rules('order_sample', 'Select Order Sample', 'trim|required');
	 	
		if ($this->form_validation->run() == TRUE) {        	
        	$uid_no = $this->input->post('uid_no');
        	$iPurchaseorderId = $this->model_purchaseorder->createpurchaseorder();
        	
            /* mail function*/
               //$this->printDiv_mail($order_id);
            /*******************/
            $countset = $this->input->post('countset');
            for($j=0; $j < $countset; $j++)
            {
                $i = $j+1;
                $data = array
               (
            	      'iPurchaseorderId' => $iPurchaseorderId, 
                      'description' => $this->input->post('description_'.$i),
                      'rate' => $this->input->post('rate_'.$i),
                      'unit' => $this->input->post('unit_'.$i),
                      'discount' => $this->input->post('discount_'.$i),
                      'amount' => $this->input->post('amount_'.$i), 
                      'set_count' => $countset
                );
                $create = $this->model_purchaseorder->createpurchaseorderlist($data);
            }
             
        	if($iPurchaseorderId) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('purchaseorder', 'refresh');
        	}
        	else 
        	{
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('purchaseorder/create/', 'refresh');
        	}
        }
        else {
            // false case
           $this->render_template('purchaseorder/create', $this->data);
        }	
	}


    public function getClientDetails()
    {
        $uid_no = $_GET['uid_no'];   
        if($uid_no) 
        {
			$data = $this->model_purchaseorder->getpurchaseorderDataByregistration($uid_no);
		  	if($data == true) {
			     
                $data['success'] = true;
                $data['messages'] = "Successfully Update"; 
            }
            else 
            {
                $data['success'] = false;
                $data['messages'] = "UID No. Not Found!";
            }
			echo json_encode($data);
		 
        } 
		return false;
    }
    
     
 
	public function update($id)
	{
	  
		if(!in_array('updateBilling', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('purchase_order', 'Purchase Order', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) 
        {        	
        	
        	$update = $this->model_purchaseorder->updatepurchaseorder($id);
        	
              $countset = $this->input->post('countset');
            for($j=0; $j < $countset; $j++)
            {
                    $i = $j+1;
                    
                    $id = $this->input->post('iPlid_'.$i);
                    
                    $data = array
                    ( 
                      'description' => $this->input->post('description_'.$i),
                      'rate' => $this->input->post('rate_'.$i),
                      'unit' => $this->input->post('unit_'.$i),
                      'discount' => $this->input->post('discount_'.$i),
                      'amount' => $this->input->post('amount_'.$i),  
                    );
                 
                $create = $this->model_purchaseorder->updatepurchaseorderreport($data,$id);
            }
            
        	//$this->printDiv_updatemail($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        	    redirect('purchaseorder/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('purchaseorder/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
            $result = array();
        	$orders_data = $this->model_purchaseorder->getpurchaseorderOrdersData($id); 
        	 
        	$result['order'] = $orders_data;
    		 
     
    		$this->data['order_data'] = $result;
     	

            $this->render_template('purchaseorder/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
 
	public function remove()
	{
		if(!in_array('deleteBilling', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		 $iPurchaseorderId = $this->input->post('iPurchaseorderId');

        $response = array();
        if($iPurchaseorderId) {
            $delete = $this->model_purchaseorder->purchaseorderremove($iPurchaseorderId);
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
 
	
	public function printDiv($id)
	{
		if(!in_array('viewBilling', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_purchaseorder->getpurchaseorderOrdersData($id); 
			$company = $this->model_company->getCompanyData();
		//	$order_date = date('d/m/Y', $order_data['date_time']);
			 
             
			$html = '<!DOCTYPE html>
			<html>
			<head>
			  <title>NCRC REPORTS</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  
                <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                <meta http-equiv="X-UA-Compatible" content="IE=Edge">
                <meta charset="utf-8">
			  <!-- Bootstrap 3.3.7 -->
			  
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  				<style>
			h4,h5{
			   margin: 2px 0; 
			}
			.page-header {
  margin: 8px 0 8px;
			}
   
.table {
  margin-bottom: 10px;
} 
.table-striped > tbody > tr:nth-of-type(2n+1) {
  background-color: #fff;
}
.table > tbody > tr > th
{
    border: 1px solid;
    padding:5px !important;
    font-size: 14px;
    background-color:#eee;
    text-align:center;
}
.table > tbody > tr > td
{
    border: 1px solid;
    padding:5px !important;
    font-size: 14px;
    text-align: center;
vertical-align: middle;
}
 
p 
{
  font-size: 14px;
  margin: 0 0 2px;
text-transform: capitalize;
}
.col-xs-4 p {
  font-size: 14px;
  font-weight: bold;
}
.col-xs-4 {
  border-right: 1px solid;
}
 
</style>
			</head>
			<body>
		       <div class="container">
		        <div class="row" style="margin-bottom:30px"> 
		            <div class="col-xs-12 col-sm-12">
		            <img src="'.base_url().'assets/images/report_header.jpeg" class="img-responsive" style="width: 1170px;height: 150px;">
		            </div>
		        </div> 
		        <div class="row"> 
                <div class="col-xs-12 col-sm-12">
                    <table class="table table-striped">
    			        <tbody>
    			        <tr>
    			            <td colspan="5"><h5 style="color:#000!important;text-transform: uppercase;text-align:center;font-size:16px;padding: 4px;font-weight: bold;">PURCHASE ORDER</h5></td>
    			        </tr>
    			        <tr>
    			            <td colspan="2" rowspan="4" style="text-align:left;">TO </br> <p><b>'. $order_data[0]['agency_name'].'</b></p> <p>'. $order_data[0]['reporting_address'].'</p></td>
    			            <td colspan="2"><b>Purchase Order No</b></td>
    			            <td colspan="1"><p> '. $order_data[0]['purchase_order'].'</p></td>
    			        </tr>
    			         <tr>
    			            
    			            <td colspan="2"><b>Date</b></td>
    			            <td colspan="1"><p> '. $order_data[0]['date'].'</p></td>
    			        </tr>
    			         <tr>
    			            
    			            <td colspan="2"><b>Vendor Ref No</b></td>
    			            <td colspan="1"><p> '. $order_data[0]['vendor_ref_no'].'</p></td>
    			        </tr>
    			            <tr> 
    			                <td colspan="2"><b>Vendor Ref Date</b></td>
    			                <td colspan="1"><p> '. $order_data[0]['vendor_ref_date'].'</p></td>
    			            </tr>
						 <tr>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Description</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Discount</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Amount</th>
    			        </tr>';
    			        $rowcount = $order_data[0]['set_count'];
    			        
    			        for($j=0;$j<$rowcount;$j++)
    			        { 
    			        $i = $j+1;
    			         $html.='<tr>
        			            <td>'.$i.'</td>
        			            <td>'.$order_data[$j]["description"].'</td>
        			            <td>'.$order_data[$j]["unit"].'</td>
        			            <td>'.$order_data[$j]["discount"].'</td> 
        			            <td>'.$order_data[$j]["amount"].'</td> 
        			        </tr>';
    			        }
        			       
        			       $html.='<tr>
        			       <td>PAYMENT TERM</td>
        			       <td colspan="2">
        			       <p>1. 20% Advance for Total Amount</p>
        			       <p>2. Remaining 80% on work Completion</p>
        			       </td>
        			       <td><b>Total Amount</b></td>
        			       <td>'.$order_data[0]["total_amount"].'</td>
        			       </tr>
        			       <tr>
        			       <td colspan="3" rowspan="6">
        			        </td>
        			       <td><b>Discount</b></td>
        			       <td>'.$order_data[0]["total_discount"].'</td>
        			       </tr>
        			         
        			       <tr>
        			        
        			       <td><b>Tarnsportation </br> (In lumpusm)</b></td>
        			       <td>'.$order_data[0]["transportation"].'</td>
        			       </tr>
        			       
        			       <tr>
        			        
        			       <td><b>Gst @18%</b></td>
                            <td>'.$order_data[0]["gst_amount"].'</td>';
        			       $html.='</tr>
        			       <tr>
        			        
        			       <td><b>Total Amount</b></td>';
        			       
        			        $tamount = $order_data[0]["gst_amount"] + $order_data[0]["total_amount"] + $order_data[0]["transportation"] - $order_data[0]["total_discount"];
        			       
        			       
        			       $html.='<td>'.$tamount.'</td>
        			       </tr>
        			       <tr>
        			      
        			       <td><b>Advance Amount</b></td>';
        			       
        			       $advance_amount = $order_data[0]["advance_amount"];
        			       $html.='<td>'.$advance_amount.'</td> 
        			       </tr>
        			       <tr> 
        			       <td><b>Net Payble</b></td> 
        			       <td>'.$order_data[0]["net_amount"].'</td>
        			       </tr>
        			       <tr>
        			       <td><b>GSTIN</b></td>
        			       <td>'.$company[0]["gst_no"].'</td>
        			       <td colspan="3"><p>('.$this->getIndianCurrency($order_data[0]["net_amount"]).')</p></td>
        			       
        			       </tr>
        			       <tr>
        			       <td><b>PAN</b></td>
        			       <td>'.$company[0]["pan_no"].'</td>
        			       <td colspan="3" rowspan="3"></td>
        			        
        			       </tr>
        			       <tr>
        			       <td><b>Payment Mode</b></td>
        			       <td>NEFT/RTGS/DD</td>
        			       
        			       </tr>
        			       <tr>
        			       <td><b>HSN CODE</b></td>
        			       <td>99</td>
        			        
        			       </tr>
        			       <tr>
        			       <td colspan="2"><b>Remark: '.$order_data[0]["remark"].'</b></td>
        			       <td colspan="3"><b>For Namotech Consultancy Services LLP </b></br> Omendra Gupta </br> (Managing Director)</td>
        			        
        			       </tr>
    			         </tbody>
						</table>
			        </div> 
			         </div>
				     <div class="row" style="margin-top:50px;">
    				    <div class="col-xs-12">
    			            <img src="'.base_url().'assets/images/report_footer.jpeg" class="img-responsive" style="width: 1170px;height: 80px;">
    			         </div>
			      
			         </div>
			        </div>
		        </div>
		        </div>
    		</body>
    	</html>';

			  echo $html;
		}
	}
 
   public function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
}