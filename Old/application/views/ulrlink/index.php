
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
      <small>ULR NO </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">ULR NO</li>
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
            <h3 class="box-title">Add ULR No</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <form role="form" action="<?php base_url('Ulrlink/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
            <table id="manageTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>UID NO</th>
                        <th>ULR NO</th> 
                        <th>Name of Department</th>
                        <th>Name of Agency</th>
                        <th>Name of Work</th> 
                        <th>Sample Details</th>
                        <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                          <th>Action</th>
                        <?php endif; ?>  
                    </tr>
                </thead> 
                <thead>
                    <tr>
                        <input type="hidden" id="dateselect" name="dateselect" value="<?php if(isset($_GET['date'])){ echo $_GET['date']; }else{ echo date('m/d/Y');} ?>">
                        <td><input type="text" value="" id="date" name="date" class="form-control" onchange ="changeDate();"></td>
                        <td><input type="text" id="uid_no" name="uid_no" class="form-control" onkeyup ="getuiddetails();"><p style="color:red;fonr-size:10px;">UId Format-Namo/MC/2023/00001</p></td>
                        <td id="ulrbox"></td> 
                        <td><input type="text" id="reporting_address" name="reporting_address" class="form-control"></td>
                        <td><input type="text" id="agency_name" name="agency_name" class="form-control"></td>
                        <td><input type="text" id="name_of_work" name="name_of_work" class="form-control"></td>
                        <td><input type="text" id="sample_details" name="sample_details" class="form-control"></td>
                        <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                        <td><button type="button" onclick="formsubmit();" class="btn btn-primary">Link</button></td>
                        <?php endif; ?>  
                    </tr>
                </thead> 
            </table>
            </form>
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

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";
   $( "#date" ).datepicker();
$(document).ready(function() 
{
    
    var dateselect  = $("#dateselect").val();
    
    if(dateselect)
    {
         $.ajax({
            url:base_url + 'Ulrlink/fetchUlrotherDatadatewise?date='+dateselect,
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                    $('#ulrbox').html(response);
                    var dateselect = $('#dateselect').val();
                    $('#date').val(dateselect);
                }
                
        }); 
    }
    else
    {
        
        $.ajax({
            url:base_url + 'Ulrlink/fetchUlrDatadatewise',
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                    $('#ulrbox').html(response);
                    var dateselect = $('#dateselect').val();
                 $('#date').val(dateselect);
                }
                
        });
    }   
});
   function changeDate() {
    var date  = document.getElementById("date").value;
        
        if(date == '')
        {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>Please Enter Date</div>'); 
              return false;
        }
        window.location.href = '?date='+date;
        
}
function getuiddetails()
{
    var uid_no = $('#uid_no').val();
     $.ajax({
            url:base_url + 'Ulrlink/getClientDetails?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
            success:function(response) 
            {
                if(response.success === true) 
                {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
                     
                    $('#reporting_address').val(response.reporting_address);
                    $('#agency_name').val(response.agency_name);
                    $('#name_of_work').val(response.name_of_work);
                    $('#sample_details').val(response.sample_details);
                } 
                else 
                {
    
                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                    '</div>'); 
                    $('#reporting_address').val('');
                    $('#agency_name').val('');
                    $('#name_of_work').val('');
                    $('#sample_details').val('');
                }
            }
        });
}
     function newUlrAdd() 
     { 
        var ulr =  $('#ulr_no').val();
        
         if(ulr == 'new')
         {
            $('#newulr_no').css('display','block'); 
             
         }
         else
         {
             $('#newulr_no').css('display','none'); 
         }
     }
     function formsubmit()
     {
            var ulr_no = $('#ulr_no').val();
            var uid_no = $('#uid_no').val();
            var date = $('#date').val();
            var agency_name = $('#agency_name').val();
            var reporting_address = $('#reporting_address').val();
            var agency_name = $('#agency_name').val();
            var name_of_work = $('#name_of_work').val();
            var sample_details = $('#sample_details').val();
            
            if(ulr_no == 'new')
            {
               var newulr_no = $('#newulr_no').val(); 
            }
            else
            {
                var newulr_no = ''; 
            }
            
             $.ajax({
            url:base_url + 'Ulrlink/create?uid_no='+uid_no+'&ulr_no='+ulr_no+'&date='+date+'&agency_name='+agency_name+'&reporting_address='+reporting_address+'&agency_name='+agency_name+'&name_of_work='+name_of_work+'&sample_details='+sample_details+'&newulr_no='+newulr_no,
            type: 'post',
            dataType: 'json',
            success:function(response) 
            {
                if(response.success === true) 
                {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
                    location.reload();
                    
                } 
                else 
                {
    
                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                    '</div>'); 
                    
                }
            }
        });
        
     }
</script>