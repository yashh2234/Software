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
                

                <div class="row">
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
                          <input type="date" class="form-control" id="sample_date" name="sample_date" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="sample_tested_date" name="sample_tested_date"/>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Sampled by /Condition of Sample </p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sampled_by" name="sampled_by" placeholder="Enter Sampled By Name" />
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                    			          <div class="col-xs-4">
                    			              <p>Environment Condition			
                    			
                    
                    			
                    .</p>
                    			          </div>
                    			          <div class="col-xs-8">
                    			              <input type="text" class="form-control" id="environment_condition" name="environment_condition" placeholder="Enter Environment Condition" />
                    			           </div>
                    			     </div>				
			      </div>
			    
			       <div class="row">
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS (As per IS : 516-1959 Reaf 2018)</h5>
                       </div>
                    </div>
			        <div class="row">
                      
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
    			        <?php for($j=0;$j<6;$j++){ 
    			        $i = $j+1;
    			        ?>
        			     <tr>
        			            <td>1</td>
        			            <td>
        			                <select class="form-control" id="name_of_test_<?=$i;?>" name="name_of_test_<?=$i;?>">
        			                    <option value="Bitumen Content (BM)">Bitumen Content (BM)</option>
        			                    <option value="Bitumen Content (DBM)">Bitumen Content (DBM)</option>
        			                    <option value="Bitumen Content (BC)">Bitumen Content (BC)</option>
        			                    <option value="Bitumen Content (SDBC)">Bitumen Content (SDBC)</option>
        			                    <option value="Bitumen Content (PMC)">Bitumen Content (PMC)</option>
        			                    <option value="Bitumen Content (PMC + SEAL)">Bitumen Content (PMC + SEAL)</option>
        			                </select>
        			            </td>
                                <td><input type="date" class="form-control" id="thickness_<?=$i;?>" name="thickness_<?=$i;?>" /></td>
                                <td><input type="date" class="form-control" id="date_of_casting_<?=$i;?>" name="date_of_sampling_<?=$i;?>" /></td>
                                <td><input type="text" class="form-control" id="method_of_testing_<?=$i;?>" name="method_of_testing_<?=$i;?>" placeholder="Enter Method of Testing" /></td>
                                <td><input type="text" class="form-control" id="density_<?=$i;?>" name="density_<?=$i;?>" placeholder="Density" /></td>
                                <td><input type="text" class="form-control" id="result_<?=$i;?>" name="result_<?=$i;?>" placeholder="Enter Result" /></td>
        			            <td> %</td>
        			             
        			        </tr>
        			       <? } ?>
        			        <input type="hidden" value="6" id="countset" name="countset">
    			        </tbody>
						</table>
			        </div>
			        

			     <div style="clear:both"></div>
	       </div>
                
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 
                <button type="button" onclick="formsubmit();" class="btn btn-primary">Create Report</button>
                <a href="<?php echo base_url('cubereport/') ?>" class="btn btn-warning">Back</a>
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
     
     $("#uid_no").on('input', function () 
    {
    var val = this.value;
    if($('#brow option').filter(function(){
        return this.value.toUpperCase() === val.toUpperCase();        
    }).length) 
    {
        //send ajax request
     var uid_no = this.value;
     $.ajax({
            url:base_url + 'bitumenloose/getClientDetails?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
            success:function(response) 
                {
                    var customer_name = response.customer_name;
                    var address = response.reporting_address;
                    var client_details = customer_name+' , '+address;
                    
                    $('#customer_details').val(client_details);
                    $('#agency_name').val(response.agency_name);
                }
        });
    }
    });
    
</script>