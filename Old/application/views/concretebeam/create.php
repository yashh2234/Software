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
          <form role="form" action="<?php base_url('concretebeam/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                    			              <input type="text" class="form-control" id="environment_condition" value="As Per the Prescribed test Method" name="environment_condition" placeholder="Enter Environment Condition" />
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
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS (As per IS : 516-1959 Part - IV RA 2018)</h5>
                       </div>
                    </div>
			        <div class="row formsection" style="display:none;">
                      
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
                <td><input type="text" class="form-control" id="size_l_1_1" name="size_l_1_1" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_1_1" name="size_b_1_1" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_1_1" name="size_d_1_1" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_1_1" name="span_length_1_1"  placeholder="Span Length"  Value="600"/></td>
            <td rowspan="3"><input type="text" class="form-control" id="date_of_casting_1_1" name="date_of_casting_1_1" placeholder="Date Of Casting" /></td>
            <td rowspan="3"><input type="text" class="form-control" id="date_of_testing_1_1" name="date_of_testing_1_1" placeholder="Date Of Testing" /></td>
            <td rowspan="3">
                <select class="form-control" id="age_of_specimen_1_1" name="age_of_specimen_1_1">
                    <option value="7 Days">7 Days</option>
                    <option value="28 Days">28 Days</option>
                    <option value="After 28 Days">After 28 days </option> 
                </select>
            </td>
            <td><input type="text" class="form-control" id="fracture_value_1_1" name="fracture_value_1_1"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_1_1" name="observe_load_1_1" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_1_1" name="formula_1_1" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_1_1" name="flexural_strength_1_1" placeholder="Flexural Strength" /></td>
            <td rowspan="3"><input type="text" class="form-control" id="avg_strength_1_1" name="avg_strength_1_1" placeholder="Avg Strength" /></td>
        </tr>
        <tr>
            <td>2</td>
             <td><table><tr>
                <td><input type="text" class="form-control" id="size_l_1_2" name="size_l_1_2" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_1_2" name="size_b_1_2" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_1_2" name="size_d_1_2" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_1_2" name="span_length_1_2"  placeholder="Span Length"  Value="600"/></td>
             
            <td><input type="text" class="form-control" id="fracture_value_1_2" name="fracture_value_1_2"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_1_2" name="observe_load_1_2" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_1_2" name="formula_1_2" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_1_2" name="flexural_strength_1_2" placeholder="Flexural Strength" /></td> 
        </tr>
        <tr>
            <td>3</td>
             <td><table><tr>
                <td><input type="text" class="form-control" id="size_l_1_3" name="size_l_1_3" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_1_3" name="size_b_1_3" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_1_3" name="size_d_1_3" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_1_3" name="span_length_1_3"  placeholder="Span Length"  Value="600"/></td>
             
            <td><input type="text" class="form-control" id="fracture_value_1_3" name="fracture_value_1_3"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_1_3" name="observe_load_1_3" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_1_3" name="formula_1_3" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_1_3" name="flexural_strength_1_3" placeholder="Flexural Strength" /></td> 
        </tr>
        <tr>
            <td Colspan="11">(B) Flexural Strength of CC Beam</td> 
        </tr>
        <tr>
            <td>1</td>  
           <td><table><tr>
                <td><input type="text" class="form-control" id="size_l_2_1" name="size_l_2_1" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_2_1" name="size_b_2_1" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_2_1" name="size_d_2_1" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_2_1" name="span_length_2_1"  placeholder="Span Length"  Value="600"/></td>
            <td rowspan="3"><input type="text" class="form-control" id="date_of_casting_2_1" name="date_of_casting_2_1" placeholder="Date Of Casting" /></td>
            <td rowspan="3"><input type="text" class="form-control" id="date_of_testing_2_1" name="date_of_testing_2_1" placeholder="Date Of Testing" /></td>
            <td rowspan="3">
                <select class="form-control" id="age_of_specimen_2_1" name="age_of_specimen_2_1">
                    <option value="7 Days">7 Days</option>
                    <option value="28 Days">28 Days</option>
                    <option value="After 28 Days">After 28 Days</option> 
                </select>
            </td>
            <td><input type="text" class="form-control" id="fracture_value_2_1" name="fracture_value_2_1"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_2_1" name="observe_load_2_1" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_2_1" name="formula_2_1" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_2_1" name="flexural_strength_2_1" placeholder="Flexural Strength" /></td>
            <td rowspan="3"><input type="text" class="form-control" id="avg_strength_2_1" name="avg_strength_2_1" placeholder="Avg Strength" /></td>
        </tr>
        <tr>
            <td>2</td>
             <td><table><tr>
                <td><input type="text" class="form-control" id="size_l_2_2" name="size_l_2_2" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_2_2" name="size_b_2_2" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_2_2" name="size_d_2_2" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_2_2" name="span_length_2_2"  placeholder="Span Length"  Value="600"/></td>
             
            <td><input type="text" class="form-control" id="fracture_value_2_2" name="fracture_value_2_2"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_2_2" name="observe_load_2_2" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_2_2" name="formula_2_2" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_2_2" name="flexural_strength_2_2" placeholder="Flexural Strength" /></td> 
        </tr>
        <tr>
            <td>3</td>
             <td><table><tr>
                <td><input type="text" class="form-control" id="size_l_2_3" name="size_l_2_3" placeholder="Enter L"  Value="700"/></td>
                <td><input type="text" class="form-control" id="size_b_2_3" name="size_b_2_3" placeholder="Enter B"  Value="150" /></td>
                <td><input type="text" class="form-control" id="size_d_2_3" name="size_d_2_3" placeholder="Enter D"  Value="150" /></td>
            </tr></table></td>
            <td><input type="text" class="form-control" id="span_length_2_3" name="span_length_2_3"  placeholder="Span Length"  Value="600"/></td>
             
            <td><input type="text" class="form-control" id="fracture_value_2_3" name="fracture_value_2_3"  placeholder = "Fracture Value"/></td>
            <td><input type="text" class="form-control" id="observe_load_2_3" name="observe_load_2_3" placeholder="Observe Load" /></td>
            <td><input type="text" class="form-control" id="formula_2_3" name="formula_2_3" placeholder="Formula" /></td>
            <td><input type="text" class="form-control" id="flexural_strength_2_3" name="flexural_strength_2_3" placeholder="Flexural Strength" /></td> 
        </tr> 
        			          <input type="hidden" value="2" id="countset" name="countset">
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
                <a href="<?php echo base_url('concretebeam/') ?>" class="btn btn-warning">Back</a>
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
            url:base_url + 'concretebeam/getClientDetails?uid_no='+uid_no,
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