<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Reports</li>
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

  <?php if(!empty($order_data['order'][0]['ulr_no'])){?>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Reports</h3>
            <h4 style="text-align: center;font-size: 22px;background-color: #ff6600;padding: 10px;color: #fff;opacity: 0.6;z-index: 999999999;width:400px">UID No.- <?php echo $order_data['order'][0]['uid_no'] ?></h4>
         <?php if(!empty($order_data['order'][0]['cancel_remark'])){ ?>
                    <h4 style="text-align: center;font-size: 15px;padding: 10px;color: red;">Cancel Remark : <?php echo $order_data['order'][0]['cancel_remark']; ?></h4>
                <?php } ?>
                </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('concretebeam/update') ?>" method="post" class="form-horizontal" id="formsubmitn">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="date" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d, h:i a') ?></label>
                </div>
               
<div class="row">
    
    
    <div class="row">
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>ULR No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="ulr_no" name="ulr_no" value="<?php echo $order_data['order'][0]['ulr_no']; ?>" placeholder="Enter ULR Number" />
                       </div>
                    </div>
                     <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name & Address of Costumer</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="customer_details" value="<?php echo $order_data['order'][0]['customer_details']; ?>" name="customer_details" placeholder="Enter Customer Name & Address" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name of Agency</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="agency_name" value="<?php echo $order_data['order'][0]['agency_name']; ?>"name="agency_name" placeholder="Enter Agency Name" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Reference No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="reference_no" value="<?php echo $order_data['order'][0]['reference_no']; ?>" name="reference_no" placeholder="Enter Reference Number" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4" >
                          <p>Material Identification Details			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="material_details" value="<?php echo $order_data['order'][0]['material_details']; ?>" name="material_details" placeholder="Enter Material Details" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name Of Work 			
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="source_location" value="<?php echo $order_data['order'][0]['source_location']; ?>" name="source_location" placeholder="Enter Location" />
                       </div>
                    </div>			  
                    
                     		  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Work order No.			
                    
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="work_order_no" value="<?php echo $order_data['order'][0]['work_order_no']; ?>" name="work_order_no" placeholder="Enter Work Order No" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Receipt</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_date" value="<?php echo $order_data['order'][0]['sample_date']; ?>" name="sample_date" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_tested_date" value="<?php echo $order_data['order'][0]['sample_tested_date']; ?>" name="sample_tested_date"/>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Sampled by /Condition of Sample </p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sampled_by" value="<?php echo $order_data['order'][0]['sampled_by']; ?>" name="sampled_by" placeholder="Enter Sampled By Name" />
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                    			          <div class="col-xs-4">
                    			              <p>Environment Condition			
                    			
                    
                    			
                    .</p>
                    			          </div>
                    			          <div class="col-xs-8">
                    			              <input type="text" class="form-control" value="<?php echo $order_data['order'][0]['environment_condition']; ?>" id="environment_condition" name="environment_condition" placeholder="Enter Environment Condition" />
                    			           </div>
                    			     </div>	<div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Dispatch Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="dispatch_date" name="dispatch_date" value="<?php echo $order_data['order'][0]['dispatch_date']; ?>"/>
                       </div>
                    </div>			
			      </div>
			    
			       <div class="row">
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="padding:8px;background-color:#000 !important;color:#fff !important;text-transform: uppercase;text-align:center;">TEST RESULTS (As per IS : 516-1959 Reaf 2018)</h5>
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S.N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Size Of Specimen
                                <table class="table table-striped"><tr>
                                    <td style="border:1px solid #000;color:#000;text-transform: uppercase;">L(mm)</td>
                                    <td style="border:1px solid #000;color:#000;text-transform: uppercase;">B(mm)</td>
                                    <td style="border:1px solid #000;color:#000;text-transform: uppercase;">D(mm)</td>
                                </tr></table>
                            </th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Span Length</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date Of Casting</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date Of Testing</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Age Of Specimen</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Positation Of Fracture Value(a)</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Observe Load In(p)</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Formula Fb=</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Flexural Strength</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Avg Flexural Strength</th>
    			        </tr>
    			        <tr>
                            <td Colspan="11">(A) Flexural Strength of CC Beam</td> 
                        </tr>
                        <tr>
                            <td>1</td>  
                            <td><table><tr>
                                <td><input type="text" class="form-control" value="<?php echo $order_data['order'][0]['size_l']; ?>" id="size_l_1_1" name="size_l_1_1" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['size_b']; ?>"  id="size_b_1_1" name="size_b_1_1" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['size_d']; ?>" id="size_d_1_1" name="size_d_1_1" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][0]['span_length']; ?>"  id="span_length_1_1" name="span_length_1_1"  placeholder="Span Length"  Value="600"/></td>
                            <td rowspan="3"><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['date_of_casting']; ?>" id="date_of_casting_1_1" name="date_of_casting_1_1" placeholder="Date Of Casting" /></td>
                            <td rowspan="3"><input type="text" class="form-control" value="<?php echo $order_data['order'][0]['date_of_testing']; ?>"  id="date_of_testing_1_1" name="date_of_testing_1_1" placeholder="Date Of Testing" /></td>
                            <td rowspan="3">
                                <select class="form-control" id="age_of_specimen_1_1" name="age_of_specimen_1_1">
                                    <option value="7 Days" <?php if($order_data['order'][0]['age_of_specimen'] == '7 Days'){?> selected <? } ?>>7 Days</option>
                                    <option value="28 Days" <?php if($order_data['order'][0]['age_of_specimen'] == '28 Days'){?> selected <? } ?>>28 Days</option>
                                    <option value="After 28 Days" <?php if($order_data['order'][0]['age_of_specimen'] == 'After 28 Days'){?> selected <? } ?>>After 28 days</option> 
                                </select>
                            </td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['fracture_value']; ?>" id="fracture_value_1_1" name="fracture_value_1_1"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['observe_load']; ?>" id="observe_load_1_1" name="observe_load_1_1" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['formula']; ?>" id="formula_1_1" name="formula_1_1" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['flexural_strength']; ?>" id="flexural_strength_1_1" name="flexural_strength_1_1" placeholder="Flexural Strength" /></td>
                            <td rowspan="3"><input type="text" class="form-control"  value="<?php echo $order_data['order'][0]['avg_flexural_strength']; ?>" id="avg_strength_1_1" name="avg_strength_1_1" placeholder="Avg Strength" /></td>
                        </tr>
                        <tr>
                            <td>2</td>
                             <td><table><tr>
                                <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['size_l']; ?>"  id="size_l_1_2" name="size_l_1_2" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['size_b']; ?>"  id="size_b_1_2" name="size_b_1_2" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['size_d']; ?>"  id="size_d_1_2" name="size_d_1_2" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['span_length']; ?>"  id="span_length_1_2" name="span_length_1_2"  placeholder="Span Length"  Value="600"/></td>
                             
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['fracture_value']; ?>"  id="fracture_value_1_2" name="fracture_value_1_2"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['observe_load']; ?>"  id="observe_load_1_2" name="observe_load_1_2" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][1]['formula']; ?>"  id="formula_1_2" name="formula_1_2" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][1]['flexural_strength']; ?>" id="flexural_strength_1_2" name="flexural_strength_1_2" placeholder="Flexural Strength" /></td> 
                        </tr>
                        <tr>
                            <td>3</td>
                             <td><table><tr>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['size_l']; ?>" id="size_l_1_3" name="size_l_1_3" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['size_b']; ?>" id="size_b_1_3" name="size_b_1_3" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['size_d']; ?>" id="size_d_1_3" name="size_d_1_3" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['span_length']; ?>" id="span_length_1_3" name="span_length_1_3"  placeholder="Span Length"  Value="600"/></td>
                             
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['fracture_value']; ?>" id="fracture_value_1_3" name="fracture_value_1_3"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][2]['observe_load']; ?>"  id="observe_load_1_3" name="observe_load_1_3" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['formula']; ?>" id="formula_1_3" name="formula_1_3" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][2]['flexural_strength']; ?>" id="flexural_strength_1_3" name="flexural_strength_1_3" placeholder="Flexural Strength" /></td> 
                        </tr>
                        <tr>
                            <td Colspan="11">(B) Flexural Strength of CC Beam</td> 
                        </tr>
                        <tr>
                            <td>1</td>  
                           <td><table><tr>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['size_l']; ?>" id="size_l_2_1" name="size_l_2_1" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['size_b']; ?>" id="size_b_2_1" name="size_b_2_1" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['size_d']; ?>" id="size_d_2_1" name="size_d_2_1" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][3]['span_length']; ?>"  id="span_length_2_1" name="span_length_2_1"  placeholder="Span Length"  Value="600"/></td>
                            <td rowspan="3"><input type="text" value="<?php echo $order_data['order'][3]['date_of_casting']; ?>"  class="form-control" id="date_of_casting_2_1" name="date_of_casting_2_1" placeholder="Date Of Casting" /></td>
                            <td rowspan="3"><input type="text"  value="<?php echo $order_data['order'][3]['date_of_testing']; ?>" class="form-control" id="date_of_testing_2_1" name="date_of_testing_2_1" placeholder="Date Of Testing" /></td>
                            <td rowspan="3">
                                <select class="form-control" id="age_of_specimen_2_1" name="age_of_specimen_2_1">
                                   <option value="7 Days" <?php if($order_data['order'][3]['age_of_specimen'] == '7 Days'){?> selected <? } ?>>7 Days</option>
                                    <option value="28 Days" <?php if($order_data['order'][3]['age_of_specimen'] == '28 Days'){?> selected <? } ?>>28 Days</option>
                                    <option value="After 28 Days" <?php if($order_data['order'][3]['age_of_specimen'] == 'After 28 Days'){?> selected <? } ?>>After 28 Days</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['fracture_value']; ?>" id="fracture_value_2_1" name="fracture_value_2_1"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['observe_load']; ?>" id="observe_load_2_1" name="observe_load_2_1" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][3]['formula']; ?>"  id="formula_2_1" name="formula_2_1" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][3]['flexural_strength']; ?>" id="flexural_strength_2_1" name="flexural_strength_2_1" placeholder="Flexural Strength" /></td>
                            <td rowspan="3"><input type="text" class="form-control" value="<?php echo $order_data['order'][3]['avg_flexural_strength']; ?>"  id="avg_strength_2_1" name="avg_strength_2_1" placeholder="Avg Strength" /></td>
                        </tr>
                        <tr>
                            <td>2</td>
                             <td><table><tr>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['size_l']; ?>" id="size_l_2_2" name="size_l_2_2" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['size_b']; ?>" id="size_b_2_2" name="size_b_2_2" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['size_d']; ?>" id="size_d_2_2" name="size_d_2_2" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['span_length']; ?>" id="span_length_2_2" name="span_length_2_2"  placeholder="Span Length"  Value="600"/></td>
                             
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['fracture_value']; ?>" id="fracture_value_2_2" name="fracture_value_2_2"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['observe_load']; ?>" id="observe_load_2_2" name="observe_load_2_2" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['formula']; ?>" id="formula_2_2" name="formula_2_2" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][4]['flexural_strength']; ?>" id="flexural_strength_2_2" name="flexural_strength_2_2" placeholder="Flexural Strength" /></td> 
                        </tr>
                        <tr>
                            <td>3</td>
                             <td><table><tr>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['size_l']; ?>" id="size_l_2_3" name="size_l_2_3" placeholder="Enter L"  Value="700"/></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['size_b']; ?>" id="size_b_2_3" name="size_b_2_3" placeholder="Enter B"  Value="150" /></td>
                                <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['size_d']; ?>" id="size_d_2_3" name="size_d_2_3" placeholder="Enter D"  Value="150" /></td>
                            </tr></table></td>
                            <td><input type="text" class="form-control" value="<?php echo $order_data['order'][5]['span_length']; ?>"  id="span_length_2_3" name="span_length_2_3"  placeholder="Span Length"  Value="600"/></td>
                             
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['fracture_value']; ?>" id="fracture_value_2_3" name="fracture_value_2_3"  placeholder = "Fracture Value"/></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['observe_load']; ?>" id="observe_load_2_3" name="observe_load_2_3" placeholder="Observe Load" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['formula']; ?>" id="formula_2_3" name="formula_2_3" placeholder="Formula" /></td>
                            <td><input type="text" class="form-control"  value="<?php echo $order_data['order'][5]['flexural_strength']; ?>" id="flexural_strength_2_3" name="flexural_strength_2_3" placeholder="Flexural Strength" /></td> 
                        </tr> 
        			          <input type="hidden" value="2" id="countset" name="countset">
                                <input type="hidden" class="form-control" id="iBeamId_1_1" name="iBeamId_1_1" value="<?php echo $order_data['order'][0]['iBeamId']; ?>"/> 
                                <input type="hidden" class="form-control" id="iBeamId_1_2" name="iBeamId_1_2" value="<?php echo $order_data['order'][1]['iBeamId']; ?>"/> 
                                <input type="hidden" class="form-control" id="iBeamId_1_3" name="iBeamId_1_3" value="<?php echo $order_data['order'][2]['iBeamId']; ?>"/> 
                                <input type="hidden" class="form-control" id="iBeamId_2_2" name="iBeamId_2_1" value="<?php echo $order_data['order'][3]['iBeamId']; ?>"/> 
                                <input type="hidden" class="form-control" id="iBeamId_2_2" name="iBeamId_2_2" value="<?php echo $order_data['order'][4]['iBeamId']; ?>"/> 
                                <input type="hidden" class="form-control" id="iBeamId_2_3" name="iBeamId_2_3" value="<?php echo $order_data['order'][5]['iBeamId']; ?>"/> 
        
    			        </tbody>
						</table>
			        </div>
                 </div>
			      
                 
                 
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <a target="__blank" onclick="printFunc(<?php echo $order_data['order'][0]['iReportId'];?>)" data-toggle="modal" data-target="#printModal" href="javascript:void(0);" class="btn btn-default" >Print</a>
                 <? if($this->session->userdata('id') == 1){?>
                <a target="__blank" onclick="approveGr(<?php echo $order_data['order'][0]['iReportId'];?>)" data-toggle="modal" data-target="#approveModal" href="javascript:void(0);" class="btn btn-success" >Approved Report</a>
                <a target="__blank" onclick="cancelGr(<?php echo $order_data['order'][0]['iReportId'];?>)" data-toggle="modal" data-target="#cancelgrModal" href="javascript:void(0);" class="btn btn-warning" >Cancel Report</a>
                <? } ?>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                 
                <a href="<?php echo base_url('concretebeam/') ?>" class="btn btn-default">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <? } else {?>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">No Reports Data Found !</h3>
            </div>
        </div>
        <?php } ?><!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<div class="modal fade" tabindex="-1" role="dialog" id="approveModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Approved Report</h4>
      </div>

      <form role="form" action="<?php echo base_url('concretebeam/approve') ?>" method="post" id="approveForm">
        <div class="modal-body">
          <p>Do you really want to Approved Report?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="cancelgrModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cancel Report</h4>
      </div>

      <form role="form" action="<?php echo base_url('concretebeam/cancel') ?>" method="post" id="cancelForm">
        <div class="modal-body">
          <p>Do you really want to Cancel Report?</p>
        </div>
        <div class="row">
            <div class="col-xs-12" style="margin: 5px 0px;">
              <div class="col-xs-12">
                  <p>Remark & Correction</p>
              </div>
              <div class="col-xs-12">
                  <input type="text" style="height: 75px;" class="form-control" id="cancel_remark" value="" Placeholder="Enter Remark & Correction" name="cancel_remark" />
               </div>
            </div>	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="printModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="text-align: center;font-size: 25px;text-transform: uppercase;">Print GR</h4>
      </div>
        <div class="modal-body">
          <p style="text-align: center;font-size: 20px;text-transform: uppercase;">Are You Sure You Want to Copy ?</p>
        </div>
        <input type="hidden" id="print_id" name="print_id" value=""> 
        <div class="modal-footer" style="text-align: center;">
          <button type="button" class="btn btn-primary" onclick="copy();" data-dismiss="modal">
            Copy</button>
        </div> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

 
  function approveGr(id)
{
  if(id) {
    $("#approveForm").on('submit', function() {

      var form = $(this);
 
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { iReportId:id }, 
        dataType: 'json',
        success:function(response) {
 
          if(response.success == true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#approveModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


function cancelGr(id)
{
  if(id) {
    $("#cancelForm").on('submit', function() {

        var form = $(this);
        var cancel_remark = $('#cancel_remark').val();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { iReportId:id,cancel_remark:cancel_remark}, 
        dataType: 'json',
        success:function(response) {
 
          if(response.success == true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#cancelgrModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}

  
    
function printFunc(id)
{
    $('#print_id').val(id);
}

function copy()
{
    var printid = $('#print_id').val();
    window.location.href = '/concretebeam/printDiv/'+printid;
}
 
// function printOrder(id)
// {
//   if(id) {
//     $.ajax({
//       url: base_url + 'orders/printDiv/' + id,
//       type: 'post',
//       success:function(response) {
//         var mywindow = window.open('', 'new div', 'height=400,width=600');
//         // mywindow.document.write('<html><head><title></title>');
//         // mywindow.document.write('<link rel="stylesheet" href="<?php //echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" />');
//         // mywindow.document.write('</head><body >');
//         mywindow.document.write(response);
//         // mywindow.document.write('</body></html>');

//         mywindow.print();
//         mywindow.close();

//         return true;
//       }
//     });
//   }
// }

 
</script>