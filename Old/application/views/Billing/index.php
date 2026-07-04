<style>
@media (min-width: 768px)
{
    .modal-lg 
    {
        width: 1340px !important;
    }
    label
    {
        height:40px;
    }
    .form-control {
        font-size: 11px;
    }
    .col-sm-1
    {
        padding-right:3px;
        padding-left:3px;
        width: 9.88% !important;

    }
}

</style><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Billing</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Billing</li>
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
            <h3 class="box-title">Manage Billing</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
               <div class="row">
                  <div class="col-sm-6 col-xs-12 pull pull-right" style="margin-right: -10px;">
                        <div class="col-sm-5 col-xs-10" style="float: left;margin-right: -4px;margin-bottom: 15px;">
                        <label>Start Date : </label>
                        <input type="date" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date']; }else{$start_date =  '';} ?>" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-sm-5 col-xs-10" style="float: left;margin-right: -5px;margin-bottom: 15px;">
                        <label>End Date : </label>
                        <input type="date" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date']; }else{$end_date =  '';} ?>" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="col-xs-2" style="margin-top: 23px;">
                        <button class="btn btn-primary" onclick="datefilter();">GO</button>  
                        </div>
                    </div>
                </div>  
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>UID NO.</th> 
                    <th>Date</th>
                    <th>Customer Details</th>
                    <th>Mobile No</th>
                    <th>Total Bill Amount</th>
                    <th>Advance Amount</th> 
                    <th>Balance Amount</th> 
                    <th>Payment Followup</th>
                    <th>Remark</th>
                    <th>sample_details</th>
                    <th>qty</th>
                    <?php if(in_array('updateBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
                    <th>Action</th>
                    <?php endif; ?>
                </tr>
              </thead>

            </table>
          </div>
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

<?php if(in_array('createBilling', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addBrandModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add DISPATCH Details</h4>
      </div>

      <form role="form" action="<?php echo base_url('billing/create') ?>" method="post" id="createBrandForm">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                     <div id="exist_messages"></div>
                <div class="col-sm-1">
                    <div class="form-group">
                    <label for="vehicle_name">UID No</label>
                    <input type="text" class="form-control" id="uid_no" name="uid_no" placeholder="Enter UID No" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Bill No.</label>
                    <input type="text" class="form-control" id="bill_no" name="bill_no" placeholder="Enter Bill No" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Total Bill Amount</label>
                    <input type="text" class="form-control" id="bill_amount" name="bill_amount" placeholder="Enter Bill Amount" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Advance Amount</label>
                    <input type="text" class="form-control" id="advance_amount" name="advance_amount" placeholder="Enter Advance Amount" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Mode Of Payment</label>
                    <input type="text" class="form-control" id="mode_of_payment" name="mode_of_payment" placeholder="Mode of payment" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Amount Received</label>
                    <input type="text" class="form-control" id="amount_received" name="amount_received" placeholder="Amount Received" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Receive Date</label>
                    <input type="date" class="form-control" id="amount_received_date" name="amount_received_date" placeholder="Amount Received" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Due Amount</label>
                    <input type="text" class="form-control" id="due_amount" name="due_amount" placeholder="Due Amount" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Discount</label>
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Remark</label>
                    <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark" autocomplete="off">
                </div>
                </div>
    			  
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
<?php endif; ?>

<?php if(in_array('updateBilling', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editBrandModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Billing</h4>
      </div>

      <form role="form" action="<?php echo base_url('billing/update') ?>" method="post" id="updateBrandForm">

        <div class="modal-body">
          <div id="messages"></div>
<div class="modal-body">
            <div class="row">
                 <div class="col-sm-12">
                      <div class="col-sm-2">
                 <div class="form-group">
                    <label for="vehicle_name">UID No</label>
                    <input type="text" class="form-control" id="edit_uid_no" name="edit_uid_no" placeholder="Enter UID No" autocomplete="off">
                </div>
                </div> 
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Total Bill Amount</label>
                    <input type="text" class="form-control" id="edit_total_payment" name="edit_total_payment" placeholder="Enter Bill Amount" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Advance Amount</label>
                    <input type="text" class="form-control" id="edit_advance_payment" name="edit_advance_payment" placeholder="Enter Advance Amount" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Balance Amount</label>
                    <input type="text" class="form-control" id="edit_balance_dues" name="edit_balance_dues" placeholder="Enter Balance Amount" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Payment Followup</label>
                    <input type="text" class="form-control" id="edit_payment_followup" name="edit_payment_followup" placeholder="Payment Followup" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-2">
                    
                <div class="form-group">
                    <label for="vehicle_name">Financial Remark</label>
                    <input type="text" class="form-control" id="edit_financial_remark" name="edit_financial_remark" placeholder="Financial Remark" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-2">
                    
                <div class="form-group">
                    <label for="vehicle_name">Mode_of_payment</label>
                     <select class="form-control" id="edit_mode_of_payment" name="edit_mode_of_payment">
                        <option value="">Select Mode of payment</option>
                        <option  value="upi">UPI</option>
                        <option value="cash">Cash</option>
                        <option value="online banking">Online Banking</option>
                        <option value="cheque">Cheque</option>
                        </select>
                </div>
                </div> 
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
<?php endif; ?>

<?php if(in_array('deleteBilling', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeBrandModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Billing</h4>
      </div>

      <form role="form" action="<?php echo base_url('billing/remove') ?>" method="post" id="removeBrandForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {
     
    $( "#edit_amount_received_date" ).datepicker();
    
    $("#brandNav").addClass('active');
    // initialize the datatable 
     var start_date  = $("#start_date").val();
    var end_date  = $("#end_date").val();
    
    
    
    if(start_date)
    {
        
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'billing/fetchbillingFilterData?start_date='+start_date+'&end_date='+end_date,
        scrollX: true,
        'order': []
        
        });

    }
    else
    {
        manageTable = $('#manageTable').DataTable
            ({
                'ajax': 'fetchbillingData',
                "pageLength": 50,
                scrollX: true,
                'order': []
            });
    }
 
  // submit the create from 
  $("#createBrandForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

     var balance = $("#balance").val();
     var remark = $("#remark").val();
     if(balance == 'nil' && remark == '')
     {
         alert('Please add remark');
         return false;
     }

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTable.ajax.reload(null, false); 

        if(response.success === true) 
        {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addBrandModal").modal('hide');

          // reset the form
          $("#createBrandForm")[0].reset();
          $("#createBrandForm .form-group").removeClass('has-error').removeClass('has-success');

        } 
        else if(response.exist === true)
        {
          
          $("#exist_messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
            
        } 
        else 
        {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
              id.after(value);

            });
          } 
          else 
          {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 
    
    return false;
  }); 

});

  
function editBilling(id)
{ 
  $.ajax({
    url: 'fetchbillingDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) 
        {
            
          
            //var date_time = formatDate(Date('d M Y',response.date_time));
            //var pod = formatDate(Date('d M Y',response.pod));
            //var balance_paid = formatDate(Date('d M Y',response.balance_paid)); 
              
               
            $("#edit_uid_no").val(response.uid_no);
    		$("#edit_total_payment").val(response.total_payment);
    		$("#edit_balance_dues").val(response.balance_dues);
    		$("#edit_advance_payment").val(response.advance_payment);
    		$("#edit_payment_followup").val(response.payment_followup);
    		$("#edit_financial_remark").val(response.financial_remark);
    		$("#edit_mode_of_payment").val(response.mode_of_payment);
    	 
    	 
      // submit the edit from 
      $("#updateBrandForm").unbind('submit').bind('submit', function() {
        var form = $(this);
 
     
// remove the text-danger
        $(".text-danger").remove();
        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editBrandModal").modal('hide');
              // reset the form 
              $("#updateBrandForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 
       
        return false;
      });
          
    }
  });
}

 
function removeBilling(id)
{
    if(id) { 
      $(".text-danger").remove();

      $.ajax({
         url: 'remove/',
        type: 'post',
        data: { id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeBrandModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    
  }
}
$(document).ready(function() {
  $('#manageTable')
        .on( 'order.dt',  function () {
            
            setTimeout(function () {
                $(".yellow").parent().parent().css("background-color","yellow") 
                $(".red").parent().parent().css({"background-color": "red", "color": "#fff"})
                $(".green").parent().parent().css({"background-color": "green", "color": "#fff"})
                },1000);
                        
            
        } )
        .on( 'search.dt', function () {
            
            setTimeout(function () {
    $(".yellow").parent().parent().css("background-color","yellow")  
    $(".red").parent().parent().css({"background-color": "red", "color": "#fff"})  
    $(".green").parent().parent().css({"background-color": "green", "color": "#fff"})
    },1000);
    
            
        } )
        .on( 'page.dt',   function () { 
           setTimeout(function () {
             $(".yellow").parent().parent().css("background-color","yellow")
             $(".red").parent().parent().css({"background-color": "red", "color": "#fff"})
             $(".green").parent().parent().css({"background-color": "green", "color": "#fff"})
            },1000);
        } ) 
} );


$(window).on('load', function(){
    
    setTimeout(function () {
    $(".yellow").parent().parent().css("background-color","yellow")
    $(".red").parent().parent().css({"background-color": "red", "color": "#fff"})
    $(".green").parent().parent().css({"background-color": "green", "color": "#fff"})
    },1000);
});
 
function datefilter()
    {
        var start_date  = document.getElementById("start_date").value;
        var end_date  = document.getElementById("end_date").value;
        
        if(start_date == '')
        {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>Please Enter Start Date</div>'); 
              return false;
        }
        if(end_date == '')
        {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>Please Enter End Date</div>'); 
              return false;
        }
        window.location.href = '?start_date='+start_date+'&end_date='+end_date;
    }
    
</script>
