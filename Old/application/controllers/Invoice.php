<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Bitumen Extraction Core Reports';
        
       $this->load->model('model_company'); 
       $this->load->model('model_users');
       $this->load->model('model_invoice'); 
        
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
		$this->render_template('invoice/index', $this->data);		
	} 
	public function fetchinvoicesData()
	{
		$result = array('data' => array());

		$data = $this->model_invoice->getinvoiceOrdersData();
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewBilling', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iInvoiceId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateBilling', $this->permission)) {
				$buttons .= ' <a href="'.base_url('invoice/update/'.$value['iInvoiceId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteBilling', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iInvoiceId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewBilling', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iInvoiceId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			  
            $date = date('d M Y',strtotime($value['date']));
            
			$date_time = $date; 
			    $result['data'][$key] = array(
				$date_time,
				$value['invoice_no'],
				$value['work_order_no'],
				$value['agency_name'],
				$value['reporting_address'],
				$value['total_amount'], 
				$buttons, 
		    	);
	 
        }
		echo json_encode($result);
	    
	}
  
	 public function fetchinvoicesFilterData()
	{
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_invoice->getinvoiceOrdersDataFilter($start_date,$end_date);
		 
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewBilling', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iInvoiceId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateBilling', $this->permission)) {
				$buttons .= ' <a href="'.base_url('invoice/update/'.$value['iInvoiceId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteBilling', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iInvoiceId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewBilling', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iInvoiceId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			  
            $date = date('d M Y',strtotime($value['date']));
            
			$date_time = $date; 
			    $result['data'][$key] = array(
			$date_time,
				$value['invoice_no'],
				$value['work_order_no'],
				$value['agency_name'],
				$value['reporting_address'],
				$value['total_amount'],  
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
		$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required');
	 	 
		if ($this->form_validation->run() == TRUE) {        	
        	$uid_no = $this->input->post('uid_no');
        	$iInvoiceId = $this->model_invoice->createinvoice();
        	
            /* mail function*/
               //$this->printDiv_mail($order_id);
            /*******************/
            $countset = $this->input->post('countset');
            for($j=0; $j < $countset; $j++)
            {
                $i = $j+1;
                $data = array
               (
            	      'iInvoiceId' => $iInvoiceId, 
                      'description' => $this->input->post('description_'.$i),
                      'rate' => $this->input->post('rate_'.$i),
                      'unit' => $this->input->post('unit_'.$i),
                      'discount' => $this->input->post('discount_'.$i),
                      'amount' => $this->input->post('amount_'.$i), 
                      'set_count' => $countset
                );
                $create = $this->model_invoice->createinvoicelist($data);
            }
             
        	if($iInvoiceId) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('invoice', 'refresh');
        	}
        	else 
        	{
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('invoice/create/', 'refresh');
        	}
        }
        else {
            // false case
           $this->render_template('invoice/create', $this->data);
        }	
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

		$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) 
        {        	
        	
        	$update = $this->model_invoice->updateinvoice($id);
        	
              $countset = $this->input->post('countset');
            for($j=0; $j < $countset; $j++)
            {
                    $i = $j+1;
                    
                    $id = $this->input->post('iIlid_'.$i);
                    
                    $data = array
                    ( 
                      'description' => $this->input->post('description_'.$i),
                      'rate' => $this->input->post('rate_'.$i),
                      'unit' => $this->input->post('unit_'.$i),
                      'discount' => $this->input->post('discount_'.$i),
                      'amount' => $this->input->post('amount_'.$i),  
                    );
                 
                $create = $this->model_invoice->updateinvoicereport($data,$id);
            }
            
        	//$this->printDiv_updatemail($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        	    redirect('invoice/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('invoice/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
            $result = array();
        	$orders_data = $this->model_invoice->getinvoiceOrdersData($id); 
        	 
        	$result['order'] = $orders_data;
    		 
     
    		$this->data['order_data'] = $result;
     	

            $this->render_template('invoice/edit', $this->data);
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

		 $iInvoiceId = $this->input->post('iInvoiceId');

        $response = array();
        if($iInvoiceId) {
            $delete = $this->model_invoice->invoiceremove($iInvoiceId);
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
			$order_data = $this->model_invoice->getinvoiceOrdersData($id); 
			$company = $this->model_company->getCompanyData(1);
		 
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
    padding:4px !important;
    font-size: 14px;
    background-color:#eee;
    text-align:center;
}
.table > tbody > tr > td
{
    border: 1px solid;
    padding:4px !important;
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
		            <img src="'.base_url().'assets/images/report_header.jpeg" class="img-responsive" style="width: 1170px;height: 150px;display:none">
		            </div>
		        </div> 
		        <div class="row"> 
                <div class="col-xs-12 col-sm-12">
                    <table class="table table-striped">
    			        <tbody>
    			        <tr>
    			            <td colspan="6"><h5 style="color:#000!important;text-transform: uppercase;text-align:center;font-size:16px;padding: 4px;font-weight: bold;">INVOICE PERFORMA</h5></td>
    			        </tr>
    			        <tr>
    			            <td colspan="2" rowspan="4" style="text-align:left;"> <p><b>'.$company["company_name"].'</b></p><p><b>Address : </b>'. $company['address'].'</p> <p><b>Phone : </b>'. $company['phone'].'</p><p><b>Mobile No : </b>+919214507766</p><p><b>Email Id : </b>namotech.omendra@gmail.com</p><p><b>Website : </b>www.namotech.in</p></td>
    			             
                    			            <td><b>Invoice No</b></td>
                    			            <td><p> '. $order_data[0]['invoice_no'].'</p></td>
                    			            <td><b>Date</b></td>
                    			            <td><p> '. $order_data[0]['date'].'</p></td>
                			            
    			        </tr>
    			         <tr>
    			           
    			            <td><b>Work Order No</b></td>
    			            <td><p> '. $order_data[0]['work_order_no'].'</p></td>
    			            <td><b>Date</b></td>
    			            <td><p> '. $order_data[0]['work_order_date'].'</p></td>
    			         
    			        </tr>
    			         <tr>
    			           
    			            <td><b>SAC Code</b></td>
    			            <td colspan="3"><p>998346</p></td> 
    			         
    			        </tr>
    			           <tr> 
    			             
    			              <td><b>Report No</b></td>
    			            <td><p> '. $order_data[0]['report_no'].'</p></td>
    			            <td><b>Date</b></td>
    			            <td ><p> '. $order_data[0]['report_date'].'</p></td>
    			             </tr>
    			            <tr> 
    			              <td colspan="2"><p><b>LLP GSTIN.: </b>'. $company['gst_no'].'</p></td>
    			                <td colspan="4"> </td>
    			             </tr>
    			             <tr> 
    			              <td colspan="2"><p><b>LLP PAN NO.: </b>'. $company['pan_no'].'</p></td>
    			              <td colspan="4"><p><b>Terms Of Delivery : </b>'. $order_data[0]['terms_of_delivery'].'</p> </td>
    			             </tr>
    			             <tr style="height:100px"> 
    			              <td colspan="2"><p>'. $order_data[0]['agency_name'].'</p><p>'. $order_data[0]['reporting_address'].'</p> <p>'. $order_data[0]['agency_gst'].'</p></td>
    			              <td colspan="4"></td>
    			             </tr>
						 <tr>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Description</th> 
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Rate</th>
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
        			            <td>'.$order_data[$j]["rate"].'</td>
        			            <td>'.$order_data[$j]["unit"].'</td>
        			            <td>'.$order_data[$j]["discount"].'</td> 
        			            <td>'.$order_data[$j]["amount"].'</td> 
        			        </tr>';
    			        }
        			       
        			       $html.='<tr>
        			        
        			       <td colspan="3" rowspan="8"></td>
        			       <td colspan="2"><b>Total Amount</b></td>
        			       <td>'.$order_data[0]["total_amount"].'</td>
        			       </tr>
        			        <tr> 
        			       <td colspan="2"><b>Tarnsportation Exp. & Other Exp. Including</b></td>
        			       <td>'.$order_data[0]["transportation"].'</td>
        			       </tr>
        			       <tr>
        			       <td colspan="2"><b>Discount</b></td>
        			       <td>'.$order_data[0]["total_discount"].'</td>
        			       </tr>
        			       
        			       <tr>
        			            <td colspan="2"><b>CGST @9%</b></td>
                                 <td>'.$order_data[0]["cgst_amount"].'</td>
                           </tr>
                           <tr>
        			            <td colspan="2"><b>SGST @9%</b></td>
                                 <td>'.$order_data[0]["sgst_amount"].'</td>
                           </tr>
                            <tr>
        			            <td colspan="2"><b>IGST @18%</b></td>
                                 <td>'.$order_data[0]["gst_amount"].'</td>
                           </tr>
        			       <tr> 
        			       <td colspan="2"><b>Total Amount</b></td>
        			       <td>'.$order_data[0]["net_amount"].'</td>
        			       </tr>
        			         <tr> 
        			       <td colspan="2"><b>Net Amount</b></td>
        			       <td>'.$order_data[0]["net_amount"].'</td>
        			       </tr>
        			        <tr> 
        			       <td colspan="2"><b>Amount Chargeable (In Words)</b></td>
        			       <td colspan="4">E. & O.E</td>
        			       </tr>
        			        <tr> 
        			       <td colspan="2"><p>('.$this->getIndianCurrency($order_data[0]["net_amount"]).')</p></td>
        			        <td colspan="4"></td>
        			       </tr>
        			       <tr> 
        			       <td  colspan="2"><p>PAYMENT DETAILS</p></td>
        			       <td colspan="4" rowspan="5">For Namotech Consultancy Services LLP</td>
        			       </tr>
        			       <tr> 
        			       <td><p>Bank Name</p></td>
        			       <td>'.$company["bank_name"].'</td>
        			       </tr>
        			        <tr> 
        			       <td><p>Account No.</p></td>
        			       <td>'.$company["account_number"].'</td>
        			       </tr>
        			        <tr> 
        			       <td><p>IFSC Code</p></td>
        			       <td>'.$company["ifsc_code"].'</td>
        			       </tr>
        			         <tr> 
        			       <td><p>Branch Name</p></td>
        			       <td>Vishvesariya Nagar, Gopalpura Bypass Jaipur</td>
        			       </tr>
        			       <tr>
        			       <td colspan="6"><b>This is a Computer Generated Invoice.</b></td>
        			        
        			       </tr>
        			       
    			         </tbody>
						</table>
			        </div> 
			         </div>
				     <div class="row" style="margin-top:50px;display:none">
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