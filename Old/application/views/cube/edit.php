<style>
@media (min-width: 768px)
{
        .col-sm-2 {
  width: 14.25% !important;
}
}
    </style>
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
          <form role="form" action="<?php base_url('cubereport/update') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">S. N</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Location</th>
							 <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Size of cubes mm2</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Date of Casting</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Date of Testing</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Age of Specimen</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Load  (KN)</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Comp. Strength  (N/mm2)</th>
    			            <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">Avg. comp. strength (N/mm2)</th>
    			             <th style="background-color:#000 !important;color:#fff !important;text-transform: uppercase;">As per IS Code  comp. strength (N/mm2)</th>
    			        </tr>
    			       
    			   
    			       <?php 
                           
                           if(empty($order_data['order'][0]['set_count'])){
                               $rowcount =  1;
                           }
                           else
                           {
                               $rowcount = $order_data['order'][0]['set_count'];
                           }
                            
                            for($i=0;$i<$rowcount;$i++){
                                $j = $i+1;
                            ?> 
                              <input type="hidden" value="<?php echo $rowcount;?>" id="countset" name="countset">
                              
                               <input type="hidden" value="<?php echo $order_data['order'][$i]['iCubeId']; ?>" id="iCubeId" name="iCubeId_<?=$j;?>">
                            <tr>
                            <td>1</td>
                            <td rowspan="3"><input type="text" class="form-control"  value="<?php echo $order_data['order'][$i]['location'] ?>" id="location" name="location_<?=$j;?>" placeholder="Enter Location" /></td>
                            <td rowspan="3">  <input type="text" class="form-control"  value="<?php echo $order_data['order'][$i]['size_of_cube'] ?>" id="size_of_cube_<?=$j;?>" name="size_of_cube_<?=$j;?>" placeholder="Enter Size Of Cube" /></td>
                            <td rowspan="3">  <input type="text" class="form-control"  value="<?php echo $order_data['order'][$i]['date_of_casting'] ?>" id="date_of_casting_<?=$j;?>" name="date_of_casting_<?=$j;?>" /></td>
                            <td rowspan="3">  <input type="text" class="form-control"  value="<?php echo $order_data['order'][$i]['date_of_testing']?>" id="date_of_testing_<?=$j;?>" name="date_of_testing_<?=$j;?>"/></td>
                            <td rowspan="3">    <select class="form-control" id="age_of_specimen_<?=$i;?>" name="age_of_specimen_<?=$j;?>">
        			                    <option value="7 Days" <? if($order_data['order'][$i]['age_of_specimen'] == '7 Days'){?>selected<? } ?>>7 Days</option>
        			                    <option value="28 Days" <? if($order_data['order'][$i]['age_of_specimen'] == '28 Days'){?>selected<? } ?>>28 Days</option>
        			                    <option value="After 28 Days" <? if($order_data['order'][$i]['age_of_specimen'] == 'After 28 Days'){?>selected<? } ?>>After 28 days</option> 
        			                </select>
        			            </td>
                            
                            <td><input type="text" class="form-control" id="load_<?=$j;?>_1" name="load_<?=$j;?>_1"  onkeyup="load('<?=$j;?>_1',<?=$j;?>);" value="<?php echo $order_data['order'][$i]['load_1'] ?>" placeholder="Enter Load" /></td>
                            <td><input type="text" class="form-control" id="comp_strength_<?=$j;?>_1" value="<?php echo $order_data['order'][$i]['comp_strength_1'] ?>" name="comp_strength_<?=$j;?>_1" placeholder="Enter Comp Strength" /></td>
                            <td rowspan="3">  <input type="text" class="form-control" id="avg_comp_strength_<?=$j;?>" name="avg_comp_strength_<?=$j;?>" value="<?php echo $order_data['order'][$i]['avg_comp_strength'] ?>" placeholder="Avg Comp Strength" /></td>
                            <td rowspan="3">  <input type="text" class="form-control" id="is_code_comp_strength" name="is_code_comp_strength_<?=$j;?>" value="<?php echo $order_data['order'][$i]['is_code_comp_strength'] ?>" placeholder="Enter IS Code Strength" /></td>
                            </tr>
                            <tr>
                            <td>2</td>
                             <td><input type="text" class="form-control" id="load_<?=$j;?>_2" name="load_<?=$j;?>_2" onkeyup="load('<?=$j;?>_2',<?=$j;?>);" value="<?php echo $order_data['order'][$i]['load_2'] ?>" placeholder="Enter Load" /></td>
                            <td><input type="text" class="form-control" id="comp_strength_<?=$j;?>_2" value="<?php echo $order_data['order'][$i]['comp_strength_2'] ?>" name="comp_strength_<?=$j;?>_2" placeholder="Enter Comp Strength" /></td>
                            </tr>
                            <tr>
                            <td>3</td>
                             <td><input type="text" class="form-control" id="load_<?=$j;?>_3" name="load_<?=$j;?>_3" onkeyup="load('<?=$j;?>_3',<?=$j;?>);" value="<?php echo $order_data['order'][$i]['load_3'] ?>" placeholder="Enter Load" /></td>
                            <td><input type="text" class="form-control" id="comp_strength_<?=$j;?>_3" value="<?php echo $order_data['order'][$i]['comp_strength_3'] ?>" name="comp_strength_<?=$j;?>_3" placeholder="Enter Comp Strength" /></td>
                            </tr>
                            <? } ?>
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
                 
                <a href="<?php echo base_url('cubereport/') ?>" class="btn btn-default">Back</a>
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
        <?php } ?>
        <!-- /.box -->
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

      <form role="form" action="<?php echo base_url('cubereport/approve') ?>" method="post" id="approveForm">
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

      <form role="form" action="<?php echo base_url('cubereport/cancel') ?>" method="post" id="cancelForm">
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
    window.location.href = '/cubereport/printDiv/'+printid;
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
    
</script>