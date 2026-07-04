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
          <form role="form" action="<?php base_url('bitumencore/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                      <div class="col-xs-4" >
                          <p>ULR No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="ulr_no" name="ulr_no" placeholder="Enter ULR No." />
        			    </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4" >
                          <p>Select Bitumencore Sample			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <select class="form-control" id="bitumencore_sample" name="bitumencore_sample">
                              <option value="">Select Sample</option>
                              <option value="Bitumencore Sample (01 Set)">Bitumencore Sample (01 Set)</option>
                              <option value="Bitumencore Sample (02 Set)">Bitumencore Sample (02 Set)</option>
                              <option value="Bitumencore Sample (03 Set)">Bitumencore Sample (03 Set)</option>
                              <option value="Bitumencore Sample (04 Set)">Bitumencore Sample (04 Set)</option>
                              <option value="Bitumencore Sample (05 Set)">Bitumencore Sample (05 Set)</option> 
                              <option value="Bitumencore Sample (06 Set)">Bitumencore Sample (06 Set)</option>
                              <option value="Bitumencore Sample (07 Set)">Bitumencore Sample (07 Set)</option>
                              <option value="Bitumencore Sample (08 Set)">Bitumencore Sample (08 Set)</option>
                              <option value="Bitumencore Sample (09 Set)">Bitumencore Sample (09 Set)</option>
                              <option value="Bitumencore Sample (10 Set)">Bitumencore Sample (10 Set)</option>
                          </select>
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
                            <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS</h5>
                       </div>
                    </div>
			        <div class="row formsection" style="display:none;">
                        <div class="col-xs-12 col-sm-12">
                        <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Name of Test</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Thickness</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Sampling</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Method of Test</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Density(%)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Result</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
    			        </tr>
    			        <?php for($j=0;$j<10;$j++){ 
    			        $i = $j+1;
    			        ?>
        			     <tr class="set_<?=$i;?>" style="display:none;">
        			            <td><?=$i;?></td>
        			            <td>
        			                <select class="form-control" id="name_of_test_<?=$i;?>" name="name_of_test_<?=$i;?>">
        			                    <option value="Bitumen Content (BM)">Bitumen Content (BM)</option>
        			                    <option value="Bitumen Content (DBM)">Bitumen Content (DBM)</option>
        			                    <option value="Bitumen Content (BC)">Bitumen Content (BC)</option>
        			                    <option value="Bitumen Content (SDBC)">Bitumen Content (SDBC)</option>
        			                    <option value="Bitumen Content (PMC)">Bitumen Content (PMC)</option>
        			                    <option value="Bitumen Content (PMC + SEAL)">Bitumen Content (PMC + SEAL)</option>
        			                    <option value="Bitumen Content (SEAL)">Bitumen Content (SEAL)</option>
        			                </select>
        			            </td>
                                <td><input type="text" class="form-control" id="thickness_<?=$i;?>" name="thickness_<?=$i;?>" /></td>
                                <td><input type="text" class="form-control" id="date_of_casting_<?=$i;?>" name="date_of_sampling_<?=$i;?>" /></td>
                                <td><input type="text" class="form-control" id="method_of_testing_<?=$i;?>" name="method_of_testing_<?=$i;?>" placeholder="Enter Method of Testing" /></td>
                                <td><input type="text" class="form-control" id="density_<?=$i;?>" name="density_<?=$i;?>" placeholder="Density" /></td>
                                <td><input type="text" class="form-control" id="result_<?=$i;?>" name="result_<?=$i;?>" placeholder="Enter Result" /></td>
        			            <td> %</td>
        			             
        			        </tr>
        			       <? } ?>
        			        <input type="hidden" value="10" id="countset" name="countset">
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
                <a href="<?php echo base_url('bitumencore/') ?>" class="btn btn-warning">Back</a>
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
    $("#bitumencore_sample").on('input', function () 
    {
        var val = this.value;
        if(val == 'Bitumencore Sample (01 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','none');
            $('.set_3').css('display','none'); 
            $('.set_4').css('display','none');
            $('.set_5').css('display','none');    
            $('.set_6').css('display','none');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('1');
        }
        if(val == 'Bitumencore Sample (02 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display','none'); 
            $('.set_4').css('display','none');
            $('.set_5').css('display','none');    
            $('.set_6').css('display','none');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('2');
        }if(val == 'Bitumencore Sample (03 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','none');
            $('.set_5').css('display','none');    
            $('.set_6').css('display','none');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('3');
        }if(val == 'Bitumencore Sample (04 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','none');    
            $('.set_6').css('display','none');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('4');
        }if(val == 'Bitumencore Sample (05 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','none');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('5');
        }if(val == 'Bitumencore Sample (06 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','');
            $('.set_7').css('display','none'); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('6');
        }if(val == 'Bitumencore Sample (07 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','');
            $('.set_7').css('display',''); 
            $('.set_8').css('display','none'); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('7');
        }if(val == 'Bitumencore Sample (08 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','');
            $('.set_7').css('display',''); 
            $('.set_8').css('display',''); 
            $('.set_9').css('display','none'); 
            $('.set_10').css('display','none'); 
           $('#countset').val('8');
        }if(val == 'Bitumencore Sample (09 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','');
            $('.set_7').css('display',''); 
            $('.set_8').css('display',''); 
            $('.set_9').css('display',''); 
            $('.set_10').css('display','none'); 
           $('#countset').val('9');
        }if(val == 'Bitumencore Sample (10 Set)')
        {
            $('.set_1').css('display','');    
            $('.set_2').css('display','');
            $('.set_3').css('display',''); 
            $('.set_4').css('display','');
            $('.set_5').css('display','');    
            $('.set_6').css('display','');
            $('.set_7').css('display',''); 
            $('.set_8').css('display',''); 
            $('.set_9').css('display',''); 
            $('.set_10').css('display',''); 
           $('#countset').val('10');
        }
        
    })
     function uidlink_urlno() 
    {
     var uid_no = $('#uid_no').val(); 
     $.ajax({
            url:base_url + 'bitumencore/getClientDetails?uid_no='+uid_no,
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