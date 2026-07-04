 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Update
      <small>Purchase Order</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Update Purchase Order</li>
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
                <h3 class="box-title">Update Purchase Order</h3>
            </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('purchaseorder/update') ?>" method="post" class="form-horizontal" id="formsubmitn">
              <div class="box-body">

                <?php echo validation_errors(); ?> 
                <div class="row formsection">
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="date" name="date" value="<?php echo $order_data['order'][0]['date']; ?>" placeholder="Enter Date" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Purchase Order</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="purchase_order" value="<?php echo $order_data['order'][0]['purchase_order']; ?>" name="purchase_order" placeholder="Enter Purchase Order" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Agency Name</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="agency_name" value="<?php echo $order_data['order'][0]['agency_name']; ?>" name="agency_name" placeholder="Enter Agency Name" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Reporting Address</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="reporting_address" value="<?php echo $order_data['order'][0]['reporting_address']; ?>" name="reporting_address" placeholder="Enter Reporting Address" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Vendor Ref No</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="vendor_ref_no" value="<?php echo $order_data['order'][0]['vendor_ref_no']; ?>" name="vendor_ref_no" placeholder="Enter Ref No" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Vendor Ref Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="vendor_ref_date" value="<?php echo $order_data['order'][0]['vendor_ref_date']; ?>" name="vendor_ref_date" placeholder="Vendor Ref Date" /> 
                       </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12">
                        <table class="table table-striped table-bordered">
    			        <tbody>
						<tr>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Description</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Rate</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Discount %</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Amount(INR)</th> 
    			        </tr>
    			            <?php 
                                $rowcount = $order_data['order'][0]['set_count'];
                            ?> 
                            
                            <input type="hidden" value="<?php echo $rowcount;?>" id="countset" name="countset"> 
                            <?php for($j=0;$j<$rowcount;$j++){ 
    			                $i = $j+1;
    			             ?>
    			           
    			             <input type="hidden" value="<?php echo $order_data['order'][$j]['iPlid']; ?>" id="iPlid_<?=$i;?>" name="iPlid_<?=$i;?>"> 
        			        <tr>
        			            <td><?=$i;?></td> 
                                <td><input type="text" class="form-control" id="description_<?=$i;?>" name="description_<?=$i;?>" value="<?php echo $order_data['order'][$j]['description']; ?>"></td>
                                <td><input type="text" class="form-control" id="rate_<?=$i;?>" name="rate_<?=$i;?>" value="<?php echo $order_data['order'][$j]['rate']; ?>" /></td>
                                <td><input type="text" class="form-control" id="unit_<?=$i;?>" name="unit_<?=$i;?>" value="<?php echo $order_data['order'][$j]['unit']; ?>" /></td>
                                <td><input type="text" class="form-control" id="discount_<?=$i;?>" name="discount_<?=$i;?>" placeholder="Enter Discount"  value="<?php echo $order_data['order'][$j]['discount']; ?>"/></td>
                                <td><input type="text" class="form-control" id="amount_<?=$i;?>" name="amount_<?=$i;?>" placeholder="Enter Amount"  value="<?php echo $order_data['order'][$j]['amount']; ?>" onkeyup="calculate_amount(<?=$i;?>,<?=$rowcount;?>);"/></td>
                            </tr>
        			       <? } ?> 
    			        </tbody>
						</table>
					 </div>
					  <div class="col-xs-6" style="margin: 5px 0px;"></div>
						    <div class="col-xs-6" style="margin: 5px 0px;">  
                              <div class="col-xs-4">
                                  <p>Total Amount</p>
                              </div>
                              <div class="col-xs-8">
                                  <input type="text" class="form-control" id="total_amount" value="<?php echo $order_data['order'][0]['total_amount']; ?>" name="total_amount" placeholder="Enter Total Amount" /> 
                               </div>
                            </div>
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Total Discount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="total_discount" value="<?php echo $order_data['order'][0]['total_discount']; ?>" name="total_discount" placeholder="Total Discount" onkeyup="calculate_discount();" /> 
                       </div>
                    </div> 
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                     <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Transportation</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="transportation" value="<?php echo $order_data['order'][0]['transportation']; ?>" name="transportation" placeholder="Enter Transportation Amount" onkeyup="calculate_transportation();" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>GST @ 18%</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="gst_amount" value="<?php echo $order_data['order'][0]['gst_amount']; ?>" name="gst_amount" placeholder="Total Gst Amount" onkeyup="calculate_gst();" /> 
                       </div>
                    </div> 
                   
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                     <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Net Payble Amount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="net_amount" value="<?php echo $order_data['order'][0]['net_amount']; ?>" name="net_amount" placeholder="Total Net Amount" /> 
                       </div>
                    </div> 
                     <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Advance Amount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="advance_amount" value="<?php echo $order_data['order'][0]['advance_amount']; ?>" name="advance_amount" placeholder="Total Advance Amount" /> 
                       </div>
                    </div> 
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-2">
                          <p>Reamrk</p>
                      </div>
                      <div class="col-xs-10">
                          <input type="text" class="form-control" id="remark" value="<?php echo $order_data['order'][0]['remark']; ?>" name="remark" placeholder="Remark" /> 
                       </div>
                    </div> 
			        </div>
			      <div style="clear:both"></div>
	            </div>
                
                </div> 
              <!-- /.box-body -->
 <div class="box-footer">
            <a target="__blank" onclick="printFunc(<?php echo $order_data['order'][0]['iPurchaseorderId'];?>)" data-toggle="modal" data-target="#printModal" href="javascript:void(0);" class="btn btn-default" >Print</a>
               <button type="submit" class="btn btn-primary">Save Changes</button>
                 
                <a href="<?php echo base_url('bitumencore/') ?>" class="btn btn-default">Back</a>
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
<div class="modal fade" tabindex="-1" role="dialog" id="printModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="text-align: center;font-size: 25px;text-transform: uppercase;">Print PO</h4>
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


<script>
        
function printFunc(id)
{
    $('#print_id').val(id);
}
function copy()
{
    var printid = $('#print_id').val();
    window.location.href = '/purchaseorder/printDiv/'+printid;
}

 function calculate_amount(id,total)
    {
        var total_amount = $('#total_amount').val();
         var amount1 = $('#amount_1').val();
        var amount2 = $('#amount_2').val();
        var amount3 = $('#amount_3').val();
        var amount4 = $('#amount_4').val();
        var amount5 = $('#amount_5').val();
        var amount6 = $('#amount_6').val();
        var amount7 = $('#amount_7').val();
        var amount8 = $('#amount_8').val();
        var amount9 = $('#amount_9').val();
        var amount10 = $('#amount_10').val();
        var amount11 = $('#amount_11').val();
        var amount12 = $('#amount_12').val();
        var amount13 = $('#amount_13').val();
        var amount14 = $('#amount_14').val();
        var amount15 = $('#amount_15').val();
     
        if(total == 1)
        {
           var finaltotalA = Math.abs(amount1);
                    
        }
         if(total == 2)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2);
                    
        }
         if(total == 3)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3);
                    
        }
         if(total == 4)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4);
                    
        }
         if(total == 5)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5);
                    
        }
         if(total == 6)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6);
                    
        }
         if(total == 7)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7);
                    
        }
         if(total == 8)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8);
                    
        }
         if(total == 9)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9);
                    
        } if(total == 10)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10);
                    
        }
         if(total == 11)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11);
                    
        }
         if(total == 12)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11)+Math.abs(amount12);
                    
        }
         if(total == 13)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11)+Math.abs(amount12)+Math.abs(amount13);
                    
        }
         if(total == 14)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11)+Math.abs(amount12)+Math.abs(amount13)+Math.abs(amount14);
                    
        }
         if(total == 15)
        {
           var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11)+Math.abs(amount12)+Math.abs(amount13)+Math.abs(amount14)+Math.abs(amount15);
                    
        }
       
        
                    $('#total_amount').val(finaltotalA);
                    
                var gst = 18*finaltotalA/100; 
                var gst_amount = parseFloat(gst).toFixed(2);
                $('#gst_amount').val(gst_amount); 
       
                var netamt = Math.abs(finaltotalA) + Math.abs(gst_amount);
                $('#net_amount').val(netamt);
            
    } 
    
    function calculate_discount()
    {
         var total_amount = $('#total_amount').val();
         var total_discount = $('#total_discount').val();
         
         var new_total = Math.abs(total_amount) - Math.abs(total_discount);
         
         var gst = 18*new_total/100; 
                var gst_amount = parseFloat(gst).toFixed(2);
                $('#gst_amount').val(gst_amount); 
       
                var netamt = Math.abs(new_total) + Math.abs(gst_amount);
                $('#net_amount').val(netamt);
         
    }
     function calculate_transportation()
    {
         var total_amount = $('#total_amount').val();
         var transportation = $('#transportation').val();
         var total_discount = $('#total_discount').val();
         var new_total = Math.abs(total_amount) + Math.abs(transportation) -  Math.abs(total_discount);
         
         var gst = 18*new_total/100; 
                var gst_amount = parseFloat(gst).toFixed(2);
                $('#gst_amount').val(gst_amount); 
       
                var netamt = Math.abs(new_total) + Math.abs(gst_amount);
                $('#net_amount').val(netamt);
         
    }
     function calculate_gst()
    {
         var total_amount = $('#total_amount').val();
         var transportation = $('#transportation').val();
         var total_discount = $('#total_discount').val();
         var gst_amount = $('#gst_amount').val();
         
         var new_total = Math.abs(total_amount) + Math.abs(transportation) -  Math.abs(total_discount);
         
        /* var gst = 18*new_total/100; 
                var gst_amount = parseFloat(gst).toFixed(2);
                $('#gst_amount').val(gst_amount); 
       */
                var netamt = Math.abs(new_total) + Math.abs(gst_amount);
                $('#net_amount').val(netamt);
         
    }
</script>