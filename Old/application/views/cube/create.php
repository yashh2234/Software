 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create
      <small>Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Create Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Create Report</h3>
            </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('cubereport/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d , h:i a') ?></label>
                </div>
                

                <div class="row uidsection">
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>UID No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input list="brow" type="text" class="form-control" id="uid_no" name="uid_no" placeholder="Enter UID No." />
        					     <datalist id="brow">
                                       <?php foreach ($cubes as $k => $v): ?>
                                            <option value="<?php echo $v['uid_no'] ?>"><?php echo $v['uid_no'];?>
                                            </option>
                                            <?php endforeach ?>
                                    </datalist> 
                       </div>
                    </div>
                   
                </div>
                <div class="row formsection" style="display:none;"> 
                 <div class="col-xs-12" style="margin: 5px 0px;" id="ulrdata">
                      <div class="col-xs-4">
                          <p>ULR No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="ulr_no" name="ulr_no" placeholder="Enter ULR No." />
        			    </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name & Address of Costumer</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="customer_details" name="customer_details" placeholder="Enter Customer Name & Address" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name of Agency</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="agency_name" name="agency_name" placeholder="Enter Agency Name" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Reference No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Enter Reference Number" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4" >
                          <p>Material Identification Details			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <select class="form-control" id="material_details" name="material_details">
                              <option value="">Select Cube Sample</option>
                              <option value="Cube Sample (01 Set)">Cube Sample (01 Set)</option>
                              <option value="Cube Sample (02 Set)">Cube Sample (02 Set)</option>
                              <option value="Cube Sample (03 Set)">Cube Sample (03 Set)</option>
                              <option value="Cube Sample (04 Set)">Cube Sample (04 Set)</option>
                              <option value="Cube Sample (05 Set)">Cube Sample (05 Set)</option> 
                          </select>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name Of Work 			
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="source_location" name="source_location" placeholder="Enter Name Of Work" />
                       </div>
                    </div>			  
                    
                     		  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Work order No.			
                    
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="work_order_no" name="work_order_no" placeholder="Enter Work Order No" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Receipt</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_date" name="sample_date" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_tested_date" name="sample_tested_date"/>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Sampled by /Condition of Sample </p>
                      </div>
                      <div class="col-xs-8">
                          <select class="form-control" id="sampled_by" name="sampled_by">
                            <option value="Sample Supplied By Customer">Sample Supplied By Customer</option>
                            <option value="Sample Collected By Ncs" >Sample Collected By Ncs</option>
                        </select>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                    			          <div class="col-xs-4">
                    			              <p>Environment Condition			
                    			
                    
                    			
                    .</p>
                    			          </div>
                    			          <div class="col-xs-8">
                    			              <input type="text" class="form-control" value="As Per the Prescribed test Method" id="environment_condition" name="environment_condition" placeholder="Enter Environment Condition" />
                    			           </div>
                    			     </div>	<div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Dispatch Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="dispatch_date" name="dispatch_date"/>
                       </div>
                    </div>			
			      </div>
			    
			    <div class="row formsection" style="display:none;">
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS (As per IS : 516-1959 Reaf 2018)</h5>
                       </div>
                    </div>
			    <div class="row formsection" style="display:none;">
                      
<div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Location</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Size of cubes mm2</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Casting</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Testing</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Age of Specimen</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Load  (KN)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Comp. Strength  (N/mm2)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Avg. comp. strength (N/mm2)</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">As per IS Code  comp. strength (N/mm2)</th>
    			        </tr>
        			     <tr class="set_1">
        			            <td>1</td>
        			            <td rowspan="3">
        			                <input type="text" class="form-control" id="location_1" name="location_1" /> 
        			            </td>
        			            <td rowspan="3">  <select class="size_of_cube form-control" id="size_of_cube_1" name="size_of_cube_1">
        			                    <option value="22500">22500</option>
        			                    <option value="2500">2500</option>
        			                </select>
        			            </td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_casting" name="date_of_casting_1" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_testing" name="date_of_testing_1"/></td>
        			            <td rowspan="3">  
        			            <select class="form-control" id="age_of_specimen" name="age_of_specimen_1">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 Days">After 28 Days</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="load_1_1" name="load_1_1" onkeyup="load('1_1',1);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_1_1" name="comp_strength_1_1" placeholder="Enter Comp Strength" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_1" name="avg_comp_strength_1" value="0" placeholder="Avg Comp Strength" /></td>
        			            <td rowspan="3">  
        			            <select class="form-control is_code_comp_strength_cc" id="is_code_comp_strength_cc" name="is_code_comp_strength_1" style="display:block">
                                        <option value="5/(CC 1:5:10)">5/(CC 1:5:10)</option>
                                        <option value="7.5/(CC 1:4:8)">7.5/(CC 1:4:8)</option>
                                        <option value="10/(CC 1:3:6)">10/(CC 1:3:6)</option>
                                        <option value="15/(CC 1:2:4)">15/(CC 1:2:4)</option>
                                        <option value="20/(CC-1:1.5:3)">20/(CC-1:1.5:3)</option>
                                        <option value="25/(CC-1:1:2)">25/(CC-1:1:2)</option>
                                        <option value="20/(CC-M-20)">20/(CC-M-20)</option>
                                        <option value="25/(CC-M-25)">25/(CC-M-25)</option>
                                        <option value="30/(CC-M-30)">30/(CC-M-30)</option>
                                        <option value="35/(CC-M-35)">35/(CC-M-35)</option>
                                        <option value="40/(CC-M-40)">40/(CC-M-40)</option>
                                        <option value="45/(CC-M-45)">45/(CC-M-45)</option>
                                        <option value="50/(CC-M-50)">50/(CC-M-50)</option>
        			               
        			                    <option value="3.0-5.0/CM -1:6">3.0-5.0/CM -1:6</option>
        			                    <option value="5.0-7.5/CM 1:4">5.0-7.5/CM 1:4</option>
        			                    <option value="7.5-10/CM 1:3">7.5-10/CM 1:3</option>
        			                </select>
        			              </td>
        			        </tr>
        			     <tr class="set_1">
        			            <td>2</td>
        			             <td><input type="text" class="form-control" id="load_1_2" name="load_1_2"  onkeyup="load('1_2',1);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_1_2" name="comp_strength_1_2" placeholder="Enter Comp Strength" /></td>
        			        </tr>
        			     <tr class="set_1">
        			            <td>3</td>
        			             <td><input type="text" class="form-control" id="load_1_3" name="load_1_3" onkeyup="load('1_3',1);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_1_3" name="comp_strength_1_3" placeholder="Enter Comp Strength" /></td>
        			         </tr>
        			     <tr class="set_2" style="display:none;">
        			            <td>1</td>
        			            <td rowspan="3">
        			                 <input type="text" class="form-control" id="location_2" name="location_2" /> 
        			                
        			                </td>
        			            <td rowspan="3">  <select class="size_of_cube form-control" id="size_of_cube_2" name="size_of_cube_2">
        			                    <option value="22500">22500</option>
        			                    <option value="2500">2500</option>
        			                </select>
        			            </td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_casting" name="date_of_casting_2" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_testing" name="date_of_testing_2"/></td>
        			            <td rowspan="3">  
        			            <select class="form-control" id="age_of_specimen" name="age_of_specimen_2">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 days">After 28 days</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="load_2_1" name="load_2_1" onkeyup="load('2_1',2);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_2_1" name="comp_strength_2_1" placeholder="Enter Comp Strength" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_2" name="avg_comp_strength_2" value="0" placeholder="Avg Comp Strength" /></td>
        			            <td rowspan="3">  
        			                <select class="form-control is_code_comp_strength_cc" id="is_code_comp_strength_cc" name="is_code_comp_strength_2" style="display:block">
                                        <option value="5/(CC 1:5:10)">5/(CC 1:5:10)</option>
                                        <option value="7.5/(CC 1:4:8)">7.5/(CC 1:4:8)</option>
                                        <option value="10/(CC 1:3:6)">10/(CC 1:3:6)</option>
                                        <option value="15/(CC 1:2:4)">15/(CC 1:2:4)</option>
                                        <option value="20/(CC-1:1.5:3)">20/(CC-1:1.5:3)</option>
                                        <option value="25/(CC-1:1:2)">25/(CC-1:1:2)</option>
                                        <option value="20/(CC-M-20)">20/(CC-M-20)</option>
                                        <option value="25/(CC-M-25)">25/(CC-M-25)</option>
                                        <option value="30/(CC-M-30)">30/(CC-M-30)</option>
                                        <option value="35/(CC-M-35)">35/(CC-M-35)</option>
                                        <option value="40/(CC-M-40)">40/(CC-M-40)</option>
                                        <option value="45/(CC-M-45)">45/(CC-M-45)</option>
                                        <option value="50/(CC-M-50)">50/(CC-M-50)</option>
                                        <option value="3.0-5.0/CM -1:6">3.0-5.0/CM -1:6</option>
                                        <option value="5.0-7.5/CM 1:4">5.0-7.5/CM 1:4</option>
                                        <option value="7.5-10/CM 1:3">7.5-10/CM 1:3</option>
        			                </select>
        			              </td>
        			        </tr>
        			     <tr class="set_2" style="display:none;">
        			            <td>2</td>
        			             <td><input type="text" class="form-control" id="load_2_2" name="load_2_2" onkeyup="load('2_2',2);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_2_2" name="comp_strength_2_2" placeholder="Enter Comp Strength" /></td>
        			        </tr>
        			     <tr class="set_2" style="display:none;">
        			            <td>3</td>
        			             <td><input type="text" class="form-control" id="load_2_3" name="load_2_3" onkeyup="load('2_3',2);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_2_3" name="comp_strength_2_3" placeholder="Enter Comp Strength" /></td>
        			         </tr>
        			       
        			     <tr class="set_3" style="display:none;">
        			            <td>1</td>
        			            <td rowspan="3">
        			                <input type="text" class="form-control" id="location_3" name="location_3" /> 
        			                </td>
        			            <td rowspan="3">  <select class="size_of_cube form-control" id="size_of_cube_3" name="size_of_cube_3">
        			                    <option value="22500">22500</option>
        			                    <option value="2500">2500</option>
        			                </select>
        			            </td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_casting" name="date_of_casting_3" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_testing" name="date_of_testing_3"/></td>
        			            <td rowspan="3">  
        			            <select class="form-control" id="age_of_specimen" name="age_of_specimen_3">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 days">After 28 days</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="load_3_1" name="load_3_1" onkeyup="load('3_1',3);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_3_1" name="comp_strength_3_1" placeholder="Enter Comp Strength" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_3" name="avg_comp_strength_3" value="0" placeholder="Avg Comp Strength" /></td>
        			            <td rowspan="3">  
        			             <select class="form-control is_code_comp_strength_cc" id="is_code_comp_strength_cc" name="is_code_comp_strength_3" style="display:block">
        			                    <option value="5/(CC 1:5:10)">5/(CC 1:5:10)</option>
        			                    <option value="7.5/(CC 1:4:8)">7.5/(CC 1:4:8)</option>
        			                    <option value="10/(CC 1:3:6)">10/(CC 1:3:6)</option>
        			                    <option value="15/(CC 1:2:4)">15/(CC 1:2:4)</option>
        			                    <option value="20/(CC-1:1.5:3)">20/(CC-1:1.5:3)</option>
                                        <option value="25/(CC-1:1:2)">25/(CC-1:1:2)</option>
        			                      <option value="20/(CC-M-20)">20/(CC-M-20)</option>
        			                    <option value="25/(CC-M-25)">25/(CC-M-25)</option>
        			                    <option value="30/(CC-M-30)">30/(CC-M-30)</option>
        			                    <option value="35/(CC-M-35)">35/(CC-M-35)</option>
        			                    <option value="40/(CC-M-40)">40/(CC-M-40)</option>
        			                    <option value="45/(CC-M-45)">45/(CC-M-45)</option>
        			                    <option value="50/(CC-M-50)">50/(CC-M-50)</option>
        			                 
        			                    <option value="3.0-5.0/CM -1:6">3.0-5.0/CM -1:6</option>
        			                    <option value="5.0-7.5/CM 1:4">5.0-7.5/CM 1:4</option>
        			                    <option value="7.5-10/CM 1:3">7.5-10/CM 1:3</option>
        			                </select>
        			              </td>
        			        </tr>
        			     <tr class="set_3" style="display:none;">
        			            <td>2</td>
        			             <td><input type="text" class="form-control" id="load_3_2" name="load_3_2" onkeyup="load('3_2',3);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_3_2" name="comp_strength_3_2" placeholder="Enter Comp Strength" /></td>
        			        </tr>
        			     <tr class="set_3" style="display:none;">
        			            <td>3</td>
        			             <td><input type="text" class="form-control" id="load_3_3" name="load_3_3"  onkeyup="load('3_3',3);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_3_3" name="comp_strength_3_3" placeholder="Enter Comp Strength" /></td>
        			         </tr>
        			         
        			     <tr class="set_4" style="display:none;">
        			            <td>1</td>
        			            <td rowspan="3">
        			                 <input type="text" class="form-control" id="location_4" name="location_4" /> 
        			                </td>
        			            <td rowspan="3">  <select class="form-control size_of_cube" id="size_of_cube_4" name="size_of_cube_4">
        			                    <option value="22500">22500</option>
        			                    <option value="2500">2500</option>
        			                </select>
        			            </td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_casting" name="date_of_casting_4" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_testing" name="date_of_testing_4"/></td>
        			            <td rowspan="3">  
        			            <select class="form-control" id="age_of_specimen" name="age_of_specimen_4">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 days">After 28 days</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="load_4_1" name="load_4_1"  onkeyup="load('4_1',4);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_4_1" name="comp_strength_4_1" placeholder="Enter Comp Strength" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_4" name="avg_comp_strength_4" value="0" placeholder="Avg Comp Strength" /></td>
        			            <td rowspan="3">  
        			            
        			             <select class="form-control is_code_comp_strength_cc" id="is_code_comp_strength_cc" name="is_code_comp_strength_4" style="display:block">
        			                    <option value="5/(CC 1:5:10)">5/(CC 1:5:10)</option>
        			                    <option value="7.5/(CC 1:4:8)">7.5/(CC 1:4:8)</option>
        			                    <option value="10/(CC 1:3:6)">10/(CC 1:3:6)</option>
        			                    <option value="15/(CC 1:2:4)">15/(CC 1:2:4)</option>
        			                   <option value="20/(CC-1:1.5:3)">20/(CC-1:1.5:3)</option>
                                        <option value="25/(CC-1:1:2)">25/(CC-1:1:2)</option>
        			                      <option value="20/(CC-M-20)">20/(CC-M-20)</option>
        			                    <option value="25/(CC-M-25)">25/(CC-M-25)</option>
        			                    <option value="30/(CC-M-30)">30/(CC-M-30)</option>
        			                    <option value="35/(CC-M-35)">35/(CC-M-35)</option>
        			                    <option value="40/(CC-M-40)">40/(CC-M-40)</option>
        			                    <option value="45/(CC-M-45)">45/(CC-M-45)</option>
        			                    <option value="50/(CC-M-50)">50/(CC-M-50)</option>
        			                 
        			                    <option value="3.0-5.0/CM -1:6">3.0-5.0/CM -1:6</option>
        			                    <option value="5.0-7.5/CM 1:4">5.0-7.5/CM 1:4</option>
        			                    <option value="7.5-10/CM 1:3">7.5-10/CM 1:3</option>
        			                </select>
        			              </td>
        			        </tr>
        			     <tr class="set_4" style="display:none;">
        			            <td>2</td>
        			             <td><input type="text" class="form-control" id="load_4_2" name="load_4_2" onkeyup="load('4_2',4);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_4_2" name="comp_strength_4_2" placeholder="Enter Comp Strength" /></td>
        			        </tr>
        			     <tr class="set_4" style="display:none;">
        			            <td>3</td>
        			             <td><input type="text" class="form-control" id="load_4_3" name="load_4_3" onkeyup="load('4_3',4);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_4_3" name="comp_strength_4_3" placeholder="Enter Comp Strength" /></td>
        			         </tr>    
        			        
        			     <tr class="set_5" style="display:none;">
        			            <td>1</td>
        			            <td rowspan="3">
        			                <input type="text" class="form-control" id="location_5" name="location_5" /> 
        			                </td>
        			            <td rowspan="3">  <select class="form-control size_of_cube" id="size_of_cube_5" name="size_of_cube_5">
        			                    <option value="22500">22500</option>
        			                    <option value="2500">2500</option>
        			                </select>
        			            </td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_casting" name="date_of_casting_5" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="date_of_testing" name="date_of_testing_5"/></td>
        			            <td rowspan="3">  
        			            <select class="form-control" id="age_of_specimen" name="age_of_specimen_5">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 days">After 28 days</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="load_5_1" name="load_5_1" onkeyup="load('5_1',5);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_5_1" name="comp_strength_5_1" placeholder="Enter Comp Strength" /></td>
        			            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_5" name="avg_comp_strength_5" value="0" placeholder="Avg Comp Strength" /></td>
        			            <td rowspan="3">  
        			            
        			            <select class="form-control is_code_comp_strength_cc" id="is_code_comp_strength_5" name="is_code_comp_strength_5" style="display:block">
        			                    <option value="5/(CC 1:5:10)">5/(CC 1:5:10)</option>
        			                    <option value="7.5/(CC 1:4:8)">7.5/(CC 1:4:8)</option>
        			                    <option value="10/(CC 1:3:6)">10/(CC 1:3:6)</option>
        			                    <option value="15/(CC 1:2:4)">15/(CC 1:2:4)</option>
        			                    <option value="20/(CC-1:1.5:3)">20/(CC-1:1.5:3)</option>
                                        <option value="25/(CC-1:1:2)">25/(CC-1:1:2)</option>
        			                      <option value="20/(CC-M-20)">20/(CC-M-20)</option>
        			                    <option value="25/(CC-M-25)">25/(CC-M-25)</option>
        			                    <option value="30/(CC-M-30)">30/(CC-M-30)</option>
        			                    <option value="35/(CC-M-35)">35/(CC-M-35)</option>
        			                    <option value="40/(CC-M-40)">40/(CC-M-40)</option>
        			                    <option value="45/(CC-M-45)">45/(CC-M-45)</option>
        			                    <option value="50/(CC-M-50)">50/(CC-M-50)</option>
        			                 
        			                    <option value="3.0-5.0/CM -1:6">3.0-5.0/CM -1:6</option>
        			                    <option value="5.0-7.5/CM 1:4">5.0-7.5/CM 1:4</option>
        			                    <option value="7.5-10/CM 1:3">7.5-10/CM 1:3</option>
        			                </select>
        			            </td>
        			        </tr>
        			     <tr class="set_5" style="display:none;">
        			            <td>2</td>
        			             <td><input type="text" class="form-control" id="load_5_2" name="load_5_2" onkeyup="load('5_2',5);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_5_2" name="comp_strength_5_2" placeholder="Enter Comp Strength" /></td>
        			        </tr>
        			     <tr class="set_5" style="display:none;">
        			            <td>3</td>
        			             <td><input type="text" class="form-control" id="load_5_3" name="load_5_3" onkeyup="load('5_3',5);" placeholder="Enter Load" /></td>
        			            <td><input type="text" class="form-control" id="comp_strength_5_3" name="comp_strength_5_3" placeholder="Enter Comp Strength" /></td>
        			         </tr>    
        			          <input type="hidden" value="" id="countset" name="countset">
    			        </tbody>
						</table>
			        </div>
			        

			     <div style="clear:both"></div>
	       </div>
                
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" onclick="formsubmit();" class="btn btn-primary formsection" style="display:none;">Create Report</button>
                <button type="button" onclick="uidlink_urlno();" class="btn btn-primary uidsectionbutton">Get Details</button> 
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    function formsubmit()
    {
        $( "#formsubmitn" ).submit();
        
    }
    
    $("#material_details").on('input', function () 
    {
        var val = this.value;
        if(val == 'Cube Sample (01 Set)')
        {
          $('.set_2').css('display','none');    
          
            $('.set_3').css('display','none');
            $('.set_4').css('display','none'); 
             $('.set_5').css('display','none');
           
           $('#countset').val('1');
          
          
        }
        if(val == 'Cube Sample (02 Set)')
        {
          $('.set_2').css('display','');    
          
            $('.set_3').css('display','none');
            $('.set_4').css('display','none'); 
             $('.set_5').css('display','none');
           
          
          $('#countset').val('2'); 
        }
        else if(val == 'Cube Sample (03 Set)')
        {
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
     
            $('.set_4').css('display','none'); 
             $('.set_5').css('display','none');
             
            
            $('#countset').val('3');
           
        }
        else if(val == 'Cube Sample (04 Set)')
        {
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display',''); 
        
             $('.set_5').css('display','none');  
            $('#countset').val('4');
            
        }
        else if(val == 'Cube Sample (05 Set)')
        {
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display',''); 
            $('.set_5').css('display','');  
            $('#countset').val('5');
            
        } 
    }
    );
    function load(id,loop)
    {
        
        var load = $('#load_'+id).val(); 
         
        var size_of_cube = $('#size_of_cube_'+loop).val(); 
      
        data = load*1000/size_of_cube;
        var strength = parseFloat(data).toFixed(2);
        $('#comp_strength_'+id).val(strength); 
        
        var comp1 = $('#comp_strength_'+loop+'_1').val(); 
        var comp2 = $('#comp_strength_'+loop+'_2').val(); 
        var comp3 = $('#comp_strength_'+loop+'_3').val(); 
        
        if(comp2 == ''){
             comp2 = 0;
        }
        if(comp3 == ''){
            comp3 = 0;
        }
        
        var totaladd = Math.abs(comp1)+Math.abs(comp2)+Math.abs(comp3);
        total = totaladd/3;
        var total = parseFloat(total).toFixed(2);
        $('#avg_comp_strength_'+loop).val(total);
        
        
    }
    function uidlink_urlno() 
    {
     var uid_no = $('#uid_no').val(); 
         
         $.ajax({
            url:base_url + 'cubereport/getClientDetails?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                   if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                        '</div>');
            
                            $('.uidsectionbutton').css('display','none');
                            $('.formsection').css('display','block');
                            
                            // $('#ulr_no').val(response.ulr_no);
                            $('#customer_details').val(response.reporting_address);
                            $('#agency_name').val(response.agency_name);
                            $('#source_location').val(response.name_of_work);
                            $('#work_order_no').val(response.work_order_no);
                      } 
                      else 
                      {
            
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                        '</div>'); 
                      }
          
         
                }
        });
        
        $.ajax({
            url:base_url + 'ulrlink/getulrbyuid?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                    $('#ulrdata').html(response); 
                     
                       
                }
                
    });
    }
</script>