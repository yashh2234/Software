<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ferrocover extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Main Hole Cover Reports';
        
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
		$this->render_template('ferrocover/index', $this->data);		
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

		$data = $this->model_labreports->getferrocoverOrdersData();
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewOrder', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('ferrocover/update/'.$value['iReportId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewOrder', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iReportId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			 
            if($value['status'] == 'Complete')
            {
                $status = '<span class="label label-success">Complete</span>';
            }
            else if($value['status'] == 'Pending'){
				$status = '<span class="label label-warning">Pending</span>';
			}
			else if($value['status'] == 'Cancel'){
				$status = '<span class="label label-danger">Cancel</span>';
			}
 
            $uid_no = '<a href="'.base_url('ferrocover/update/'.$value['iReportId']).'">'.$value['uid_no'].'</a>';
            
            
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
				$buttons,
				$status
				
		    	);
	 
}
		echo json_encode($result);
	    
	}
  
	 	public function fetchOrdersFilterData()
	{
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
		$data = $this->model_labreports->getferrocoverOrdersDataFilter($start_date,$end_date);
	 
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewOrder', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('ferrocover/update/'.$value['iReportId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			if(in_array('viewOrder', $this->permission)) {
				//$buttons .= ' <a href="/orders/generatepdf/'.$value['iReportId'].'/"  class="btn btn-default"><i class="fa fa-download"></i></a>';
			}
			 
            if($value['status'] == 'Complete')
            {
                $status = '<span class="label label-success">Complete</span>';
            }
            else if($value['status'] == 'Pending'){
				$status = '<span class="label label-warning">Pending</span>';
			}
			else if($value['status'] == 'Cancel'){
				$status = '<span class="label label-danger">Cancel</span>';
			}
 
            $uid_no = '<a href="'.base_url('ferrocover/update/'.$value['iReportId']).'">'.$value['uid_no'].'</a>';
            
            
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
				$buttons,
				$status
				
		    	);
	 
}
		echo json_encode($result);
	    
	}
  
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Create Report';
        $this->data['cubes'] = $this->model_labreports->getferrocoverDataByregistration();
         
		$this->form_validation->set_rules('uid_no', 'UID Number', 'trim|required');
		
		$this->form_validation->set_rules('ulr_no', 'ULR Number', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {        	
        	$uid_no = $this->input->post('uid_no');
        	$iReportId = $this->model_labreports->createferrocover();
        	
            /* mail function*/
               //$this->printDiv_mail($order_id);
            /*******************/
            $countset = $this->input->post('countset');
            
            
            for($j=0; $j < $countset; $j++)
            {
                $i = $j+1;
                $data = array
              (
        	      'iReportId' => $iReportId,
                  'uid_no' =>  $uid_no,
                  'location' => $this->input->post('location_'.$i),
                  'cover_type' => $this->input->post('cover_type_'.$i),
                  'dia_of_plat' => $this->input->post('dia_of_plat_'.$i),
                  'date_of_sample_collection' => $this->input->post('date_of_sample_collection_'.$i),
                  'date_of_testing' => $this->input->post('date_of_testing_'.$i),
                  'applying_of_load' => $this->input->post('applying_of_load_'.$i),
                  'observation' => $this->input->post('observation_'.$i),
                  'remark' => $this->input->post('remark_'.$i),
                  'set_count' => $countset
                );
                $create = $this->model_labreports->createferrocoverreport($data);
            }
             
        	if($iReportId) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('ferrocover', 'refresh');
        	}
        	else 
        	{
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('ferrocover/create/', 'refresh');
        	}
        }
        else {
            // false case
           $this->render_template('ferrocover/create', $this->data);
        }	
	}


    public function getClientDetails()
    { 
        $uid_no = $_GET['uid_no'];
         
        if($uid_no) 
        {
			$data = $this->model_labreports->getferrocoverDataByregistration($uid_no);
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
	  
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('ulr_no', 'ULR Number', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) 
        {        	
        	
        	$update = $this->model_labreports->updateferrocover($id);
        	    $countset = $this->input->post('countset');
            
                for($j=0; $j < $countset; $j++)
                {
                    $i = $j+1;
                    $id = $this->input->post('iFerroId_'.$i);
                    $data = array
                    (
                      'location' => $this->input->post('location_'.$i),
                      'cover_type' => $this->input->post('cover_type_'.$i),
                      'dia_of_plat' => $this->input->post('dia_of_plat_'.$i),
                      'date_of_sample_collection' => $this->input->post('date_of_sample_collection_'.$i),
                      'date_of_testing' => $this->input->post('date_of_testing_'.$i),
                      'applying_of_load' => $this->input->post('applying_of_load_'.$i),
                      'observation' => $this->input->post('observation_'.$i),
                      'remark' => $this->input->post('remark_'.$i),
                    );
                    $update = $this->model_labreports->updateferrocoverreport($data,$id);
                }
                 
                
            
            
        	//$this->printDiv_updatemail($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        	 redirect('ferrocover/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('ferrocover/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
            $result = array();
        	$orders_data = $this->model_labreports->getferrocoverOrdersData($id);
        	
        	 
        	$result['order'] = $orders_data;
    		 

    		$this->data['order_data'] = $result;
     	

            $this->render_template('ferrocover/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	
		public function cancel()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$iReportId = $this->input->post('iReportId');

        $response = array();
        if($iReportId) {
            $delete = $this->model_labreports->cancel($iReportId);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully Cancel Report"; 
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

	public function approve()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$iReportId = $this->input->post('iReportId');

        $response = array();
        if($iReportId) {
            $delete = $this->model_labreports->approve($iReportId);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully Cancel Report"; 
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

	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$iReportId = $this->input->post('iReportId');

        $response = array();
        if($iReportId) {
            $delete = $this->model_labreports->ferrocoverremove($iReportId);
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
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_labreports->getferrocoverOrdersData($id); 
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
.table > thead > tr
{ 
    color: white !important;
}
.table-striped > tbody > tr:nth-of-type(2n+1) {
  background-color: #fff;
}
.table > thead > tr > th
{
border: 1px solid;
padding:2px !important;
font-size: 14px;
}
.table > tbody > tr > td
{
border: 1px solid;
padding:2px !important;
font-size: 14px;
text-align: center;

}
 
p 
{
  font-size: 14px;
  margin: 0 0 2px;text-transform: capitalize;
}
.col-xs-4 p {
  font-size: 14px;
  font-weight: bold;
}
.col-xs-4 {
  border-right: 1px solid;
}
.col-xs-12, .col-sm-12
{
    padding-left:2px;
    padding-right:2px;
}
.col-xs-6, .col-xs-4, .col-xs-8
{
     padding-left:2px;
    padding-right:2px;
}
</style>
			</head>
			<body>
		       <div class="container">
		       <div class="row" style="margin-bottom:30px;">
		            <div class="col-xs-12 col-sm-12">
		            <img src="'.base_url().'assets/images/report_header.jpeg" class="img-responsive" style="width: 1170px;height: 170px;">
		            </div>
		        </div>
		        <div class="row" style="border:2px solid;">
		            <div class="col-xs-12 col-sm-12">
		            <h5 style="color:#000!important;text-transform: uppercase;text-align:center;font-size:17px;border: 1px solid;padding: 4px;font-weight: bold;">TEST REPORT</h5>
                   </div>
                 <div class="col-xs-12 col-sm-12" style="border: 1px solid;width: 99.3%;margin-left: 3px;">
                    <div class="col-xs-6">
                        <p>Format No:NCS/TR/09</p>			
                        <p><b>'. $order_data[0]['ulr_no'].'</b></p>			
                         			
                    </div>
			        <div class="col-xs-6">
			        <p style="height: 20px;"></p>
                         <p style="text-align:right">Date: '.$order_data[0]['dispatch_date'].'</p>			
                    </div>
                 </div>
		             <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Name & Address of Costumer</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['customer_details'].'</p>
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Name of Agency</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['agency_name'].'</p>
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Reference No.</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['reference_no'].'</p>
                          
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4" >
                          <p>Material Identification Details			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['material_details'].'</p>
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Source/Location 			
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['source_location'].'</p>
                       </div>
                    </div>			  
                    
                     		  
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Work order No.			
                    
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['work_order_no'].'</p>
                       </div>
                    </div>		
                     <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Receipt</p>
                      </div>
                      <div class="col-xs-8">
                         <p>'.$order_data[0]['sample_date'].'</p>
                       </div>
                    </div>			  
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['sample_tested_date'].'</p>
                       </div>
                    </div>		   
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                      <div class="col-xs-4">
                          <p>Condition of Sample </p>
                      </div>
                      <div class="col-xs-8">
                          <p>'.$order_data[0]['sampled_by'].'</p>
                       </div>
                    </div>		   
                    <div class="col-xs-12 col-sm-12"  style="border-bottom: 1px solid;width: 99.3%;border-left: 1px solid;border-right: 1px solid;margin-left: 3px;">
                    			          <div class="col-xs-4">
                    			              <p>Environment Condition	 </p>
                    			          </div>
                    			          <div class="col-xs-8">
                    			             <p>'.$order_data[0]['environment_condition'].'</p></div>
                    			     </div>				
			     
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="color:#000!important;text-transform: uppercase;text-align:center;font-size:16px;border: 1px solid;padding: 4px;font-weight: bold;">TEST RESULTS (As per IS : 12592-2002,Manhole Cover)</h5>
                       </div>
                    
                    <div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						 <tr>
    			            
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Location</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Dia Of Plat (mm)</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Sample Collection</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date Of Testing</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Applying of Load(KN)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Observation</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Remark</th>
    			        
    			        </tr>';
    			             $countset = $order_data[0]['set_count'];
                            
    			                
        			            for($j=0; $j < $countset; $j++)
                                {
                                    
                               $i= $j+1; 
                               
    			             $html.='<tr>
        			            <td colspan ="8" style="font-weight:bold;text-align:left;">(A)'.$order_data[$j]['cover_type'].'
        			            </td>
    			            </tr>
    			            <tr>
                                <td>'.$i.'</td>
                                <td>'.$order_data[$j]['location'].'</td>
                                <td>'.$order_data[$j]['dia_of_plat'].'</td>
                                <td>'.$order_data[$j]['date_of_sample_collection'].'</td>
                                <td>'.$order_data[$j]['date_of_testing'].'</td>
                                <td>'.$order_data[$j]['applying_of_load'].'</td>
                                <td>'.$order_data[$j]['observation'].'</td>
                                <td>'.$order_data[$j]['remark'].'</td>
        			        </tr>';
                                }
        		        $html.='</tbody>
						</table>
			        </div>
			        
			        <div class="col-xs-12">
				    <div class="col-xs-12">
			             <p>For Namotech Consultancy Services LLP</p>';
			            if($order_data[0]['status'] == "Complete"){
			                $html.='<img class="img-responsive" src="/assets/images/digital_sign_1.png" style="position: absolute;width: 190px;margin-top: -30px;margin-left: 32px;">';
			            }
			            $html.='<p><b>Omendra Gupta-Managing Director</b></p>
						<p><b>Authorized Signatory</b></p>
				    </div>
			        
			        </div>
			         
				    <div class="col-xs-12">
			            <p><b>Note:	</b></p> 
                        <p>1.Results related only to the sample (s) under test in as received condition and applicable parameter(s).</p>
                        <p>
                        2.This Test Report shall not reproduce wholly or in part and cannot be used as evidence in the court of law without written approval of Namotech Consultancy LLP.	</p>
                        <p>
                        3.The sample will be stored up to one month from the date of issue of Test Report unless otherwise specified.									
                        </p>
				    </div>
				    <div class="col-xs-12">
			            <p style="text-align:center;"><b>*** End Of Report ***</b></p>
			             
				    </div>
				    </div>
				      <div class="row" style="margin-top:90px;">
    				    <div class="col-xs-12">
    			            <img src="'.base_url().'assets/images/report_footer.jpeg" class="img-responsive" style="width: 1170px;height: 100px;">
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
 
   
}