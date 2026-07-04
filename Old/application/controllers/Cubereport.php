<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cubereport extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Cube Reports';
        
      
         
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
		$this->render_template('cube/index', $this->data);		
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

		$data = $this->model_labreports->getcubeOrdersData();
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewOrder', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('cubereport/update/'.$value['iReportId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
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
 
            $uid_no = '<a href="'.base_url('cubereport/update/'.$value['iReportId']).'">'.$value['uid_no'].'</a>';
            
            
            $date = date('d M Y',strtotime($value['create_date']));
			$date_time = $date;
                
			    $result['data'][$key] = array(
				$date_time,
				$uid_no,
				$value['customer_details'],
				$value['agency_name'],
				$value['date_of_casting'],
				$value['date_of_testing'],
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
       
		$data = $this->model_labreports->getcubeOrdersDataFilter($start_date,$end_date);
		  
		 
		
		foreach ($data as $key => $value) 
		{
         
			// button
			$buttons = '';
            
			if(in_array('viewOrder', $this->permission)) 
			{
				$buttons .= '<a target="__blank" onclick="printFunc('.$value['iReportId'].')" data-toggle="modal" data-target="#printModal" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('cubereport/update/'.$value['iReportId']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
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
 
            $uid_no = '<a href="'.base_url('cubereport/update/'.$value['iReportId']).'">'.$value['uid_no'].'</a>';
            
            
            $date = date('d M Y',strtotime($value['create_date']));
			$date_time = $date;
                
			    $result['data'][$key] = array(
				$date_time,
				$uid_no,
				$value['customer_details'],
				$value['agency_name'],
                $value['date_of_casting'],
                $value['date_of_testing'],
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
        $this->data['cubes'] = $this->model_labreports->getcubeDataByregistration();
         
		$this->form_validation->set_rules('uid_no', 'UID Number', 'trim|required');
		$this->form_validation->set_rules('ulr_no', 'ULR Number', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {        	
        	$uid_no = $this->input->post('uid_no');
        	$iReportId = $this->model_labreports->createcube();
        	
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
                      'size_of_cube' => $this->input->post('size_of_cube_'.$i),
                      'date_of_casting' => $this->input->post('date_of_casting_'.$i),
                      'date_of_testing' => $this->input->post('date_of_testing_'.$i),
                      'age_of_specimen' => $this->input->post('age_of_specimen_'.$i),
                      'avg_comp_strength' => $this->input->post('avg_comp_strength_'.$i),
                      'is_code_comp_strength' => $this->input->post('is_code_comp_strength_'.$i),
                      'load_1' => $this->input->post('load_'.$i.'_1'),
                      'load_2' => $this->input->post('load_'.$i.'_2'),
                      'load_3' => $this->input->post('load_'.$i.'_3'),
                      'comp_strength_1' => $this->input->post('comp_strength_'.$i.'_1'),
                      'comp_strength_2' => $this->input->post('comp_strength_'.$i.'_2'),
                       'comp_strength_3' => $this->input->post('comp_strength_'.$i.'_3'),
                      'set_count' => $countset
                );
                $create = $this->model_labreports->createreport($data);
            }
             
        	if($iReportId) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('cubereport', 'refresh');
        	}
        	else 
        	{
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('cubereport/create/', 'refresh');
        	}
        }
        else {
            // false case
           $this->render_template('cube/create', $this->data);
        }	
	}


    public function getClientDetails()
    {
        $uid_no = $_GET['uid_no'];
         
        
        if($uid_no) 
        {
			$data = $this->model_labreports->getcubeDataByregistration($uid_no);
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

		$this->form_validation->set_rules('ulr_no', 'Ulr number', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) 
        {        	
        	
        	$update = $this->model_labreports->updatecube($id);
         
             $countset = $this->input->post('countset');
            for($j=0; $j < $countset; $j++)
            {
                    $i = $j+1;
                    
                    $iCubeId = $this->input->post('iCubeId_'.$i);
                    
                    $data = array
                    (
            	        'location' => $this->input->post('location_'.$i),
                         'size_of_cube' => $this->input->post('size_of_cube_'.$i),
                         'date_of_casting' => $this->input->post('date_of_casting_'.$i),
                        'date_of_testing' => $this->input->post('date_of_testing_'.$i),
                         'age_of_specimen' => $this->input->post('age_of_specimen_'.$i),
                        'avg_comp_strength' => $this->input->post('avg_comp_strength_'.$i),
                         'is_code_comp_strength' => $this->input->post('is_code_comp_strength_'.$i),
                        'load_1' => $this->input->post('load_'.$i.'_1'),
                        'load_2' => $this->input->post('load_'.$i.'_2'),
                        'load_3' => $this->input->post('load_'.$i.'_3'),
                        'comp_strength_1' => $this->input->post('comp_strength_'.$i.'_1'),
                         'comp_strength_2' => $this->input->post('comp_strength_'.$i.'_2'),
                        'comp_strength_3' => $this->input->post('comp_strength_'.$i.'_3'),
                        'set_count' => $countset
                    );
                 
                $create = $this->model_labreports->updatecubereport($data,$iCubeId);
            }
            
        	//$this->printDiv_updatemail($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        	 redirect('cubereport/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('cubereport/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
            $result = array();
        	$orders_data = $this->model_labreports->getcubeOrdersData($id);
        	 
        	 
        	$result['order'] = $orders_data;
    		 

    		$this->data['order_data'] = $result;
     	

            $this->render_template('cube/edit', $this->data);
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
            $delete = $this->model_labreports->cuberemove($iReportId);
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
			$order_data = $this->model_labreports->getcubeOrdersData($id); 
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
                        <p style="text-align:right;">Date: '.$order_data[0]['dispatch_date'].'</p>			
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
                      <div class="col-xs-4" style="height: 45px;">
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
                        <h5 style="color:#000!important;text-transform: uppercase;text-align:center;font-size:16px;border: 1px solid;padding: 4px;font-weight: bold;">TEST RESULTS (As per IS : 516-1959 Reaf 2018)</h5>
                       </div>
                    
                    <div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <td style="border:1px solid;color:#000;">S. N</td>
    			            <td style="border:1px solid;color:#000;">Location</td>
							 <td style="border:1px solid;color:#000;">Size of cubes mm2</td>
    			            <td style="border:1px solid;color:#000;">Date of Casting</td>
    			            <td style="border:1px solid;color:#000;">Date of Testing</td>
    			            <td style="border:1px solid;color:#000">Age of Specimen</td>
    			            <td style="border:1px solid;color:#000;">Load  (KN)</td>
    			            <td style="border:1px solid;color:#000;">Comp. Strength  (N/mm2)</td>
    			            <td style="border:1px solid;color:#000;">Avg. comp. strength (N/mm2)</td>
    			             <td style="border:1px solid;color:#000;">As per IS Code  comp. strength (N/mm2)</td>
    			        </tr>';
    			        
    			         
                          $rowcount = $order_data[0]['set_count'];
                            
                            for($i=0;$i<$rowcount;$i++){
                                $j = $i+1;
                            
    			        
    			        	$html .= '<tr>
    			            <td>1</td>
    			            <td rowspan="3" style="vertical-align: middle;"><p>'.$order_data[$i]['location'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;"> <p>'.$order_data[$i]['size_of_cube'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;">  <p>'.$order_data[$i]['date_of_casting'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;">  <p>'.$order_data[$i]['date_of_testing'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;">  <p>'.$order_data[$i]['age_of_specimen'].'</p></td>
    			            <td><p>'.$order_data[$i]['load_1'].'</p></td>
    			            <td><p>'.$order_data[$i]['comp_strength_1'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;">  <p>'.$order_data[$i]['avg_comp_strength'].'</p></td>
    			            <td rowspan="3" style="vertical-align: middle;"> <p>'.$order_data[$i]['is_code_comp_strength'].'</p></td>
    			        </tr>
    			         <tr>
    			            <td>2</td>
    			             <td><p>'.$order_data[$i]['load_2'].'</p></td>
    			            <td><p>'.$order_data[$i]['comp_strength_2'].'</p></td>
    			        </tr>
    			         <tr>
    			            <td>3</td>
    			             <td><p>'.$order_data[$i]['load_3'].'</p></td>
    			            <td><p>'.$order_data[$i]['comp_strength_3'].'</p></td>
    			         </tr>';
                            }
    			         
    			        $html.='</tbody>
						</table>
			        </div>
			        
			        <div class="col-xs-12">
				    <div class="col-xs-12">
			             <p>For Namotech Consultancy Services LLP</p>';
			            if($order_data[0]['status'] == "Complete"){
			                $html.='<img class="img-responsive" src="/assets/images/digital_sign_1.png" style="position: absolute;width: 150px;margin-top: -37px;margin-left: 0px;">';
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
				    <div class="row" style="margin-top:100px;">
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