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


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Reports</h3>
            <h4 style="text-align: center;font-size: 22px;background-color: #ff6600;padding: 10px;color: #fff;opacity: 0.6;z-index: 999999999;width:400px">UID No.- <?php echo $order_data['order'][0]['uid_no'] ?></h4>
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
                          <p>UID No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="uid_no" name="uid_no" value="<?php echo $order_data['order'][0]['uid_no']; ?>" placeholder="Enter UID Number" />
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
                          <p>Source/Location 			
                    
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
                          <input type="date" class="form-control" id="sample_date" value="<?php echo $order_data['order'][0]['sample_date']; ?>" name="sample_date" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="sample_tested_date" value="<?php echo $order_data['order'][0]['sample_tested_date']; ?>" name="sample_tested_date"/>
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
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Name of Test</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Thickness</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Sampling</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Method of Test</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Density(%)</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Result</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
    			        </tr>
    			            <?php 
                                $rowcount = $order_data['order'][0]['set_count'];
                            ?> 
                            
                            <input type="hidden" value="<?php echo $rowcount;?>" id="countset" name="countset"> 
                                
                                <?php for($j=0;$j<6;$j++){ 
    			        $i = $j+1;
    			        ?>
                                <tr>
        			            <td><?=$i;?></td>
        			            <td>
        			                <select class="form-control" id="name_of_test_<?=$j;?>" name="name_of_test_<?=$j;?>">
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (BM)'){?>selected<? } ?> value="Bitumen Content (BM)">Bitumen Content (BM)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (DBM)'){?>selected<? } ?> value="Bitumen Content (DBM)">Bitumen Content (DBM)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (BC)'){?>selected<? } ?> value="Bitumen Content (BC)">Bitumen Content (BC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (SDBC)'){?>selected<? } ?> value="Bitumen Content (SDBC)">Bitumen Content (SDBC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (PMC)'){?>selected<? } ?> value="Bitumen Content (PMC)">Bitumen Content (PMC)</option>
        			                    <option <? if($order_data['order'][$j]['name_of_test'] == 'Bitumen Content (PMC + SEAL)'){?>selected<? } ?> value="Bitumen Content (PMC + SEAL)">Bitumen Content (PMC + SEAL)</option>
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="thickness_<?=$i;?>" value="<?php echo $order_data['order'][$j]['thickness']; ?>" name="thickness_<?=$i;?>" /></td>
        			            <td><input type="date" class="form-control" id="date_of_sampling_<?=$i;?>" value="<?php echo $order_data['order'][$j]['date_of_sampling']; ?>" name="date_of_sampling_<?=$i;?>" /></td>
        			            <td><input type="text" class="form-control" id="method_of_testing_<?=$i;?>" value="<?php echo $order_data['order'][$j]['mathod_of_test']; ?>" name="method_of_testing_<?=$i;?>" placeholder="Enter Method of Testing" /></td>
        			            <td><input type="text" class="form-control" id="density_<?=$i;?>" value="<?php echo $order_data['order'][$j]['density']; ?>" name="density_<?=$i;?>" /></td>
        			            <td><input type="text" class="form-control" id="result_<?=$i;?>" name="result_<?=$i;?>" value="<?php echo $order_data['order'][$j]['result']; ?>" placeholder="Enter Result" /></td>
        			            <td> %</td>
        			            </tr>
        			            <input type="hidden" value="<?php echo $order_data['order'][$j]['iBitumenCId']; ?>" id="iBitumenCId_<?=$i;?>" name="iBitumenCId_<?=$i;?>"> 
        			          <? } ?>
    			        </tbody>
						</table>
			        </div>
                 </div>
			      
                 
                 
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <a target="__blank" onclick="printFunc(<?php echo $order_data['order'][0]['iReportId'];?>)" data-toggle="modal" data-target="#printModal" href="javascript:void(0);" class="btn btn-default" >Print</a>
                
                <a target="__blank" onclick="cancelGr(<?php echo $order_data['order'][0]['iReportId'];?>)" data-toggle="modal" data-target="#cancelgrModal" href="javascript:void(0);" class="btn btn-warning" >Cancel Report</a>
                
                <button type="submit" class="btn btn-primary">Save Changes</button>
                 
                <a href="<?php echo base_url('cubereport/') ?>" class="btn btn-default">Back</a>
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




<div class="modal fade" tabindex="-1" role="dialog" id="cancelgrModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove GR</h4>
      </div>

      <form role="form" action="<?php echo base_url('orders/cancel') ?>" method="post" id="cancelForm">
        <div class="modal-body">
          <p>Do you really want to Cancel GR?</p>
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
          <p style="text-align: center;font-size: 20px;text-transform: uppercase;">How many pages of Pdf to Copy ?</p>
        </div>
        <input type="hidden" id="print_id" name="print_id" value=""> 
        <div class="modal-footer" style="text-align: center;">
          <button type="button" class="btn btn-primary" onclick="copy1();" data-dismiss="modal">
            Copy 1</button>
          <button type="button" class="btn btn-primary" onclick="copy2();" data-dismiss="modal">Copy 2</button>
          <button type="button" class="btn btn-primary" onclick="copy3();" data-dismiss="modal">Copy 3</button>
          <button type="button" class="btn btn-primary" onclick="copy4();" data-dismiss="modal"> All Pages</button> 
        </div> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function(){       //Error happens here, $ is not defined.

    var value = $('#paid_status').val();
     
      
     if(value == 2)
     {
         $('#advance_payment').css('display','block');
         $('#balance_payment').css('display','block');
     }
     else
     {
         $('#advance_payment').css('display','none');
         $('#balance_payment').css('display','none');
     }
     
     
    });
    
    
function cancelGr(id)
{
  if(id) {
    $("#cancelForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { order_id:id }, 
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

function copy1()
{
    var printid = $('#print_id').val();
    window.location.href = 'http://rtrl.platinawebservices.com/orders/printDiv1/'+printid;
    
}
function copy2()
{
    var printid = $('#print_id').val();
    window.location.href = 'http://rtrl.platinawebservices.com/orders/printDiv2/'+printid;
}
function copy3()
{
    var printid = $('#print_id').val();
    window.location.href = 'http://rtrl.platinawebservices.com/orders/printDiv3/'+printid;
}
function copy4()
{
    var printid = $('#print_id').val();
    window.location.href = 'http://rtrl.platinawebservices.com/orders/printDiv/'+printid;
}


function paidstatus()
 {
     var value = $('#paid_status').val();
     
     if(value == 2)
     {
         $('#advance_payment').css('display','block');
         $('#balance_payment').css('display','block');
     }
     else
     {
         $('#advance_payment').css('display','none');
         $('#balance_payment').css('display','none');
     }
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

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#manageOrdersNav").addClass('active');
    
    
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
          url: base_url + '/orders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
            

              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number" name="qty[]" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
              }
              else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();

          }
        });

      return false;
    });

  }); // /document

  function getTotal(row = null) {
    if(row) {
      var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  // get the product information from the server
  function getProductData(row_id)
  {
    var product_id = $("#product_"+row_id).val();    
    if(product_id == "") {
      $("#rate_"+row_id).val("");
      $("#rate_value_"+row_id).val("");

      $("#qty_"+row_id).val("");           

      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");

    } else {
      $.ajax({
        url: base_url + 'orders/getProductValueById',
        type: 'post',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          
          $("#rate_"+row_id).val(response.price);
          $("#rate_value_"+row_id).val(response.price);

          $("#qty_"+row_id).val(1);
          $("#qty_value_"+row_id).val(1);

          var total = Number(response.price) * 1;
          total = total.toFixed(2);
          $("#amount_"+row_id).val(total);
          $("#amount_value_"+row_id).val(total);
          
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }

 function balanceAmount()
 {
     var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
     
     var totalSubAmount = 0;
     totalSubAmount = $("#gross_amount").val();
     
     var advance_payment = $("#advance_payment").val();
     
    
      // service
    /*var service = (Number($("#gross_amount").val())/100) * service_charge;*/
    var service =  service_charge;
    service = service.toFixed(2); 
    
    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(service));
     
     if(advance_payment > totalAmount)
     {  
        alert('Invalid Amount');
        $("#advance_payment").val('');
        $("#balance_payment").val('');
     }
     else
     {
        totalAmount = totalAmount.toFixed(2); 
        var totalAmountNew = totalAmount - advance_payment;
        $("#balance_payment").val(totalAmountNew);
     }
 }
 
  // calculate the total amount of the order
 function subAmount() {
    var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
    var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

     var totalSubAmount = 0;
     
    totalSubAmount = $("#gross_amount").val();

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val())/100) * vat_charge;
    vat = vat.toFixed(2);
    $("#vat_charge").val(vat);
    $("#vat_charge_value").val(vat);

    // service
    /*var service = (Number($("#gross_amount").val())/100) * service_charge;*/
    var service =  service_charge;
    service = service.toFixed(2);
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);
    
    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    if(totalAmount > 50)
    {
    var discount = $("#discount").val();
        
        if(discount) {
          var grandTotal = Number(totalAmount) - Number(discount);
          grandTotal = grandTotal.toFixed(2);
          $("#net_amount").val(grandTotal);
          $("#net_amount_value").val(grandTotal);
        } else {
          $("#net_amount").val(totalAmount);
          $("#net_amount_value").val(totalAmount);
          
        }
    }
    else
    {
        var totalAmount = '';
     $("#net_amount").val(totalAmount);
          $("#net_amount_value").val(totalAmount);   
    }
    
    
    // /else discount 

  } // /sub total amount

  function paidAmount() {
    var grandTotal = $("#net_amount_value").val();

    if(grandTotal) {
      var dueAmount = Number($("#net_amount_value").val()) - Number($("#paid_amount").val());
      dueAmount = dueAmount.toFixed(2);
      $("#remaining").val(dueAmount);
      $("#remaining_value").val(dueAmount);
    } // /if
  } // /paid amoutn function

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
</script>