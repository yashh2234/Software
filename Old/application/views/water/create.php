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
          <form role="form" action="<?php base_url('water/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                          <input type="text" class="form-control" id="material_details" placeholder = "Material Identification Details" name="material_details" value="">
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
                    			     </div>	
                    			     <div class="col-xs-12" style="margin: 5px 0px;">
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
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">The Below Sample Confrim as per IS Specification 456-2000 {Clause:5:4} </h5>
                       </div>
                    </div>
			        <div class="row formsection" style="display:none;">
                      
<div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Name of Test</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Method Of Test</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Result</th> 
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Specification</th>
    			        </tr>
    			         <tr>
    			            <td>1</td>
    			            <td><input type="text" class="form-control" id="name_of_test_1" name="name_of_test_1" value="ph" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_1" name="method_of_testing_1" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_1" name="result_1" placeholder="Results" /></td>
                            <td><input type="text" class="form-control" id="unit_1" name="unit_1" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_1" name="specification_1" placeholder="Specification" /></td>
    			       </tr>
        			      <tr>
    			            <td>2</td>
    			            <td><input type="text" class="form-control" id="name_of_test_2" name="name_of_test_2" value="Chloride" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_2" name="method_of_testing_2" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_2" name="result_2" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_2" name="unit_2" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_2" name="specification_2" placeholder="Specification" /></td>
    			       </tr> 
    			          <tr>
    			            <td>3</td>
    			            <td><input type="text" class="form-control" id="name_of_test_3" name="name_of_test_3" value="Sulphate" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_3" name="method_of_testing_3" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_3" name="result_3" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_3" name="unit_3" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_3" name="specification_3" placeholder="Specification" /></td>
    			       </tr> 
    			           <tr>
    			            <td>4</td>
    			            <td><input type="text" class="form-control" id="name_of_test_4" name="name_of_test_4" value="Organic Matter" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_4" name="method_of_testing_4" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_4" name="result_4" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_4" name="unit_4" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_4" name="specification_4" placeholder="Specification" /></td>
    			       </tr> 
    			          <tr>
    			            <td>5</td>
    			            <td><input type="text" class="form-control" id="name_of_test_5" name="name_of_test_5" value="Inorganic Matter" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_5" name="method_of_testing_5" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_5" name="result_5" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_5" name="unit_5" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_5" name="specification_5" placeholder="Specification" /></td>
    			       </tr> 
    			          <tr>
    			            <td>6</td>
    			            <td><input type="text" class="form-control" id="name_of_test_6" name="name_of_test_6" value="Total Suspended Solid" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_6" name="method_of_testing_6" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_6" name="result_6" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_6" name="unit_6" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_6" name="specification_6" placeholder="Specification" /></td>
    			       </tr> 
    			          <tr>
    			            <td>7</td>
    			            <td><input type="text" class="form-control" id="name_of_test_7" name="name_of_test_7" value="Acidity" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_7" name="method_of_testing_7" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_7" name="result_7" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_7" name="unit_7" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_7" name="specification_7" placeholder="Specification" /></td>
    			       </tr> 
    			          <tr>
    			            <td>8</td>
    			            <td><input type="text" class="form-control" id="name_of_test_8" name="name_of_test_8" value="Alkalinity" /></td>
                            <td><input type="text" class="form-control" id="method_of_testing_8" name="method_of_testing_8" placeholder="Enter Method of Testing"/></td>
                            <td><input type="text" class="form-control" id="result_8" name="result_8" placeholder="Results"/></td>
                            <td><input type="text" class="form-control" id="unit_8" name="unit_8" placeholder="Unit" /></td>
                            <td><input type="text" class="form-control" id="specification_8" name="specification_8" placeholder="Specification" /></td>
    			       </tr> 
        			        <input type="hidden" value="8" id="countset" name="countset">
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
                <a href="<?php echo base_url('water/') ?>" class="btn btn-warning">Back</a>
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
    
     function uidlink_urlno() 
    {
     var uid_no = $('#uid_no').val(); 
     $.ajax({
            url:base_url + 'water/getClientDetails?uid_no='+uid_no,
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
                            
                             //$('#ulr_no').val(response.ulr_no);
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