
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
      <small>ALL Due Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">ALL Due Report</li>
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
            <h3 class="box-title">Manage Due Report</h3>
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
    				<th>Agency_name</th>
    		        <th>Reporting Address</th>
    				<th>Mobile No.</th> 
    			    <th>Name Of Work</th>
    			    <th>Sample Details</th>
    			    	<th>Total Payment</th> 
    				<th>Advance Payment </th>
    				<th>Payment Dues</th>
    			
                    <th>Scan Copy</th> 
                    <th>Report Copy</th> 
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
 <?php if(in_array('deleteOrder', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Report</h4>
      </div>

      <form role="form" action="<?php echo base_url('finallabreports/remove') ?>" method="post" id="removeForm">
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


  
$(document).ready(function() 
{ 
    var start_date  = $("#start_date").val();
    var end_date  = $("#end_date").val();
    if(start_date)
    {
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'duereports/fetchOrdersFilterData?start_date='+start_date+'&end_date='+end_date,
        scrollX: true,
        'order': []
        
        });

    }
    else
    {
         // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'duereports/fetchOrdersData',
        scrollX: true,
        'order': []
        });
        
    }
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
        data: { iReportId:id }, 
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
     
</script>