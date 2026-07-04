<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ulrlink extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        $this->not_logged_in();
        
        $this->data['page_title'] = 'Bitumen Extraction Core Reports';
        
        $this->load->model('model_ulrlink');
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
        
        /*$ulrlink = $this->model_ulrlink->getallOrdersData();
        for($i=0;$i<count($ulrlink);$i++)
        {
            $id = $ulrlink[$i]['id'];
            $olddate = $ulrlink[$i]['ndate'];
            $newdate = date('Y-m-d',strtotime($olddate));
            
                $olddata = array
                (
                    'date' => $newdate, 
                );
		        $update = $this->model_ulrlink->update($olddata,$id); 
            
        }
        */
		$this->data['page_title'] = 'Manage Ulr';
		$this->render_template('ulrlink/index', $this->data);		
	}
	
    public function ulr_register()
	{
		if(!in_array('viewOrder', $this->permission)) 
		{
            redirect('dashboard', 'refresh');
        }
         $this->data['ulrlink'] = $this->model_ulrlink->getallOrdersData();
        
		$this->data['page_title'] = 'Manage Ulr Register';
		$this->render_template('ulrlink/ulr_register', $this->data);		
	}
	function export()
    {
        
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
       
       if($start_date != '' && $end_date != '')
       {
		    $data['ulrlink'] = $this->model_ulrlink->getallOrdersData();
       }
       else
       {
            $data['ulrlink'] = $this->model_ulrlink->getallOrdersData();
       }
	    $this->load->view('ulrlink/export', $data);    
    }
    
    
     	public function fetchAllOrdersData()
	{
		$result = array('data' => array());

		$data = $this->model_ulrlink->getallOrdersData();
		
		foreach ($data as $key => $value) 
		{
		    $buttons = '';
              
			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
		 
		    
		    $uiddata = $this->model_ulrlink->getolderUlrData($value['ulr_no']);
		      if($uiddata) {
		          
		          foreach($uiddata as $uiddatav){
		            $olduid = $uiddatav['uid_no'];
		         }
		         
			    $uiddata = '<div><p>'.$value['uid_no'].'</p><p style="background-color:yellow;padding:5px;">'.$olduid.'</p></div>';
		      }
		      else
		      {
		         $uiddata = $value['uid_no']; 
		      }
                $result['data'][$key] = array(
				$value['date'],
				$value['ulr_no'],
				$uiddata,
				$value['name_of_department'],
				$value['name_of_agency'],
				$value['name_of_project'],
				$value['sample_details'],
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
      	
		$data = $this->model_ulrlink->getallFilterOrdersData($start_date,$end_date);
		
		foreach ($data as $key => $value) 
		{
		    $buttons = '';
              
			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
		 
		    
		    $uiddata = $this->model_ulrlink->getolderUlrData($value['ulr_no']);
		      if($uiddata) {
		          
		          foreach($uiddata as $uiddatav){
		            $olduid = $uiddatav['uid_no'];
		         }
		         
			    $uiddata = '<div><p>'.$value['uid_no'].'</p><p style="background-color:yellow;padding:5px;">'.$olduid.'</p></div>';
		      }
		      else
		      {
		         $uiddata = $value['uid_no']; 
		      }
                $result['data'][$key] = array(
				$value['date'],
				$value['ulr_no'],
				$uiddata,
				$value['name_of_department'],
				$value['name_of_agency'],
				$value['name_of_project'],
				$value['sample_details'],
				$buttons
		    	);
	 
        }
		echo json_encode($result);
	    
	}
   
    public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$ulr_no = $this->input->post('ulr_no');

        $response = array();
        if($ulr_no) {
            $delete = $this->model_ulrlink->remove($ulr_no);
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
	
	public function fetchUlrDatadatewise()
	{
	     $date1 = date('Y-m-d');
         
        $data = $this->model_ulrlink->getUlrData($date1);
		 
		 $html = '';
		 
        $html.='<div><select class="form-control" onchange ="newUlrAdd();" id="ulr_no" name="ulr_no" placeholder="Enter UID No.">
        <option value="">Select Ulr No.</option>';
        
        foreach ($data as $key => $value) 
        {
        
        $html.='<option value="'.$value['ulr_no'].'">'.$value['ulr_no'].'</option>';
                            
                       
        }
        $html.='<option value="new">New Create</option></select>style="display:none;margin-top:4px;" placeholder = "New ULR NO." type="text" id="newulr_no" name="newulr_no" class="form-control"></div>'; 
        
        echo json_encode($html);
    }
   	public function fetchUlrotherDatadatewise()
	{
	    
        $date = $this->input->get('date', TRUE);
        
        if(isset($date))
        {
            $date1 = $date;
        }
        else
        {
            $date1 = date('Y-m-d');
        }
        $data = $this->model_ulrlink->getUlrData($date1);
		 
		 $html = '';
		 
        $html.='<div><select class="form-control" onchange ="newUlrAdd();" id="ulr_no" name="ulr_no" placeholder="Enter UID No.">
        <option value="">Select Ulr No.</option>';
        $assing = '';
        foreach ($data as $key => $value) 
        {
        if(!empty($value['uid_no']))
        {
            $assing = '(Assign)';
        }
        else
        {
            $assing = '';
        }
        $html.='<option value="'.$value['ulr_no'].'">'.$value['ulr_no'].$assing.'</option>';
                            
                       
        }
        $html.='<option value="new">New Create</option></select><input style="display:none;margin-top:4px;" placeholder = "New ULR NO." type="text" id="newulr_no" name="newulr_no" class="form-control"></div>'; 
        
        echo json_encode($html);
    }
    public function getClientDetails()
    {
        $uid_no = $_GET['uid_no'];
       
        
        /*$ID = str_pad($uid_no, 5, '0', STR_PAD_LEFT);
        
        $year = date('Y');
        $uid_no = 'NAMO/MC/'.$year.'/'.$ID;*/
        
        if($uid_no) 
        {
			$data = $this->model_ulrlink->getDataByregistration($uid_no);
			
		  	if($data == true) {
		  	    
		  	        /*$data1 = $this->model_ulrlink->checkassingulrno($uid_no);
		  	         
		  	    	if($data1 == true) 
		  	    	{
		  	    	    $data['success'] = false;
                        $data['messages'] = "Already ULR No.Assign";
		  	    	}
		  	    	else
		  	    	{
		  	    	   $data['success'] = true; 
			           $data['messages'] = "Record Found!"; 
		  	        }*/
		  	    $data['success'] = true; 
			    $data['messages'] = "Record Found!"; 
			    
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
    function create()
    {
        $uid_no = $_GET['uid_no'];
        /*$ID = str_pad($uid_no, 5, '0', STR_PAD_LEFT);
        
        $year = date('Y');
        $uid_no = 'NAMO/MC/'.$year.'/'.$ID;*/
        $ulr_no = $_GET['ulr_no'];
         $date = date('Y-m-d',strtotime($_GET['date']));
             
        if($ulr_no == 'new')
        {
            $ulr_no = $_GET['newulr_no'];
           
             
            $checkexit = $this->model_ulrlink->checkassinguidno($ulr_no);
            
         
		  	if($checkexit == true) 
		    {
		        $getdata = $this->model_ulrlink->getulrdatarow($ulr_no);
		         
		        $olddata = array
                (
                    'ulr_no' => $ulr_no,
        	        'uid_no' => $getdata[0]['uid_no'], 
                    'name_of_agency'  =>  $getdata[0]['agency_name'],
                    'name_of_department'  =>  $getdata[0]['reporting_address'], 
                    'name_of_project'  =>  $getdata[0]['name_of_work'],
                    'sample_details'  =>  $getdata[0]['sample_details'],
                );
		        $update = $this->model_ulrlink->copyolduidrecords($olddata);  
		        
		    }
            
            $data = array
            (
                'ulr_no' => $ulr_no,
    	        'uid_no' => $uid_no,
                'date'  => $date,
                'name_of_agency'  =>  $_GET['agency_name'],
                'name_of_department'  =>  $_GET['reporting_address'], 
                'name_of_project'  =>  $_GET['name_of_work'],
                'sample_details'  =>  $_GET['sample_details'],
            );
            $update = $this->model_ulrlink->createnewulr($data); 
            
            
            $ID1 = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        
            $year = date('Y');
            $newurl = 'NCS/LAB/'.$year.'/'.$ID1;
            $data2 = array
            (
                'ulr_no' => $newurl,
    	         
            ); 
            $updateurl = $this->model_labreports->updateulrno($data2,$uid_no,$date); 
            
             
            
            if($update == true) {
                $data1['success'] = true;
                $data1['messages'] = "Successfully Created"; 
            
            }
        }
        else
        {
            $checkexit = $this->model_ulrlink->checkassinguidno($ulr_no);
            
            
		  	if($checkexit == true) 
		    {
		        $getdata = $this->model_ulrlink->getulrdatarow($ulr_no);
		        
		        $olddata = array
                (
                    'ulr_no' => $ulr_no,
        	        'uid_no' => $getdata['uid_no'], 
                    'name_of_agency'  =>  $getdata['name_of_agency'],
                    'name_of_department'  =>  $getdata['name_of_department'], 
                    'name_of_project'  =>  $getdata['name_of_project'],
                    'sample_details'  =>  $getdata['sample_details'],
                );
		        $update = $this->model_ulrlink->copyolduidrecords($olddata);  
		        
		    }
            
            
            $data = array
            (
    	        'uid_no' => $uid_no,
                'name_of_department'  =>  $_GET['reporting_address'],
                'name_of_agency'  =>  $_GET['agency_name'],
                'name_of_project'  =>  $_GET['name_of_work'],
                'sample_details'  =>  $_GET['sample_details'],
            );
            $update = $this->model_ulrlink->updateulrno($data,$ulr_no,$date); 
            
            $ID1 = str_pad($ulr_no, 5, '0', STR_PAD_LEFT);
        
            $year = date('Y');
            $newurl = 'NCS/LAB/'.$year.'/'.$ID1;
        
        
            /*$data2 = array
            (
                'ulr_no' => $newurl,
    	         
            );
            $updateurl = $this->model_labreports->updateulrno($data2,$uid_no); */
            if($update == true) {
                $data1['success'] = true;
                $data1['messages'] = "Successfully Update"; 
            
            }
        }
        echo json_encode($data1);
    }
    
    
    public function getulrbyuid()
    {
         $uid_no = $_GET['uid_no'];
         $data = $this->model_ulrlink->getulrnobyuid($uid_no);
         
         $html = '';
         $html.='<div class="col-xs-4">
                          <p>ULR No.</p>
                      </div>
                      <div class="col-xs-8"><select class="form-control" id="ulr_no" name="ulr_no">
                <option value="">Select Ulr No</option>';
                foreach ($data as $key => $value) 
        {
             $html.='<option value="'.$value['ulr_no'].'">'.$value['ulr_no'].'</option>';
        }
         $html.='</select></div>';
         
         echo json_encode($html); 
    }
    
}