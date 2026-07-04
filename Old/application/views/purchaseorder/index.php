
if($_GET['end_date'] != '')
{
    $end_date = $_GET['end_date']; 
}
else 
{ 
    $end_date =  '';
} 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Purchase Order</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Purchase Order</li>
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

        <?php if(in_array('createBilling', $user_permission)): ?>
          <a href="<?php echo base_url('purchaseorder/create') ?>" class="btn btn-primary">Create Order</a>
        <?php endif; ?>
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Order</h3>
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
                  
                <th>Date</th> 
                <th>Agency Name</th> 
                <th>Address</th>
                <th>Purchase Order No</th>
                <th>Vendor Ref No</th>
                <th>Vendor Ref Date </th>
                <?php if(in_array('updateBilling', $user_permission) || in_array('viewBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
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

<?php if(in_array('deleteBilling', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Purchase Order</h4>
      </div>

      <form role="form" action="<?php echo base_url('purchaseorder/remove') ?>" method="post" id="removeForm">
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

<div class="modal fade" tabindex="-1" role="dialog" id="printModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="text-align: center;font-size: 25px;text-transform: uppercase;">Print Report</h4>
      </div>
        <div class="modal-body">
          <p style="text-align: center;font-size: 20px;text-transform: uppercase;">How many pages of Pdf to Copy ?</p>
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
var manageTable;
var base_url = "<?php echo base_url(); ?>";


  
$(document).ready(function() 
{

  $("#mainOrdersNav").addClass('active');
  $("#manageOrdersNav").addClass('active');
    
    var start_date  = $("#start_date").val();
    var end_date  = $("#end_date").val();
    if(start_date)
    {
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'purchaseorder/fetchPurchaseOrdersFilterData?start_date='+start_date+'&end_date='+end_date, 
        'order': []
        
        });

    }
    else
    {
         // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'purchaseorder/fetchPurchaseOrdersData',
        
        'order': []
        });
        
    }
});
// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { iPurchaseorderId:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

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
    window.location.href = '/purchaseorder/printDiv/'+printid;
}
 
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