<style>
    .row
    {
        margin-left:2px;
    }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <section class="content-header"> 
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <div class="row">
        <?if($this->session->userdata('id') == 1){?>
            <div class="col-lg-6">
              <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">Total Year Finance</h3>  
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $totalreg; ?></h3>
            
                <p>Total Registration</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
            </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $totalreports; ?></h3>
            
                <p>Total Reports</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
            </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo '₹'.$totalamount; ?></h3>
            
                <p>Total Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
            </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$totalreciveamount; ?></h3>
            
                <p>Total Received  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
            </div>
             <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$totalcashamount; ?></h3>
            
                <p>Total Cash  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
            </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$totalbalanceamount; ?></h3>
            
                <p>Total Balance  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
            </div>
           
            </div>
            <div class="col-lg-6">
                  <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">Total Today Finance</h3>  
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $todaytotalreg; ?></h3>

                <p>Today Total Registration</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
          </div>
          <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $todaytotalreports; ?></h3>

                <p>Today Total Reports</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo '₹'.$todaytotalamount; ?></h3>

                <p>Today Total Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$todaytotalreciveamount; ?></h3>

                <p>Today Total Received  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
          </div> 
          <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$totaltodaycashamount; ?></h3>

                <p>Today Total Cash  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
          </div> 
            <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo '₹'.$todaytotalbalanceamount; ?></h3>

                <p>Today Total Balance  Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               
            </div>
          </div> 
            
          </div>
           <div class="col-lg-6">
            <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">Total Pending Final Report</h3>  
            <div class="col-lg-12 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $totalpendingreport; ?></h3>
            
                <p>Total Report Pending</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div> 
            </div>
            </div>
            
           
            </div>
        <? } ?>
        <?if($this->session->userdata('id') != 1){?>
        <?php if(in_array('createRegistration', $user_permission)): ?>
         
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h4>Registraion</h4>

                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('registration/') ?>" class="small-box-footer">Create <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
        <?php endif; ?>
          
          <?php if(in_array('createOrder', $user_permission)): ?>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Concrete Core</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('concretecore/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h4>Cube Sample</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('cubereport/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            
            
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Bitumen Loose</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('bitumenloose/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h4>Bitumen Core</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('bitumencore/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h4>Interlocking Tiles</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('interlockingtiles/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h4>Concrete Beam</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('concretebeam/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Ferro Cover</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('ferrocover/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
             <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Mainhole Cover</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('mainholecover/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
              <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Water</h4>
                <p>Create New</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('water/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
          <?php endif; ?>
          <?php } ?>
        </div>
      
         <?if($this->session->userdata('id') == 1){?>
          <div class="row">
                   
                    <div class="col-lg-6 col-xs-12">
                       <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">
    Total Amount of This Month
  </h3>
  <div class"row">
    
    <div class="col-sm-12 text-center">
       <div id="line-chart1" style="height:300px;width:100%"></div>
    </div>
     
   
    <script>
        var data = [
      { d: '1', a: <?php echo $newdate1;?>},
      { d: '2', a: <?php echo $newdate2;?>},
      { d: '3', a: <?php echo $newdate3;?>},
      { d: '4', a: <?php echo $newdate4;?>},
      { d: '5', a: <?php echo $newdate5;?>},
      { d: '6', a: <?php echo $newdate6;?>},
      { d: '7', a: <?php echo $newdate7;?>},
      { d: '8', a: <?php echo $newdate8;?>},
      { d: '9', a: <?php echo $newdate9;?>},
      { d: '10', a: <?php echo $newdate10;?>},
      { d: '11', a: <?php echo $newdate11;?>},
      { d: '12', a: <?php echo $newdate12;?>},
      { d: '13', a: <?php echo $newdate13;?>},
      { d: '14', a: <?php echo $newdate14;?>},
      { d: '15', a: <?php echo $newdate15;?>},
      { d: '16', a: <?php echo $newdate16;?>},
      { d: '17', a: <?php echo $newdate17;?>},
      { d: '18', a: <?php echo $newdate18;?>},
      { d: '19', a: <?php echo $newdate19;?>},
      { d: '20', a: <?php echo $newdate20;?>},
      { d: '21', a: <?php echo $newdate21;?>},
      { d: '22', a: <?php echo $newdate22;?>},
      { d: '23', a: <?php echo $newdate23;?>},
      { d: '24', a: <?php echo $newdate24;?>},
      { d: '24', a: <?php echo $newdate25;?>},
      { d: '26', a: <?php echo $newdate26;?>},
      { d: '27', a: <?php echo $newdate27;?>},
      { d: '28', a: <?php echo $newdate28;?>},
      { d: '29', a: <?php echo $newdate29;?>},
      { d: '30', a: <?php echo $newdate30;?>},
      { d: '31', a: <?php echo $newdate31;?>}
    ],
    config = {
      data: data,
      xkey: 'd',
      ykeys: ['a'],
      labels: ['Total Amount'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['green']
  };
 
config.element = 'line-chart1';
Morris.Line(config);
 
    </script>
			</div>
				
			</div>
			  <div class="col-lg-6 col-xs-12">
                      <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">
    Total Received and Balance Amount of This Month
  </h3>
  <div class"row">
    
    <div class="col-sm-12 text-center">
       <div id="line-chart" style="height:300px;width:100%"></div>
    </div>
     
   
    <script>
        var data = [
      { d: '1', a: <?php echo $newdaterecived1;?>, b: <?php echo $newdatebalance1;?>},
      { d: '2', a: <?php echo $newdaterecived2;?>,  b: <?php echo $newdatebalance2;?>},
      { d: '3', a: <?php echo $newdaterecived3;?>,  b: <?php echo $newdatebalance3;?>},
      { d: '4', a: <?php echo $newdaterecived4;?>,  b: <?php echo $newdatebalance4;?>},
      { d: '5', a: <?php echo $newdaterecived5;?>,  b: <?php echo $newdatebalance5;?>},
      { d: '6', a: <?php echo $newdaterecived6;?>,  b: <?php echo $newdatebalance6;?>},
      { d: '7', a: <?php echo $newdaterecived7;?>, b: <?php echo $newdatebalance7;?>},
      { d: '8', a: <?php echo $newdaterecived8;?>, b: <?php echo $newdatebalance8;?>},
      { d: '9', a: <?php echo $newdaterecived9;?>, b: <?php echo $newdatebalance9;?>},
      { d: '10', a: <?php echo $newdaterecived10;?>, b: <?php echo $newdatebalance10;?>},
      { d: '11', a: <?php echo $newdaterecived11;?>, b: <?php echo $newdatebalance11;?>},
      { d: '12', a: <?php echo $newdaterecived12;?>, b: <?php echo $newdatebalance12;?>},
      { d: '13', a: <?php echo $newdaterecived13;?>,  b: <?php echo $newdatebalance13;?>},
      { d: '14', a: <?php echo $newdaterecived14;?>,  b: <?php echo $newdatebalance14;?>},
      { d: '15', a: <?php echo $newdaterecived15;?>,  b: <?php echo $newdatebalance15;?>},
      { d: '16', a: <?php echo $newdaterecived16;?>,  b: <?php echo $newdatebalance16;?>},
      { d: '17', a: <?php echo $newdaterecived17;?>,  b: <?php echo $newdatebalance17;?>},
      { d: '18', a: <?php echo $newdaterecived18;?>, b: <?php echo $newdatebalance18;?>},
      { d: '19', a: <?php echo $newdaterecived19;?>, b: <?php echo $newdatebalance19;?>},
      { d: '20', a: <?php echo $newdaterecived20;?>, b: <?php echo $newdatebalance20;?>},
      { d: '21', a: <?php echo $newdaterecived21;?>, b: <?php echo $newdatebalance21;?>},
      { d: '22', a: <?php echo $newdaterecived22;?>, b: <?php echo $newdatebalance22;?>},
      { d: '23', a: <?php echo $newdaterecived23;?>, b: <?php echo $newdatebalance23;?>},
      { d: '24', a: <?php echo $newdaterecived24;?>,  b: <?php echo $newdatebalance24;?>},
      { d: '24', a: <?php echo $newdaterecived25;?>,  b: <?php echo $newdatebalance25;?>},
      { d: '26', a: <?php echo $newdaterecived26;?>,  b: <?php echo $newdatebalance26;?>},
      { d: '27', a: <?php echo $newdaterecived27;?>,  b: <?php echo $newdatebalance27;?>},
      { d: '28', a: <?php echo $newdaterecived28;?>,  b: <?php echo $newdatebalance28;?>},
      { d: '29', a: <?php echo $newdaterecived29;?>, b: <?php echo $newdatebalance29;?>},
      { d: '30', a: <?php echo $newdaterecived30;?>, b: <?php echo $newdatebalance30;?>},
      { d: '31', a: <?php echo $newdaterecived31;?>, b: <?php echo $newdatebalance31;?>}
    ],
    config = {
      data: data,
      xkey: 'd',
      ykeys: ['a', 'b'],
      labels: ['Total Recived', 'Total Balance'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['green','red']
  };
 
config.element = 'line-chart';
Morris.Line(config);
 
    </script>
			</div>
			
			 
                    
                    </div>
                    
                     <div  class="col-sm-6 col-xs-12">
        <h3 class="text-primary text-center" style="font-size:25px;font-weight:600;color:#000;">
             Expenses of This Month
        </h3>
      <div id="stacked" ></div>
    </div>
                    
                    <div class="col-lg-6 col-xs-12" style="height: 300px;overflow-y: scroll;">
                        <h4>Today Update Registration</h4>
                        <table class="table">
                            <tbody>
                            <?php
                            foreach ($updatedata as $key => $value) {
                            ?>
                            <tr><td>This UID No <b><?=$value['uid_no'];?></b> has Been Updated By <?=$value['firstname'].' '.$value['lastname'];?> On <?=date('d M H:i:s',strtotime($value['created_date']));?></td></tr>
                            <?php
                            }
                            ?>
                        </tbody></table>
                    </div>
              
 <script> 
        
     var data = [
        { y: 'Site Exp', a: <? if($SiteExp > 0){ echo $SiteExp; } else { echo 0;} ?>},
        { y: 'Corier and Speed Post', a: <? if($CorierandSpeedPost > 0){ echo $CorierandSpeedPost; } else { echo 0;} ?>},
        { y: 'Convence and Transportation', a: <? if($ConvenceandTransportation > 0){ echo $ConvenceandTransportation; } else { echo 0;} ?>},
        { y: 'Survey Exp', a: <? if($SurveyExp > 0){ echo $SurveyExp; } else { echo 0;} ?>},
        { y: 'DD and tendor Exp', a: <? if($DDandtendorExp > 0){ echo $DDandtendorExp; } else { echo 0;} ?>},
        { y: 'Omendra Gupta Current ac', a: <? if($OmendraGuptaCurrentac > 0){ echo $OmendraGuptaCurrentac; } else { echo 0;} ?>},
        { y: 'Office Maintenance', a: <? if($OfficeMaintenance > 0){ echo $OfficeMaintenance; } else { echo 0;} ?>},
        { y: 'Refreshment', a: <? if($Refreshment > 0){ echo $Refreshment; } else { echo 0;} ?>},
        { y: 'stationary', a: <? if($stationary > 0){ echo $stationary; } else { echo 0;} ?>},
        { y: 'Machine and Car Repairing', a: <? if($MachineandCarRepairing > 0){ echo $MachineandCarRepairing; } else { echo 0;} ?>},
        { y: 'Lab Testing Exp', a: <? if($LabTestingExp > 0){ echo $LabTestingExp; } else { echo 0;} ?>},
        { y: 'Audit Expenses', a: <? if($AuditExpenses > 0){ echo $AuditExpenses; } else { echo 0;} ?>},
        { y: 'Telephone/Water/Electricity Exp', a: <? if($TelephoneWaterElectricityExp > 0){ echo $TelephoneWaterElectricityExp; } else { echo 0;} ?>},
        { y: 'Printor and Computer Repairing exp', a: <? if($PrintorandComputerRepairingexp > 0){ echo $PrintorandComputerRepairingexp; } else { echo 0;} ?>},
        { y: 'Printing Exp', a: <? if($PrintingExp > 0){ echo $PrintingExp; } else { echo 0;} ?>},
        { y: 'Cash advance', a: <? if($Cashadvance > 0){ echo $Cashadvance; } else { echo 0;} ?>},
        { y: 'Salary', a: <? if($Salary > 0){ echo $Salary; } else { echo 0;} ?>},
        { y: 'Other Exp', a: <? if($OtherExp > 0){ echo $OtherExp; } else { echo 0;} ?>},

    ],
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Total Expenses'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };
 
 
config.element = 'stacked';
config.stacked = true;
Morris.Bar(config);
 
 </script>
 
        </div>
        <? } ?>
  <!-- /.content-wrapper -->
 </div>
