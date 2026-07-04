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
        <h4 class="modal-title">Edit DISPATCH</h4>
      </div>

      <form role="form" action="<?php echo base_url('billing/update') ?>" method="post" id="updateBrandForm">

        <div class="modal-body">
          <div id="messages"></div>
<div class="modal-body">
            <div class="row">
                 <div class="col-sm-12">
                      <div class="col-sm-1">
                 <div class="form-group">
                    <label for="vehicle_name">UID No</label>
                    <input type="text" class="form-control" id="edit_uid_no" name="edit_uid_no" placeholder="Enter UID No" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Bill No.</label>
                    <input type="text" class="form-control" id="edit_bill_no" name="edit_bill_no" placeholder="Enter Bill No" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Total Bill Amount</label>
                    <input type="text" class="form-control" id="edit_bill_amount" name="edit_bill_amount" placeholder="Enter Bill Amount" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Advance Amount</label>
                    <input type="text" class="form-control" id="edit_advance_amount" name="edit_advance_amount" placeholder="Enter Advance Amount" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Mode Of Payment</label>
                    <input type="text" class="form-control" id="edit_mode_of_payment" name="edit_mode_of_payment" placeholder="Mode of payment" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Amount Received</label>
                    <input type="text" class="form-control" id="edit_amount_received" name="edit_amount_received" placeholder="Amount Received" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Receive Date</label>
                    <input type="text" class="form-control" id="edit_amount_received_date" name="edit_amount_received_date" placeholder="Amount Received" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Due Amount</label>
                    <input type="text" class="form-control" id="edit_due_amount" name="edit_due_amount" placeholder="Due Amount" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Discount</label>
                    <input type="text" class="form-control" id="edit_discount" name="edit_discount" placeholder="Discount" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Remark</label>
                    <input type="text" class="form-control" id="edit_remark" name="edit_remark" placeholder="Remark" autocomplete="off">
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
    manageTable = $('#manageTable').DataTable
        ({
            'ajax': 'fetchbillingpaymentnotupdateData',
            "pageLength": 50,
            scrollX: true,
            'order': []
        });
   
 
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
    		$("#edit_bill_no").val(response.bill_no);
    		$("#edit_bill_amount").val(response.bill_amount);
    		$("#edit_advance_amount").val(response.advance_amount);
    		$("#edit_amount_received").val(response.amount_received);
    		$("#edit_mode_of_payment").val(response.mode_of_payment);
    		$("#edit_due_amount").val(response.due_amount);
    		$("#edit_amount_received_date").val(response.amount_received_date);
    		$("#edit_discount").val(response.discount);
    		$("#edit_remark").val(response.remark);
    	 
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
</script>
