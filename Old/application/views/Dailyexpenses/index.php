 <style>
    .modal-lg {
      width: 1300px;
    }
    .col-sm-1 {
  width: 12.333%;
}
 </style><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Daily Expenses</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Daily Expenses</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#addBrandModal" class="btn btn-primary">Add Expenses <i class="fa fa-arrow-circle-right"></i></a>
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
            <h3 class="box-title">Manage Daily Expenses</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
               <div class="row">
                  <div class="col-sm-8 col-xs-12 pull pull-right" style="margin-right: -10px;">
                       
                        <div class="col-sm-4 col-xs-10" style="float: left;margin-right: -4px;margin-bottom: 15px;">
                        <label>Expenses Category : </label>
                            <select class="form-control" id="expenses_category_fil" name="expenses_category_fil">
                               <option value="all" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'all'){ echo 'selected'; } ?>>All</option>
<option value="Site Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Site Exp'){ echo 'selected'; } ?>>Site Exp</option>
<option value="Corier and Speed Post" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Corier and Speed Post'){ echo 'selected'; } ?>>Corier and Speed Post</option>
<option value="Convence and Transportation" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Convence and Transportation'){ echo 'selected'; } ?>>Convence and Transportation</option>
<option value="Survey Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Survey Exp'){ echo 'selected'; } ?>>Survey Exp</option>
<option value="DD and tendor Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'DD and tendor Exp'){ echo 'selected'; } ?>>DD and tendor Exp</option>
<option value="Omendra Gupta Current ac" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Omendra Gupta Current ac'){ echo 'selected'; } ?>>Omendra Gupta Current ac</option>
<option value="Office Maintenance" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Office Maintenance'){ echo 'selected'; } ?>>Office Maintenance</option>
<option value="Refreshment" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Refreshment'){ echo 'selected'; } ?>>Refreshment</option>
<option value="stationary" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'stationary'){ echo 'selected'; } ?>>Stationary</option>
<option value="Machine and Car Repairing" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Machine and Car Repairing'){ echo 'selected'; } ?>>Machine and Car Repairing</option>
<option value="Lab Testing Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Lab Testing Exp'){ echo 'selected'; } ?>>Lab Testing Exp</option>
<option value=" Audit Expenses" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Audit Expenses'){ echo 'selected'; } ?>>Audit Expenses</option>
<option value="Telephone/Water/Electricity Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Telephone/Water/Electricity Exp'){ echo 'selected'; } ?>>Telephone/Water/Electricity Exp</option>
<option value="Printor and Computer Repairing exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Printor and Computer Repairing Exp'){ echo 'selected'; } ?>>Printor and Computer Repairing Exp</option>
<option value="Printing Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Printing Exp'){ echo 'selected'; } ?>>Printing Exp</option>
<option value="Cash advance" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Cash advance'){ echo 'selected'; } ?>>Cash Advance </option>
<option value="Salary" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Salary'){ echo 'selected'; } ?>>Salary</option>
<option value="Other Exp" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Other Exp'){ echo 'selected'; } ?>>Other Exp</option>
<option value="Report Payment Received" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Report Payment Received'){ echo 'selected'; } ?>>Report Payment Received</option> 
<option value="Survey Payment Received" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Survey Payment Received'){ echo 'selected'; } ?>>Survey Payment Received</option>
<option value="Other Payment Received" <?php if(isset($_GET['expenses_category_fil']) && $_GET['expenses_category_fil'] == 'Other Payment Received'){ echo 'selected'; } ?>>Other Payment Received</option>
                            </select>                                                                                                         
                        </div>
                        <div class="col-sm-3 col-xs-10" style="float: left;margin-right: -4px;margin-bottom: 15px;">
                        <label>Start Date : </label>
                        <input type="date" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date']; }else{$start_date =  '';} ?>" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-sm-3 col-xs-10" style="float: left;margin-right: -5px;margin-bottom: 15px;">
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
                    <th>Date</th>
                    <th>Opening Balance</th>
                    <th>Total Income</th>
                    <th>Total Expenses</th>
                    <th>Closing Balance</th> 
                    <th>Expenses Category</th> 
                    <th>Expenses Remark</th>
                    <th>Payment Mode</th>
                    <th>Remark</th>
                    <th>Person Name</th> 
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">ADD EXPENSES</h4>
      </div>

      <form role="form" action="<?php echo base_url('dailyexpenses/create') ?>" method="post" id="createBrandForm">

        <div class="modal-body">
            <div class="row"> 
                <div class="col-sm-12">
                     <div id="exist_messages"></div>
                <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="vehicle_name">Date</label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" autocomplete="off">
                </div>
                </div> 
                <div class="col-sm-6"> 
                <div class="form-group">
                    <label for="vehicle_name">Total Income</label>
                    <input type="text" class="form-control" id="total_income" name="total_income" placeholder="Total Income" autocomplete="off">
                </div>
                </div>
                <div class="col-sm-6"> 
                <div class="form-group">
                    <label for="vehicle_name">Total Expenses</label>
                    <input type="text" class="form-control" id="total_expenses" name="total_expenses" placeholder="Total Expenses" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-12">
                    
                <div class="form-group">
                    <label for="vehicle_name">Expenses Category</label>
                    <select class="form-control" id="expenses_category" name="expenses_category">
                        <option value="Site Exp">Site Exp</option>
                        <option value="Corier and Speed Post">Corier andSpeed Post</option>
                        <option value="Convence and Transportation">Convence and Transportation</option>
                        <option value="Survey Exp">Survey Exp</option>
                        <option value="DD and tendor Exp">DD and tendor Exp</option>
                        <option value="Omendra Gupta Current ac">Omendra Gupta Current ac</option>
                        <option value="Office Maintenance">Office Maintenance</option>
                        <option value="Refreshment">Refreshment</option>
                        <option value="stationary">Stationary</option>
                        <option value="Machine and Car Repairing">Machine and Car Repairing</option>
                        <option value="Lab Testing Exp">Lab Testing Exp</option>
                       <option value=" Audit Expenses">Audit Expenses</option>
                        <option value="Telephone/Water/Electricity Exp">Telephone/Water/Electricity Exp</option>
                        <option value="Printor and Computer Repairing exp">Printor and Computer Repairing Exp</option>
                        <option value="Printing Exp">Printing Exp</option>
                        <option value="Cash advance">Cash Advance </option>
                        <option value="Salary">Salary</option>
                        <option value="Other Exp">Other Exp</option>
                         <option value="Report Payment Received">Report Payment Received</option> 
                         <option value="Survey Payment Received">Survey Payment Received</option>
                         <option value="Other Payment Received">Other Payment Received</option>
                    </select>
                </div>
                </div>
                 <div class="col-sm-12">
                    
                <div class="form-group">
                    <label for="vehicle_name">Expenses Remark</label>
                    <input type="text" class="form-control" id="expenses_remark" name="expenses_remark" placeholder="Expenses Remark" autocomplete="off">
                </div>
                </div>
                   
                 <div class="col-sm-6">
                    
                <div class="form-group">
                    <label for="vehicle_name">Payment Mode</label>
                    <select class="form-control" id="payment_mode" name="payment_mode">
                        <option value="">Select Payment Mode</option>
                        <option value="Cash">Cash</option>
                        <option value="Upi">Upi</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Cheque">Cheque</option> 
                    </select>
                   
                </div>
                </div>
                  <div class="col-sm-6">
                    
                <div class="form-group">
                    <label for="vehicle_name">Person Name</label>
                    <input type="text" class="form-control" id="person_name" name="person_name" placeholder="Person Name" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-12">
                    
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

      <form role="form" action="<?php echo base_url('dailyexpenses/update') ?>" method="post" id="updateBrandForm">

        <div class="modal-body">
          <div id="messages"></div>
<div class="modal-body">
            <div class="row">
                 <div class="col-sm-12">
                    <div class="col-sm-1"> 
                <div class="form-group">
                    <label for="vehicle_name">Date</label>
                    <input type="text" class="form-control" id="edit_date" name="edit_date" placeholder="Enter date" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1"> 
                <div class="form-group">
                    <label for="vehicle_name">Opening Balance</label>
                    <input type="text" class="form-control" id="edit_opening_balance" name="edit_opening_balance" placeholder="Enter Opening Balance" autocomplete="off">
                </div>
                </div> 
                <div class="col-sm-1"> 
                <div class="form-group">
                    <label for="vehicle_name">Total Income</label>
                    <input type="text" class="form-control" id="edit_total_income" name="edit_total_income" placeholder="Total Income" onkeyup="calculateincome();"  autocomplete="off">
                </div>
                </div>
                <div class="col-sm-1"> 
                <div class="form-group">
                    <label for="vehicle_name">Total Expenses</label>
                    <input type="text" class="form-control" id="edit_total_expenses" name="edit_total_expenses" placeholder="Total Expenses"  onkeyup="calculateexpensese();" autocomplete="off">
                </div>
                </div>
                 <div class="col-sm-1"> 
                <div class="form-group">
                    <label for="vehicle_name">Closing Balance</label>
                    <input type="text" class="form-control" id="edit_closing_balance" name="edit_closing_balance" placeholder="Enter Closing Balance" autocomplete="off">
                </div>
                </div> 
                 <div class="col-sm-2">
                    
                <div class="form-group">
                    <label for="vehicle_name">Expenses Category</label>
                    <select class="form-control" id="edit_expenses_category" name="edit_expenses_category">
                        <option value="Site Exp">Site Exp</option>
                        <option value="Corier and Speed Post">Corier andSpeed Post</option>
                        <option value="Convence and Transportation">Convence and Transportation</option>
                        <option value="Survey Exp">Survey Exp</option>
                        <option value="DD and tendor Exp">DD and tendor Exp</option>
                        <option value="Omendra Gupta Current ac">Omendra Gupta Current ac</option>
                        <option value="Office Maintenance">Office Maintenance</option>
                        <option value="Refreshment">Refreshment</option>
                        <option value="stationary">Stationary</option>
                        <option value="Machine and Car Repairing">Machine and Car Repairing</option>
                        <option value="Lab Testing Exp">Lab Testing Exp</option>
                       <option value=" Audit Expenses">Audit Expenses</option>
                        <option value="Telephone/Water/Electricity Exp">Telephone/Water/Electricity Exp</option>
                        <option value="Printor and Computer Repairing exp">Printor and Computer Repairing Exp</option>
                        <option value="Printing Exp">Printing Exp</option>
                        <option value="Cash advance">Cash Advance </option>
                        <option value="Salary">Salary</option>
                        <option value="Other Exp">Other Exp</option>
                         <option value="Report Payment Received">Report Payment Received</option> 
                         <option value="Survey Payment Received">Survey Payment Received</option>
                         <option value="Other Payment Received">Other Payment Received</option>
                    </select>
                </div>
                </div>
                 <div class="col-sm-2">
                    
                <div class="form-group">
                    <label for="vehicle_name">Expenses Remark</label>
                    <input type="text" class="form-control" id="edit_expenses_remark" name="edit_expenses_remark" placeholder="Expenses Remark" autocomplete="off">
                </div>
                </div>
                   
                 <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Payment Mode</label>
                    <input type="text" class="form-control" id="edit_payment_mode" name="edit_payment_mode" placeholder="Payment Mode" autocomplete="off">
                </div>
                </div>
                  <div class="col-sm-1">
                    
                <div class="form-group">
                    <label for="vehicle_name">Person Name</label>
                    <input type="text" class="form-control" id="edit_person_name" name="edit_person_name" placeholder="Person Name" autocomplete="off">
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

 
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeDailyExpensive1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Billing</h4>
      </div>

      <form role="form" action="<?php echo base_url('dailyexpenses/remove') ?>" method="post" id="removeBrandForm">
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
 



<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {
     
    $( "#edit_date" ).datepicker();
    
    $("#brandNav").addClass('active');
    // initialize the datatable 
     var start_date  = $("#start_date").val();
    var end_date  = $("#end_date").val();
     var expenses_category_fil  = $("#expenses_category_fil").val();
    
    
    if(start_date)
    {
        
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'dailyexpenses/fetchbillingFilterData?expenses_category_fil='+expenses_category_fil+'&start_date='+start_date+'&end_date='+end_date,
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

  
function editDailyExpensive(id)
{ 
  $.ajax({
    url: 'fetchbillingDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) 
        {
    		$("#edit_date").val(response.date);
    		$("#edit_opening_balance").val(response.opening_balance);
    		$("#edit_total_income").val(response.total_income);
    		$("#edit_total_expenses").val(response.total_expenses);
    		$("#edit_closing_balance").val(response.closing_balance);
    		$("#edit_expenses_category").val(response.expenses_category);
    		$("#edit_expenses_remark").val(response.expenses_remark);
    		$("#edit_payment_mode").val(response.payment_mode);
    		$("#edit_person_name").val(response.person_name);
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

 
function removeDailyExpensive(id)
{
     if(confirm("Are you sure you want to delete this?")){
       
     $("#removeDailyExpensive1").modal('show');
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
            $("#removeDailyExpensive").modal('hide');

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
    else{
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
        var expenses_category_fil  = document.getElementById("expenses_category_fil").value;
         
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
        window.location.href = '?expenses_category_fil='+expenses_category_fil+'&start_date='+start_date+'&end_date='+end_date;
    }
    
    
    
  function calculateincome(){
      var opening_balance = $('#edit_opening_balance').val();
      var total_income = $('#edit_total_income').val();
      
      var totaladd = Math.abs(opening_balance)+Math.abs(total_income);
      
      $('#edit_closing_balance').val(totaladd);
      
  }
    function calculateexpensese(){
      var opening_balance = $('#edit_opening_balance').val();
      var total_expenses = $('#edit_total_expenses').val();
      
      var totaladd = Math.abs(opening_balance) - Math.abs(total_expenses);
      if(totaladd >0){
      $('#edit_closing_balance').val(totaladd);
      }
      else
      {
          $('#edit_closing_balance').val(0);
          $('#edit_total_expenses').val(0);
          alert('Please Enter Valid Amount');
      }
  } 
</script>
