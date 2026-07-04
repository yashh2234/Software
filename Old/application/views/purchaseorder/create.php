 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create
      <small>Purchase Order</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Create Purchase Order</li>
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
                <h3 class="box-title">Create Purchase Order</h3>
            </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('purchaseorder/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
              <div class="box-body">

                <?php echo validation_errors(); ?> 
                <div class="row formsection">
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Purchase Order</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="purchase_order" name="purchase_order" placeholder="Enter Purchase Order" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Agency Name</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="agency_name" name="agency_name" placeholder="Enter Agency Name" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Reporting Address</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="reporting_address" name="reporting_address" placeholder="Enter Reporting Address" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Vendor Ref No</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="vendor_ref_no" name="vendor_ref_no" placeholder="Enter Ref No" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Vendor Ref Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="date" class="form-control" id="vendor_ref_date" name="vendor_ref_date" placeholder="Vendor Ref Date" /> 
                       </div>
                    </div> 
                <div class="col-xs-6" style="margin: 5px 0px;">
                        <div class="col-xs-4" >
                          <p>Select Order			
                        </p>
                      </div>
                      <div class="col-xs-8">
                          <select class="form-control" id="order_sample" name="order_sample">
                              <option value="">Select Purchanse Order</option>
                              <option value="01 Set">01 Set</option>
                              <option value="02 Set" selected>02 Set</option>
                              <option value="03 Set">03 Set</option>
                              <option value="04 Set">04 Set</option>
                              <option value="05 Set">05 Set</option> 
                              <option value="06 Set">06 Set</option>
                              <option value="07 Set">07 Set</option>
                              <option value="08 Set">08 Set</option>
                              <option value="09 Set">09 Set</option>
                              <option value="10 Set">10 Set</option>
                              <option value="11 Set">11 Set</option>
                              <option value="12 Set">12 Set</option>
                              <option value="13 Set">13 Set</option>
                              <option value="14 Set">14 Set</option>
                              <option value="15 Set">15 Set</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <table class="table table-striped">
    			        <tbody>
						<tr>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Description</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Rate</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Unit</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Discount %</th>
                            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Amount(INR)</th> 
    			        </tr>
    			        <?php for($j=0;$j<15;$j++){ 
    			            $i = $j+1;
    			        ?>
        			        <tr class="set_<?=$i;?>" style="display:none;">
        			            <td><?=$i;?></td> 
                                <td><input type="text" class="form-control" id="description_<?=$i;?>" name="description_<?=$i;?>" /></td>
                                      <td><input type="text" class="form-control" id="rate_<?=$i;?>" name="rate_<?=$i;?>" /></td>
                                      <td><input type="text" class="form-control" id="unit_<?=$i;?>" name="unit_<?=$i;?>" /></td> 
                                <td><input type="text" class="form-control" id="discount_<?=$i;?>" name="discount_<?=$i;?>" placeholder="Enter Discount" /></td>
                                <td><input type="text" class="form-control" id="amount_<?=$i;?>" name="amount_<?=$i;?>" placeholder="Enter Amount" onkeyup="calculate_amount(<?=$i;?>);"/></td>
                            </tr>
        			       <? } ?>
        			        <input type="hidden" value="15" id="countset" name="countset">
    			        </tbody>
						</table>
						<div style="clear:both"></div>
						
						    <div class="col-xs-6" style="margin: 5px 0px;"></div>
						    <div class="col-xs-6" style="margin: 5px 0px;">  
                              <div class="col-xs-4">
                                  <p>Total Amount</p>
                              </div>
                              <div class="col-xs-8">
                                  <input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="Enter Total Amount" /> 
                               </div>
                            </div>
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Total Discount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="total_discount" name="total_discount" placeholder="Total Discount" onkeyup="calculate_discount();" /> 
                       </div>
                    </div> 
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                     <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Transportation</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="transportation" name="transportation" placeholder="Enter Transportation Amount" onkeyup="calculate_transportation();" /> 
                       </div>
                    </div>
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>GST @ 18%</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="gst_amount" name="gst_amount" placeholder="Total Gst Amount" onkeyup="calculate_gst();" /> 
                       </div>
                    </div> 
                   
                    <div class="col-xs-6" style="margin: 5px 0px;"></div>
                     <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Net Payble Amount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="net_amount" name="net_amount" placeholder="Total Net Amount" /> 
                       </div>
                    </div> 
                     <div class="col-xs-6" style="margin: 5px 0px;"></div>
                    <div class="col-xs-6" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Advance Amount</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="advance_amount" name="advance_amount" placeholder="Total Advance Amount" /> 
                       </div>
                    </div> 
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-2">
                          <p>Reamrk</p>
                      </div>
                      <div class="col-xs-10">
                          <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark" /> 
                       </div>
                    </div> 
			        </div>
			      <div style="clear:both"></div>
	            </div>
                
                </div>
              
               
              <!-- /.box-body -->

              <div class="box-footer">
                 
                 <button type="button" onclick="formsubmit();" class="btn btn-primary formsection">Create Order</button>
                <a href="<?php echo base_url('purchaseorder/') ?>" class="btn btn-warning">Back</a>
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
    $('.set_1').css('display','');    
    $('.set_2').css('display','');
    $("#order_sample").on('input', function () 
    {
        
        var val = this.value; 
        if(val == '01 Set')
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
            $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('1');
        }
        if(val == '02 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('2');
        }if(val == '03 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('3');
        }if(val == '04 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('4');
        }if(val == '05 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('5');
        }if(val == '06 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('6');
        }if(val == '07 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('7');
        }if(val == '08 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('8');
        }if(val == '09 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('9');
        }
        if(val == '10 Set')
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
             $('.set_11').css('display','none');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('10');
        }
        if(val == '11 Set')
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
             $('.set_11').css('display','');
            $('.set_12').css('display','none'); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('11');
        }
        if(val == '12 Set')
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
             $('.set_11').css('display','');
            $('.set_12').css('display',''); 
            $('.set_13').css('display','none'); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('12');
        }
        if(val == '13 Set')
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
             $('.set_11').css('display','');
            $('.set_12').css('display',''); 
            $('.set_13').css('display',''); 
            $('.set_14').css('display','none'); 
            $('.set_15').css('display','none'); 
           $('#countset').val('13');
        }
        if(val == '14 Set')
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
             $('.set_11').css('display','');
            $('.set_12').css('display',''); 
            $('.set_13').css('display',''); 
            $('.set_14').css('display',''); 
            $('.set_15').css('display','none'); 
           $('#countset').val('14');
        }
        if(val == '15 Set')
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
             $('.set_11').css('display','');
            $('.set_12').css('display',''); 
            $('.set_13').css('display',''); 
            $('.set_14').css('display',''); 
            $('.set_15').css('display',''); 
           $('#countset').val('15');
        } 
    }) 
    
    
    function calculate_amount(id)
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
                     
                    var finaltotalA = Math.abs(amount1)+Math.abs(amount2)+Math.abs(amount3)+Math.abs(amount4)+Math.abs(amount5)+Math.abs(amount6)+Math.abs(amount7)+Math.abs(amount8)+Math.abs(amount9)+Math.abs(amount10)+Math.abs(amount11)+Math.abs(amount12)+Math.abs(amount13)+Math.abs(amount14)+Math.abs(amount15);
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