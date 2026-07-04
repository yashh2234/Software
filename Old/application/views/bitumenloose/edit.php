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
          <form role="form" action="<?php base_url('bitumenloose/update') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                        <h5 style="padding:8px;background-color:#000 !important;color:#fff !important;text-transform: uppercase;text-align:center;">TEST RESULTS</h5>
                       </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Name of Test</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Sampling</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Method of Test</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Result</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
    			        </tr>
    			            <?php 
                                $rowcount = $order_data['order'][0]['set_count'];
                            ?> 
                            <input type="hidden" value="<?php echo $rowcount;?>" id="countset" name="countset"> 
                            <?php for($j=0;$j<$rowcount;$j++)
                            { 
        			        $i = $j+1;
        			        ?>
                                <tr>
        			            <td><?=$i;?></td>
        			            <td>
        			                <select class="form-control" id="name_of_test_<?=$i;?>" name="name_of_test_<?=$i;?>">
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (BM)'){?>selected<? } ?> value="Bitumen Content (BM)">Bitumen Content (BM)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (DBM)'){?>selected<? } ?> value="Bitumen Content (DBM)">Bitumen Content (DBM)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (BC)'){?>selected<? } ?> value="Bitumen Content (BC)">Bitumen Content (BC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (SDBC)'){?>selected<? } ?> value="Bitumen Content (SDBC)">Bitumen Content (SDBC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (PMC)'){?>selected<? } ?> value="Bitumen Content (PMC)">Bitumen Content (PMC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (PMC + SEAL)'){?>selected<? } ?> value="Bitumen Content (PMC + SEAL)">Bitumen Content (PMC + SEAL)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (SEAL)'){?>selected<? } ?> value="Bitumen Content (SEAL)">Bitumen Content (SEAL)</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="date_of_sampling_<?=$i;?>" value="<?php echo $order_data['order'][$j]['date_of_sampling']; ?>" name="date_of_sampling_<?=$i;?>" /></td>
        			            <td><input type="text" class="form-control" id="method_of_testing_<?=$i;?>" value="<?php echo $order_data['order'][$j]['mathod_of_test']; ?>" name="method_of_testing_<?=$i;?>" placeholder="Enter Method of Testing" /></td>
        			            <td><input type="text" class="form-control" id="result_<?=$i;?>" name="result_<?=$i;?>" value="<?php echo $order_data['order'][$j]['result']; ?>" placeholder="Enter Result" /></td>
        			            <td> %</td>
        			            </tr>
        			            <input type="hidden" value="<?php echo $order_data['order'][$j]['iBitumenlId']; ?>" id="iBitumenlId_<?=$i;?>" name="iBitumenlId_<?=$i;?>"> 
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
                 
                <a href="<?php echo base_url('bitumenloose/') ?>" class="btn btn-default">Back</a>
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
        <?php } ?> <!-- /.box -->
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

      <form role="form" action="<?php echo base_url('bitumenloose/approve') ?>" method="post" id="approveForm">
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

      <form role="form" action="<?php echo base_url('bitumenloose/cancel') ?>" method="post" id="cancelForm">
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
    window.location.href = '/bitumenloose/printDiv/'+printid;
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