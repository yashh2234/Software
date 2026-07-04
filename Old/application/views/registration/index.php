<style>
@media (min-width: 768px)
{
     
    label
    {
        height:18px;
    }
    .form-control {
        font-size: 14px;
    }
    .modal-lg
    {
        width: 1300px;
    }
}

</style><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Client Registraion</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Client Registraion</li>
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

         
        <?php if(in_array('createRegistration', $user_permission)): ?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addBrandModal" class="btn btn-primary">Create Registraion <i class="fa fa-arrow-circle-right"></i></a>
        <?php endif; ?> 
        <?php if(in_array('createRegistration', $user_permission)): ?>
          <a href="javascript:void(0);" onclick="exportdata();" class="btn btn-info">Export</a>
          <br /> <br />
        <?php endif; ?>
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Client Registraion</h3>
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
            <table id="manageTable" class="table table-bordered table-striped" style="cursor:pointer">
              <thead>
                <tr>
                    <?php
                    if($groupid == 1 || $groupid == 8)
                    {
                    ?>
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
                    <?php if(in_array('updateRegistration', $user_permission) || in_array('deleteRegistration', $user_permission)): ?>
                    <th>Action</th>
                    <?php endif; ?>
                    <?
                    }
                    else
                    {
                    ?>
                    <th>UID NO.</th>
                    <th>Date</th>
    				<th>Agency_name</th>
    		        <th>Reporting Address</th>
    				<th>Mobile No.</th> 
    			    <th>Name Of Work</th>
    			    <th>Sample Details</th>
    				<th>View Scan Copy</th> 
    				 <th>Report Copy</th> 
                    <?
                    }
                    ?>
                    
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

<?php if(in_array('createRegistration', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addBrandModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Details Of Customer</h3>
      </div>
<div class="row">
                
                <div class="col-sm-6">
      <form role="form" action="<?php echo base_url('registration/create') ?>" method="post" id="createBrandForm">

        <div class="modal-body">
            <div class="row">
                
                <div class="col-sm-12">
                     <div id="exist_messages"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                    <label for="vehicle_name">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Name of Agency</label>
                        <input type="text" class="form-control" id="agency_name" name="agency_name" placeholder="Enter Name of Agency" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Name of Department</label>
                        <input type="text" class="form-control" id="reporting_address" name="reporting_address" placeholder="Enter Name of Department" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Name Of Work</label>
                        <input type="text" class="form-control" id="name_work" name="name_work" placeholder="Enter Name Of Work" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Mobile No.</label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Work order no</label>
                        <input type="text" class="form-control" id="work_orders_no" name="work_orders_no" placeholder="Enter Work order No" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Reference of.</label>
                        <input type="text" class="form-control" id="references" name="references" placeholder="Enter Reference oF" autocomplete="off">
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Report Status</label>
                        <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Work</label>
                        <select class="form-control" id="work" name="work">
                                <option value="">Select Work</option>
                                <option value="Profile Lab">Profile Lab</option>
                                <option value="Consultancy">Consultancy</option>
                                <option value="Survey">Survey</option>
                            </select>
                    </div>
                </div>
                </div>
                
                <div class="col-sm-12">
                    <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Sample Details</h3>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="vehicle_name">New/ Back</label>
                            <select class="form-control" id="new_back" name="new_back">
                                <option value="">Select Sample</option>
                                <option value="new">New</option>
                                <option value="back">Back</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Details 1</label>
                        <input list="brow" type="text" class="form-control" id="sample_details" name="sample_details" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div>
                 <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                        <div class="form-group">
                            <label for="vehicle_name">New/ Back 2</label>
                            <select class="form-control" id="new_back_1" name="new_back_1">
                                <option value="">Select Sample</option>
                                <option value="new">New</option>
                                <option value="back">Back</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Details 2</label>
                           <input list="brow1" type="text" class="form-control" id="sample_details_1" name="sample_details_1" placeholder="Enter Sample Details" />
                        <datalist id="brow1">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist> 
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 2</label>
                        <input type="text" class="form-control" id="qty_1" name="qty_1" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                        <div class="form-group">
                            <label for="vehicle_name">New/ Back 3</label>
                            <select class="form-control" id="new_back_2" name="new_back_2">
                                <option value="">Select Sample</option>
                                <option value="new">New</option>
                                <option value="back">Back</option>
                            </select>
                        </div>
                    </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Details 3</label>
                           <input list="brow2" type="text" class="form-control" id="sample_details_2" name="sample_details_2" placeholder="Enter Sample Details" />
                        <datalist id="brow2">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist> 
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 3</label>
                        <input type="text" class="form-control" id="qty_2" name="qty_2" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                        <div class="form-group">
                            <label for="vehicle_name">New/ Back 4</label>
                            <select class="form-control" id="new_back _3" name="new_back_3">
                                <option value="">Select Sample</option>
                                <option value="new">New</option>
                                <option value="back">Back</option>
                            </select>
                        </div>
                    </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Details 4</label>
                             <input list="brow3" type="text" class="form-control" id="sample_details_3" name="sample_details_3" placeholder="Enter Sample Details" />
                        <datalist id="brow3">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist> 
                    </div>
                </div>
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 4</label>
                        <input type="text" class="form-control" id="qty_3" name="qty_3" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                        <div class="form-group">
                            <label for="vehicle_name">New/ Back 5</label>
                            <select class="form-control" id="new_back_4" name="new_back_4">
                                <option value="">Select Sample</option>
                                <option value="new">New</option>
                                <option value="back">Back</option>
                            </select>
                        </div>
                    </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Details 5</label>
                              <input list="brow4" type="text" class="form-control" id="sample_details_4" name="sample_details_4" placeholder="Enter Sample Details" />
                        <datalist id="brow4">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist> 
                    </div>
                </div>
                
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 5</label>
                        <input type="text" class="form-control" id="qty_4" name="qty_4" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                
                     
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Witness</label>
                        <input type="text" class="form-control" id="witness" name="witness" placeholder="witness" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Test</label>
                        <input type="text" class="form-control" id="sample_test" name="sample_test" placeholder="Sample Test" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-sm-4"><div class="form-group">
                        <label for="vehicle_name">Sample Remark</label>
                        <input type="text" class="form-control" id="sample_remark" name="sample_remark" placeholder="Sample Remark" autocomplete="off">
                    </div></div>
                </div>
                <div class="col-sm-12">
                      <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Office Work</h3>  
                  <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Report No</label>
                        <input type="text" class="form-control" id="report_no" name="report_no" placeholder="Report No" autocomplete="off">
                    </div>
                </div>
               
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Field Person</label>
                        <input type="text" class="form-control" id="field_person_name" name="field_person_name" placeholder="witness" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Prepared Date</label>
                        <input type="date" class="form-control" id="prepared_date" name="prepared_date" placeholder="Prepared Date" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Dispatch Date</label>
                        <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" placeholder="Dispatch Date" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Assign To</label>
                        <select class="form-control" id="assign_to" name="assign_to">
                            <option value="lab">Lab</option>
                            <option value="admin">admin</option> 
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Report Status</label>
                        <select class="form-control" id="report_status" name="report_status">
                            <option value="">Select Report Status</option>
                            <option  value="lab process">lab process</option>
                            <option value="Report complete">Report Complete</option>
                            <option value="Report pending">Report Pending</option>
                            <option value="Report dispached">Report Dispached</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Report Copy</label>
                         <input type="file" class="form-control" id="report_copy" name="report_copy" >
                    </div>
                </div>
               </div>
.               <div class="col-sm-12">
                      <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Financial Report</h3>  
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Total Payment</label>
                        <input type="text" class="form-control" id="total_payment" name="total_payment" placeholder="Total Payment" onkeyup="calculate_final_freight();" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Advance Payment</label>
                        <input type="text" class="form-control" id="advance_payment" name="advance_payment" placeholder="Advance Payment" onkeyup="calculate_final_freight();" autocomplete="off">
                    </div>
                </div>
              
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Balance Dues</label>
                        <input type="text" class="form-control" id="balance_dues" name="balance_dues" placeholder="Balance Dues" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Payment Followup</label>
                        <input type="text" class="form-control" id="payment_followup" name="payment_followup" placeholder="Payment Followup" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Mode of Payment</label>
                        <select class="form-control" id="mode_of_payment" name="mode_of_payment">
                        <option value="">Select Mode of payment</option>
                        <option  value="upi">UPI</option>
                        <option value="cash">Cash</option>
                        <option value="online banking">Online Banking</option>
                        <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Financial Remark</label>
                        <input type="text" class="form-control" id="financial_remark" name="financial_remark" placeholder="Financial Remark" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">GST Number</label>
                        <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="GST Number" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Nos</label>
                        <input type="text" class="form-control" id="sample_nos" name="sample_nos" placeholder="sample_nos" autocomplete="off">
                    </div>
                </div>
                    <input type="hidden" class="form-control" id="scan_copy_image" name="scan_copy_image" value="">
                    <input type="hidden" class="form-control" id="scan_copy_image1" name="scan_copy_image1" value="">
                    <input type="hidden" class="form-control" id="scan_copy_image2" name="scan_copy_image2" value="">
                    <input type="hidden" class="form-control" id="scan_copy_image3" name="scan_copy_image3" value="">
                    <input type="hidden" class="form-control" id="scan_copy_image4" name="scan_copy_image4" value="">
               </div>
  
                </div>
            </div>
       

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>
    </div>
    <div class="col-sm-6">
        <div class="col-sm-12">
            <form enctype="multipart/form-data" id="submit">
            <div id="alertMessage" class="alert alert-warning mb-3" style="display: none">
                <span id="alertMsg"></span>
            </div>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="https://via.placeholder.com/600" id="ajaxImgUpload" style="width: 600px;" alt="Los Angeles">
      </div>

      <div class="item">
        <img src="https://via.placeholder.com/600" id="ajaxImgUpload1" style="width: 600px;" alt="Los Angeles">
      </div>
    
      <div class="item">
        <img src="https://via.placeholder.com/600" id="ajaxImgUpload2" style="width: 600px;" alt="Los Angeles">
      </div>
      <div class="item">
        <img src="https://via.placeholder.com/600" id="ajaxImgUpload3" style="width: 600px;" alt="Los Angeles">
      </div>
      <div class="item">
        <img src="https://via.placeholder.com/600" id="ajaxImgUpload4" style="width: 600px;" alt="Los Angeles">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
            <div class="form-group">
                <label for="vehicle_name">Upload Scan Copy</label>
                <input type="file" class="form-control" id="scan_copy" multiple="multiple" name="scan_copy[]">
                <p style="color:red;font-size:12px;">Upload Max 5 Files</p>
            </div>
            
            <div class="modal-footer"> 
              <button type="submit" class="btn btn-primary uploadBtn">Upload Image</button>
            </div>   
            </form>
        </div>
    </div>
</div> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateRegistration', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editBrandModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Details Of Customer</h3>
      </div>
      <div class="row">
        <div class="col-sm-6">
      <form role="form" action="<?php echo base_url('registration/update') ?>" method="post" id="updateBrandForm">

        <div class="modal-body">
          <div id="messages"></div>
            <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                     <div id="exist_messages"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                    <label for="vehicle_name">Date</label>
                    <input type="text" class="form-control" id="edit_date" name="edit_date">
                </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Agency Name</label>
                        <input type="text" class="form-control" id="edit_agency_name" name="edit_agency_name" placeholder="Enter Agency Name" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Reporting Address</label>
                        <input type="text" class="form-control" id="edit_reporting_address" name="edit_reporting_address" placeholder="Enter Reporting Address" autocomplete="off">
                    </div>
                </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Name Of Work</label>
                        <input type="text" class="form-control" id="edit_name_work" name="edit_name_work" placeholder="Enter Name Of Work" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Mobile No.</label>
                        <input type="text" class="form-control" id="edit_mobile_no" name="edit_mobile_no" placeholder="Enter Mobile No" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Work order no</label>
                        <input type="text" class="form-control" id="edit_work_orders_no" name="edit_work_orders_no" placeholder="Enter Work order No" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Reference of.</label>
                        <input type="text" class="form-control" id="edit_references" name="edit_references" placeholder="Enter Reference oF" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Report Status</label>
                        <input type="text" class="form-control" id="edit_remark" name="edit_remark" placeholder="Remark" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Work</label>
                        <select class="form-control" id="edit_work" name="edit_work">
                                <option value="">Select Work</option>
                                <option value="Profile Lab">Profile Lab</option>
                                <option value="Consultancy">Consultancy</option>
                                <option value="Survey">Survey</option>
                            </select>
                    </div>
                </div>
                </div>
                
                <div class="col-sm-12">
                    <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Sample Details</h3>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_new_back">New/ Back</label>
                        <select class="form-control" id="edit_new_back" name="edit_new_back">
                            <option value="">Select Sample</option>
                            <option value="new">New</option>
                            <option value="back">Back</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_sample_details">Sample Details 1</label>
                        <input list="brow" type="text" class="form-control" id="edit_sample_details" name="edit_sample_details" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div>
                   <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 1</label>
                        <input type="text" class="form-control" id="edit_qty" name="edit_qty" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_new_back">New/ Back 2</label>
                        <select class="form-control" id="edit_new_back_1" name="edit_new_back_1">
                            <option value="">Select Sample</option>
                            <option value="new">New</option>
                            <option value="back">Back</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_sample_details">Sample Details 2</label>
                       <input list="brow" type="text" class="form-control" id="edit_sample_details_1" name="edit_sample_details_1" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div>
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 2</label>
                        <input type="text" class="form-control" id="edit_qty_1" name="edit_qty_1" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_new_back">New/ Back 3</label>
                        <select class="form-control" id="edit_new_back_2" name="edit_new_back_2">
                            <option value="">Select Sample</option>
                            <option value="new">New</option>
                            <option value="back">Back</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_sample_details">Sample Details 3</label>
                       <input list="brow" type="text" class="form-control" id="edit_sample_details_2" name="edit_sample_details_3" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div>
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 3</label>
                        <input type="text" class="form-control" id="edit_qty_2" name="edit_qty_2" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_new_back">New/ Back 4</label>
                        <select class="form-control" id="edit_new_back_3" name="edit_new_back_3">
                            <option value="">Select Sample</option>
                            <option value="new">New</option>
                            <option value="back">Back</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_sample_details">Sample Details 4</label>
                        <input list="brow" type="text" class="form-control" id="edit_sample_details_3" name="edit_sample_details_3" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div> 
               
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 4</label>
                        <input type="text" class="form-control" id="edit_qty_3" name="edit_qty_3" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_new_back">New/ Back 5</label>
                        <select class="form-control" id="edit_new_back_4" name="edit_new_back_4">
                            <option value="">Select Sample</option>
                            <option value="new">New</option>
                            <option value="back">Back</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="edit_sample_details">Sample Details 5</label>
                        <input list="brow" type="text" class="form-control" id="edit_sample_details_4" name="edit_sample_details_4" placeholder="Enter Sample Details" />
                        <datalist id="brow">
                                <option value="CC CUBE">CC CUBE</option>
                                <option value="CC CORE">CC CORE</option>
                                <option value="Bitumen Core">Bitumen Core</option>
                                <option value="Bitumen Loose">Bitumen Loose</option>
                                <option value="Interlocking Tiles">Interlocking Tiles</option>
                                <option value="Steel">Steel</option>
                                <option value="Sand">Sand</option>
                                <option value="Cement">Cement</option>
                                <option value="Water">Water</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Ferro Cover">Ferro Cover</option>
                                <option value="Mainhole Cover">Mainhole Cover</option>
                                <option value="Coarse Agreegate">Coarse Agreegate</option>
                                <option value="Fine Agreegate">Fine Agreegate</option>
                                <option value="Clay Brick">Clay Brick</option>
                                <option value="Fly Aish Brick">Fly Aish Brick </option>
                                <option value="WMM">WMM</option>
                                <option value="GSB">GSB</option>
                                <option value="Mix Design">Mix Design</option>
                                <option value="Rebound Hammer Test">Rebound Hammer Test</option>
                                <option value="Ultrasonic Pulse Velocity">Ultrasonic Pulse Velocity</option>
                                <option value="Carbonation Test">Carbonation Test</option>
                                <option value="Half Cell Potential">Half Cell Potential</option>
                                <option value="Others">Others</option>
                                <option value="Custom">Custom</option>
		                </datalist>  
                    </div>
                </div>
                  
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Qty 5</label>
                        <input type="text" class="form-control" id="edit_qty_4" name="edit_qty_4" placeholder="Qty" autocomplete="off">
                    </div>
                </div>
                
                     
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Witness</label>
                        <input type="text" class="form-control" id="edit_witness" name="edit_witness" placeholder="witness" autocomplete="off">
                    </div>
                </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Test</label>
                        <input type="text" class="form-control" id="edit_sample_test" name="edit_sample_test" placeholder="Sample Test" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-4"><div class="form-group">
                        <label for="vehicle_name">Sample Remark</label>
                        <input type="text" class="form-control" id="edit_sample_remark" name="edit_sample_remark" placeholder="Sample Remark" autocomplete="off">
                    </div></div>
                </div>
                </div>
                <div class="col-sm-12">
                      <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Office Work</h3>  
                  <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Report No</label>
                        <input type="text" class="form-control" id="edit_report_no" name="edit_report_no" placeholder="Report No" autocomplete="off">
                    </div>
                </div>
               
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Field Person</label>
                        <input type="text" class="form-control" id="edit_field_person_name" name="edit_field_person_name" placeholder="witness" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Prepared Date</label>
                        <input type="text" class="form-control" id="edit_prepared_date" name="edit_prepared_date" placeholder="Prepared Date" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Dispatch Date</label>
                        <input type="text" class="form-control" id="edit_dispatch_date" name="edit_dispatch_date" placeholder="Dispatch Date" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Assign To</label>
                        <select class="form-control" id="edit_assign_to" name="edit_assign_to">
                            <option value="lab">Lab</option>
                            <option value="admin">admin</option> 
                        </select>
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Report Status</label>
                        <select class="form-control" id="edit_report_status" name="edit_report_status">
                            <option value="">Select Report Status</option>
                            <option  value="lab process">lab process</option>
                            <option value="Report complete">Report Complete</option>
                            <option value="Report pending">Report Pending</option>
                            <option value="Report dispached">Report Dispached</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Report Copy</label>
                         <input type="file" class="form-control" id="edit_report_copy" name="edit_report_copy" >
                    </div>
                     
                </div>
               </div>
.               <div class="col-sm-12">
                      <h3 style="text-align: center;background: #000;color: #fff;padding: 6px;font-size: 18px;">Financial Report</h3>  
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Total Payment</label>
                        <input type="text" class="form-control" id="edit_total_payment" name="edit_total_payment" onkeyup="edit_calculate_final_freight();" placeholder="Total Payment" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Advance Payment</label>
                        <input type="text" class="form-control" id="edit_advance_payment" name="edit_advance_payment" onkeyup="edit_calculate_final_freight();" placeholder="Advance Payment" autocomplete="off">
                    </div>
                </div>
               
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Balance Dues</label>
                        <input type="text" class="form-control" id="edit_balance_dues" name="edit_balance_dues" placeholder="Balance Dues" autocomplete="off">
                    </div>
                </div>
             
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Payment Followup</label>
                        <input type="text" class="form-control" id="edit_payment_followup" name="edit_payment_followup" placeholder="Payment Followup" autocomplete="off">
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Mode of Payment</label>
                        <select class="form-control" id="edit_mode_of_payment" name="edit_mode_of_payment">
                        <option value="">Select Mode of payment</option>
                        <option  value="upi">UPI</option>
                        <option value="cash">Cash</option>
                        <option value="online banking">Online Banking</option>
                        <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="vehicle_name">Financial Remark</label>
                        <input type="text" class="form-control" id="edit_financial_remark" name="edit_financial_remark" placeholder="Financial Remark" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">GST Number</label>
                        <input type="text" class="form-control" id="edit_gst_no" name="edit_gst_no" placeholder="GST Number" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="vehicle_name">Sample Nos</label>
                        <input type="text" class="form-control" id="edit_sample_nos" name="edit_sample_nos" placeholder="sample_nos" autocomplete="off">
                    </div>
                </div>
               </div>
                <input type="hidden" name="edit_old_report_copy" id="edit_old_report_copy" value="">
  
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>
    </div>
     <div class="col-sm-6">
        <div class="col-sm-12">
            
    <div id="myCarousel1" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="https://via.placeholder.com/600" id="edit_ajaxImgUpload" style="width: 600px;" alt="Los Angeles">
      </div>

      <div class="item">
        <img src="https://via.placeholder.com/600" id="edit_ajaxImgUpload1" style="width: 600px;" alt="Los Angeles">
      </div>
    
      <div class="item">
        <img src="https://via.placeholder.com/600" id="edit_ajaxImgUpload2" style="width: 600px;" alt="Los Angeles">
      </div>
      <div class="item">
        <img src="https://via.placeholder.com/600" id="edit_ajaxImgUpload3" style="width: 600px;" alt="Los Angeles">
      </div>
      <div class="item">
        <img src="https://via.placeholder.com/600" id="edit_ajaxImgUpload4" style="width: 600px;" alt="Los Angeles">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel1" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel1" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
          
           
        </div>
    </div>
</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>
 
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeRegistrationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Registration</h4>
      </div>

      <form role="form" action="<?php echo base_url('registration/remove') ?>" method="post" id="removeBrandForm">
        <div class="modal-body">
            <p>Do you really want to remove?</p>
        </div>
        <input type="hidden" id="delete_status" value="no">
        <input type="hidden" id="iClientId" value="">
        
        <div class="modal-footer">
          <button type="button" onclick="deleteStatuscancel();" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" onclick="deleteStatus();" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() { 
    
    $( "#edit_prepared_date" ).datepicker();
    $( "#edit_dispatch_date" ).datepicker();
    $( "#edit_date" ).datepicker();

  $("#brandNav").addClass('active');
    // initialize the datatable 
     var start_date  = $("#start_date").val();
    var end_date  = $("#end_date").val();
    
    
    
    if(start_date)
    {
        
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'registration/fetchOrdersFilterData?start_date='+start_date+'&end_date='+end_date,
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

    $.ajax({
      url: form.attr('action'),
        type:"post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
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
            location.reload();
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

 function deleteStatus()
 {
     $('#delete_status').val('yes');
     var iClientId = $('#iClientId').val();
     
    removeRegistration(iClientId)
 
 }
 function deleteStatuscancel()
 {
     $('#delete_status').val('no');
 }
function editRegistration(id)
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
                $("#edit_date").val(response.received_date);
                $("#edit_agency_name").val(response.agency_name);
                $("#edit_customer_name").val(response.customer_name);
                $("#edit_reporting_address").val(response.reporting_address);
                $("#edit_mobile_no").val(response.mobile_no);
                
                $("#edit_care_of").val(response.care_of); 
                $("#edit_new_back").val(response.new_back);
                $("#edit_new_back_1").val(response.new_back_1);
                $("#edit_new_back_2").val(response.new_back_2);
                $("#edit_new_back_3").val(response.new_back_3);
                $("#edit_new_back_4").val(response.new_back_4);
                $("#edit_sample_details").val(response.sample_details);
                $("#edit_sample_details_1").val(response.sample_details_1);
                $("#edit_sample_details_2").val(response.sample_details_2);
                $("#edit_sample_details_3").val(response.sample_details_3);
                $("#edit_sample_details_4").val(response.sample_details_4);
                $("#edit_qty").val(response.qty);
                $("#edit_qty_1").val(response.qty_1);
                $("#edit_qty_2").val(response.qty_2);
                $("#edit_qty_3").val(response.qty_3);
                $("#edit_qty_4").val(response.qty_4);
                 $("#edit_sample_test").val(response.sample_test);
               
                $("#edit_witness").val(response.witness);
                $("#edit_field_person_name").val(response.field_person_name),
                $("#edit_prepared_date").val(response.prepared_date),
                $("#edit_dispatch_date").val(response.dispatch_date),
                $("#edit_report_no").val(response.report_no),
                $("#edit_remark").val(response.remark),
                $("#edit_work").val(response.work),
                $("#edit_sample_remark").val(response.sample_remark),
                $("#edit_advance_payment").val(response.advance_payment),
                $("#edit_balance_dues").val(response.balance_dues),
                $("#edit_total_payment").val(response.total_payment),
                $("#edit_payment_followup").val(response.payment_followup),
                $("#edit_mode_of_payment").val(response.mode_of_payment),
                $("#edit_office_remark").val(response.office_remark),
                $("#edit_financial_remark").val(response.financial_remark),
                $("#edit_name_work").val(response.name_of_work),
                $("#edit_work_orders_no").val(response.work_order_no),
                $("#edit_references").val(response.reference),
                $("#edit_assign_to").val(response.assign_to),
                $("#edit_ajaxImgUpload").attr('src', response.scan_copy),
                $("#edit_ajaxImgUpload1").attr('src', response.scan_copy_1),
                $("#edit_ajaxImgUpload2").attr('src', response.scan_copy_2),
                $("#edit_ajaxImgUpload3").attr('src', response.scan_copy_3),
                $("#edit_ajaxImgUpload4").attr('src', response.scan_copy_4),
                 $("#edit_report_status").val(response.report_status),
                $("#edit_gst_no").val(response.gst_no),
                $("#edit_sample_nos").val(response.sample_nos), 
                $("#edit_old_report_copy").val(response.report_copy),

      // submit the edit from 
      $("#updateBrandForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false,
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
              location.reload();
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

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [day,month,year].join('/');
    
    Date('d M Y',response.date_time)
}

function removeRegistration(id)
{ 
    if(id) { 
      $(".text-danger").remove();
      $('#iClientId').val(id);
     var delete_status = $('#delete_status').val();
     
     if(delete_status == 'yes')
     {
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
 
          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 
       $("#removeRegistrationModal").modal('hide');  
      return false;
     }
  }
}
 
    
$('#submit').submit(function(e){
    e.preventDefault(); 
         $.ajax({
             url:'/registration/upload',
             type:"post",
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:false,
               dataType: 'json',
		success:function(response) 
		{
			if(response.success === true) 
			{
			    if(response.image != ''){
				    $('#ajaxImgUpload').attr('src', base_url+'assets/images/scan_copy/'+response.image);
				     $('#scan_copy_image').val(base_url+'assets/images/scan_copy/'+response.image);
			    }
			    else
			    {
			        $('#ajaxImgUpload').attr('src', 'https://via.placeholder.com/600');  
			        $('#scan_copy_image').val();
			    }
			    if(response.image1 != ''){
				    $('#ajaxImgUpload1').attr('src', base_url+'assets/images/scan_copy/'+response.image1);
				     $('#scan_copy_image1').val(base_url+'assets/images/scan_copy/'+response.image1);
			    }
			    else
			    {
			        $('#ajaxImgUpload1').attr('src', 'https://via.placeholder.com/600'); 
			         $('#scan_copy_image1').val();
			    }
			    if(response.image2 != ''){
				    $('#ajaxImgUpload2').attr('src', base_url+'assets/images/scan_copy/'+response.image2);
				    $('#scan_copy_image2').val(base_url+'assets/images/scan_copy/'+response.image2);
			    }
			    else
			    {
			        $('#ajaxImgUpload2').attr('src', 'https://via.placeholder.com/600');  
			        $('#scan_copy_image2').val();
			    }
			    if(response.image3 != ''){
				    $('#ajaxImgUpload3').attr('src', base_url+'assets/images/scan_copy/'+response.image3);
				     $('#scan_copy_image3').val(base_url+'assets/images/scan_copy/'+response.image3);
			    }
			    else
			    {
			        $('#ajaxImgUpload3').attr('src', 'https://via.placeholder.com/600'); 
			         $('#scan_copy_image3').val();
			    }
			    if(response.image4 != ''){
				    $('#ajaxImgUpload4').attr('src', base_url+'assets/images/scan_copy/'+response.image4);
				    $('#scan_copy_image4').val(base_url+'assets/images/scan_copy/'+response.image4);
			    }
			    else
			    {
			        $('#ajaxImgUpload4').attr('src', 'https://via.placeholder.com/600');  
			        $('#scan_copy_image4').val();
			    }
                 
				$('#alertMsg').html(res.messages);
				$('#alertMessage').show();
			} else if (res.success == false) {
				$('#alertMsg').html(res.messages);
				$('#alertMessage').show();
                $('#scan_copy_image1').val();
                $('#scan_copy_image2').val();
                $('#scan_copy_image3').val();
                $('#scan_copy_image4').val();
                $('#scan_copy_image').val();
			}
           }
         });
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
    
    function exportdata()
    {
        var start_date  = $("#start_date").val();
        var end_date  = $("#end_date").val();
        if(start_date)
        {
            window.location.href = '/registration/export?start_date='+start_date+'&end_date='+end_date;
        }
        else
        {
            window.location.href = '/registration/export';
        }
        
    }
    
    function calculate_final_freight()
    {
        
        
        if($('#total_payment').val() > 0)
        {
            var total_payment = $('#total_payment').val();  
        }
        else
        {
             var total_payment = 0; 
        }
        if($('#advance_payment').val() > 0)
        {
            var advance_payment = $('#advance_payment').val();  
        }
        else
        {
             var advance_payment = 0; 
        }
         if( Math.abs(advance_payment) > Math.abs(total_payment))
         {
             alert('Invalid Amount !');
             $('#advance_payment').val(0); 
             $('#balance_dues').val(0);
         }
        else
        {
           var totalbalance = Math.abs(total_payment) - Math.abs(advance_payment);
            $('#balance_dues').val(totalbalance);  
        }
         
        
    }
         function edit_calculate_final_freight()
    {
        
        
        if($('#edit_total_payment').val() > 0)
        {
            var edit_total_payment = $('#edit_total_payment').val();  
        }
        else
        {
             var edit_total_payment = 0; 
        }
        if($('#edit_advance_payment').val() > 0)
        {
            var edit_advance_payment = $('#edit_advance_payment').val();  
        }
        else
        {
             var edit_advance_payment = 0; 
        }
         if( Math.abs(edit_advance_payment) > Math.abs(edit_total_payment))
         {
             alert('Invalid Amount !');
             $('#edit_advance_payment').val(0); 
             $('#edit_balance_dues').val(0);
         }
        else
        {
           var totalbalance = Math.abs(edit_total_payment) - Math.abs(edit_advance_payment);
            $('#edit_balance_dues').val(totalbalance);  
        }
         
        
    }
     
     
     
    $("#sample_details").on('input', function () 
    {
        var val = $('#sample_details').val();;
       
        
        if(val == 'CC CUBE')
        {
            var amount = '400';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'CC CORE')
        {
            var amount = '1500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Core')
        {
            var amount = '2000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Loose')
        {
            var amount = '2000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Interlocking Tiles')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Steel')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Sand')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Cement')
        {
            var amount = '1500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Water')
        {
            var amount = '4000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Pipe')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Ferro Cover')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mainhole Cover')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Coarse Agreegate')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Fine Agreegate')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Clay Brick')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Fly Aish Brick')
        {
            var amount = '1200';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'WMM')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'GSB')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mix Design')
        {
            var amount = '7200';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Rebound Hammer Test')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Ultrasonic Pulse Velocity')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Carbonation Test')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Half Cell Potential')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(totalAmt != 'NaN')
        {
            var totalAmtold = $('#total_payment').val();
		
			var totalAmtNew = Math.abs(totalAmtold) + Math.abs(totalAmt);
            $('#total_payment').val(totalAmtNew);
        }
    });
    
      
    $("#qty").on('input', function () 
    {
        var val = $('#sample_details').val();;
        
        if(val == 'CC CUBE')
        {
            var amount = '400';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'CC CORE')
        {
            var amount = '1500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Core')
        {
            var amount = '2000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Loose')
        {
            var amount = '2000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Interlocking Tiles')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Steel')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Sand')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Cement')
        {
            var amount = '1500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Water')
        {
            var amount = '4000';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Pipe')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Ferro Cover')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mainhole Cover')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Coarse Agreegate')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Fine Agreegate')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Clay Brick')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Fly Aish Brick')
        {
            var amount = '1200';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'WMM')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'GSB')
        {
            var amount = '700';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mix Design')
        {
            var amount = '7200';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Rebound Hammer Test')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Ultrasonic Pulse Velocity')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Carbonation Test')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Half Cell Potential')
        {
            var amount = '500';
            var qty = $('#qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(totalAmt != 'NaN')
        {
        $('#total_payment').val(totalAmt);
        }
    });
    
    
    
     $("#edit_sample_details").on('input', function () 
    {
        var val = $('#edit_sample_details').val();;
        
        if(val == 'CC CUBE')
        {
            var amount = '400';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'CC CORE')
        {
            var amount = '1500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Core')
        {
            var amount = '2000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Loose')
        {
            var amount = '2000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Interlocking Tiles')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Steel')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Sand')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Cement')
        {
            var amount = '1500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Water')
        {
            var amount = '4000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Pipe')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Ferro Cover')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mainhole Cover')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Coarse Agreegate')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Fine Agreegate')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Clay Brick')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Fly Aish Brick')
        {
            var amount = '1200';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'WMM')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'GSB')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mix Design')
        {
            var amount = '7200';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Rebound Hammer Test')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Ultrasonic Pulse Velocity')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Carbonation Test')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Half Cell Potential')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(totalAmt != 'NaN')
        {
        $('#edit_total_payment').val(totalAmt);
        }
    });
    $("#edit_qty").on('input', function () 
    {
        var val = $('#edit_sample_details').val();;
        
        if(val == 'CC CUBE')
        {
            var amount = '400';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'CC CORE')
        {
            var amount = '1500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Core')
        {
            var amount = '2000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Bitumen Loose')
        {
            var amount = '2000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Interlocking Tiles')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        
        if(val == 'Steel')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Sand')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Cement')
        {
            var amount = '1500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Water')
        {
            var amount = '4000';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Pipe')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Ferro Cover')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mainhole Cover')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Coarse Agreegate')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Fine Agreegate')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Clay Brick')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Fly Aish Brick')
        {
            var amount = '1200';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'WMM')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'GSB')
        {
            var amount = '700';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Mix Design')
        {
            var amount = '7200';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Rebound Hammer Test')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(val == 'Ultrasonic Pulse Velocity')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Carbonation Test')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }if(val == 'Half Cell Potential')
        {
            var amount = '500';
            var qty = $('#edit_qty').val();
            var totalAmt = Math.abs(amount) * Math.abs(qty);
        }
        if(totalAmt != 'NaN')
        {
            $('#edit_total_payment').val(totalAmt);
        }
    });
</script>
