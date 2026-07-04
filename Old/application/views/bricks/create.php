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
          <form role="form" action="<?php base_url('bricks/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">Test Results (As per-IS 3495 ( Parts 1 to 4 ) : 1992 RA 2016)								
</h5>
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
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Limit</th>
    			        </tr>
    			        <tr>
    			            <td rowspan="4" style="vertical-align: middle;">1</td>
    			            <td>Dimension & Tolerance</td>
    			            <td rowspan="4" style="vertical-align: middle;">IS 1077:1992 RA 2016</td>	
                        	<td rowspan="2" style="vertical-align: bottom;"><input type="text" class="form-control" id="length" name="length" value="" Placeholder="Length"/></td>
                        	<td rowspan="2" style="vertical-align: bottom;">mm</td>
                        	<td rowspan="2" style="vertical-align: bottom;">4600±80</td>
	
	

                        </tr>
                         <tr>
    			             
    			            <td>(i) Length</td> 
                        </tr>
                         <tr>
    			             
    			            <td>(ii) Width</td>
    			            <td><input type="text" class="form-control" id="width" name="width" value="" Placeholder = 'Width' /></td>
    			            <td>mm</td>
    			            <td>2200±40</td>
                        </tr>
                         <tr>
    			            
    			            <td>(iii) Height</td>
    			            <td><input type="text" class="form-control" id="height" name="height" value="" placeholder="Height" /></td>
    			            <td>mm</td>
    			            <td>1400±40</td>
                        </tr>
        			      <tr>
    			            <td>2</td>
    			            <td>Water Absorption</td>
                            <td>IS 3495 part-2 : 1992 RA 2016</td>
                            <td><input type="text" class="form-control" id="water_absorption" name="water_absorption" placeholder="Water Absorption"/></td>
                            <td>%</td>
                            <td>20 Max.</td>
    			       </tr> 
    			          <tr>
    			            <td>3</td>
    			            <td>Efflorescence</td>
                            <td>IS 3495 part-3 : 1992 RA 2016	</td>
                            <td><input type="text" class="form-control" id="efflorescence" name="efflorescence" placeholder="Efflorescence"/></td>
                            <td>-</td>
                            <td>Moderate Max.</td>
    			       </tr> 
    			           <tr>
    			            <td>4</td>
    			            <td>Compressive strength </td>
                            <td>IS 3495 part-1 : 1992 RA 2016</td>
                            <td><input type="text" class="form-control" id="compressive_strength" name="compressive_strength" placeholder="Compressive Strength"/></td>
                            <td>N/mm2</td>
                            <td><input type="text" class="form-control" id="compressive_strength_limit" name="compressive_strength_limit" placeholder="Limit" /></td>
    			       </tr> 
    			        <tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">ID Mark</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Length (mm)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Width (mm)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Load (kN)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Compressive strength(N/mm2)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Avg. Compressive strength	
							    in N/mm2</th>	

    			        </tr>
    			        <?php for($i=0;$i<5;$i++){ ?>
    			          <tr>
    			             <?
    			             $j = $i+1;
    			             if($i == 0)
        			            {
        			           ?>
    			            <td rowspan="5" style="border:1px solid #000;color:#000;text-transform: uppercase;"></td>
    			            <? } ?>
    			            <td style="border:1px solid #000;color:#000;text-transform: uppercase;"><input type="text" class="form-control" id="length_<?=$j;?>" name="length_<?=$j;?>" placeholder="Length" /></td>
    			            <td style="border:1px solid #000;color:#000;text-transform: uppercase;"><input type="text" class="form-control" id="width_<?=$j;?>" name="width_<?=$j;?>" value="Width" /></td>
                            <td style="border:1px solid #000;color:#000;text-transform: uppercase;"><input type="text" class="form-control" id="load_<?=$j;?>" name="load_<?=$j;?>" placeholder="Load"/></td>
                            <td style="border:1px solid #000;color:#000;text-transform: uppercase;"><input type="text" class="form-control" id="compressive_strength_<?=$j;?>" name="compressive_strength_<?=$j;?>" placeholder="Compressive Strength"/></td>
                             <?
    			             if($i == 0)
        			            {
        			             ?>
        			              <td rowspan="5" style="border:1px solid #000;color:#000;text-transform: uppercase;"><input type="text" class="form-control" id="avg_compressive_strength" name="avg_compressive_strength" placeholder="Avg Compressive Strength" /></td>
    			             
    			            <? } ?>
                            
                        </tr> 
    			        <?php } ?>
        			        <input type="hidden" value="5" id="countset" name="countset">
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
                <a href="<?php echo base_url('bricks/') ?>" class="btn btn-warning">Back</a>
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
            url:base_url + 'bricks/getClientDetails?uid_no='+uid_no,
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