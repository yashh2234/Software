 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create
      <small>Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Create Report</li>
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
                <h3 class="box-title">Create Report</h3>
            </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('concretecore/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d , h:i a') ?></label>
                </div>
                
<div class="row uidsection">
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>UID No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input list="brow" type="text" class="form-control" id="uid_no" name="uid_no" placeholder="Enter UID No." />
        					     <datalist id="brow">
                                       <?php foreach ($cubes as $k => $v): ?>
                                            <option value="<?php echo $v['uid_no'] ?>"><?php echo $v['uid_no'];?>
                                            </option>
                                            <?php endforeach ?>
                                    </datalist> 
                       </div>
                    </div>
                    
                </div>
                <div class="row formsection" style="display:none;">
                     <div class="col-xs-12" style="margin: 5px 0px;" id="ulrdata">
                      <div class="col-xs-4">
                          <p>ULR No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="ulr_no" name="ulr_no" placeholder="Enter ULR No." />
        			    </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4" >
                          <p>Select Concretecore Sample			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <select class="form-control" id="concretecore_sample" name="concretecore_sample">
                              <option value="">Select Sample</option>
                              <option value="Concretecore (01 Set)">Concretecore (01 Set)</option>
                              <option value="Concretecore (02 Set)">Concretecore (02 Set)</option>
                              <option value="Concretecore (03 Set)">Concretecore (03 Set)</option>
                              <option value="Concretecore (04 Set)">Concretecore (04 Set)</option>
                              <option value="Concretecore (05 Set)">Concretecore (05 Set)</option> 
                              <option value="Concretecore (06 Set)">Concretecore (06 Set)</option>
                              <option value="Concretecore (07 Set)">Concretecore (07 Set)</option>
                              <option value="Concretecore (08 Set)">Concretecore (08 Set)</option>
                              <option value="Concretecore (09 Set)">Concretecore (09 Set)</option>
                              <option value="Concretecore (10 Set)">Concretecore (10 Set)</option>
                          </select>
                        </div>
                    </div>
                     <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name & Address of Costumer</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="customer_details" name="customer_details" placeholder="Enter Customer Name & Address" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name of Agency</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="agency_name" name="agency_name" placeholder="Enter Agency Name" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Reference No.</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Enter Reference Number" />
                       </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4" >
                          <p>Material Identification Details			
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="material_details" placeholder = "Material Identification Details" name="material_details" value="">
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Name Of Work 			
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="source_location" name="source_location" placeholder="Enter Name Of Work" />
                       </div>
                    </div>			  
                    
                     		  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Work order No.			
                    
                    
                    .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="work_order_no" name="work_order_no" placeholder="Enter Work Order No" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Receipt</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_date" name="sample_date" />
                       </div>
                    </div>			  
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Date of Sample Tested			
                        .</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="sample_tested_date" name="sample_tested_date"/>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Sampled by /Condition of Sample </p>
                      </div>
                      <div class="col-xs-8">
                         <select class="form-control" id="sampled_by" name="sampled_by">
                            <option value="Sample Supplied By Customer">Sample Supplied By Customer</option>
                            <option value="Sample Collected By Ncs" >Sample Collected By Ncs</option>
                        </select>
                       </div>
                    </div>		   
                    <div class="col-xs-12" style="margin: 5px 0px;">
                    			          <div class="col-xs-4">
                    			              <p>Environment Condition			
                    			
                    
                    			
                    .</p>
                    			          </div>
                    			          <div class="col-xs-8">
                    			              <input type="text" class="form-control" id="environment_condition" value="As Per the Prescribed test Method" name="environment_condition" placeholder="Enter Environment Condition" />
                    			           </div>
                    			     </div>	<div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Dispatch Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="dispatch_date" name="dispatch_date"/>
                       </div>
                    </div>			
			      </div>
			    
			     <div class="row formsection" style="display:none;">
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS (As per IS : 516-1959 Reaf 2018)</h5>
                       </div>
                    </div>
			        <div class="row formsection" style="display:none;">
                      
<div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Core. N</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Ht. of Core Before Facing (mm)</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Dimension Of Core After Facing
    <table class="table table-striped"><tr><td style="border:1px solid #000;color:#000;text-transform: uppercase;">Dia(mm)</td><td style="border:1px solid #000;color:#000;text-transform: uppercase;">Height(mm)</td></tr></table>
</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Cross Sectional Area mm2</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Correction Factor</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Age Of Specimen</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Crushing Load In KN</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Measured Comp. Strength</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Corrected Comp. Strength</th>
<th style="border:1px solid #000;color:#000;text-transform: uppercase;">Equivalent Cube Strength</th>
    			        </tr>
        			     <?php for($j=0;$j<10;$j++){ 
    			          $i = $j+1;
    			         ?>
        			     <tr class="set_<?=$i;?>" style="display:none;">
        			            <td><?=$i;?></td>
        			            <td><input type="text" class="form-control" id="ht_core_before_facing_<?=$i;?>" name="ht_core_before_facing_<?=$i;?>" placeholder="HT Core Before Facing"/></td>
        			            <td><table><tr>
        			            <td><input type="text" class="form-control" onkeyup="calculate_sectionalarea(<?=$i;?>);" id="dimension_core_facing_dia_<?=$i;?>" name="dimension_core_facing_dia_<?=$i;?>" placeholder="Enter Dia" /></td>
        			            <td><input type="text" class="form-control" onkeyup="calculate_fector(<?=$i;?>);" id="dimension_core_facing_height_<?=$i;?>" name="dimension_core_facing_height_<?=$i;?>" placeholder="Enter Height" /></td>
        			            </tr></table></td>
        			            <td><input type="text" class="form-control" id="core_sectional_area_<?=$i;?>" name="core_sectional_area_<?=$i;?>"  placeholder="Core Sectional Area"/></td>
        			            <td><input type="text" class="form-control" id="correction_factor_<?=$i;?>" name="correction_factor_<?=$i;?>" placeholder="Correction Factor" /></td>
        			            <td>
        			                <select class="form-control" id="age_of_specimen_<?=$i;?>" name="age_of_specimen_<?=$i;?>">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 Days">After 28 days</option> 
        			                </select>
        			            </td>
        			            <td><input type="text" class="form-control" id="crushing_load_<?=$i;?>" onkeyup="measeuredcomp_strength(<?=$i;?>);" name="crushing_load_<?=$i;?>"  placeholder = "Crushing Load"/></td>
        			            <td><input type="text" class="form-control" id="measured_comp_strength_<?=$i;?>" name="measured_comp_strength_<?=$i;?>" placeholder="Measured Comp Strength" /></td>
        			            <td><input type="text" class="form-control" id="corrected_comp_strength_<?=$i;?>" name="corrected_comp_strength_<?=$i;?>" placeholder="Corrected Comp Strength" /></td>
        			            <td><input type="text" class="form-control" id="equivalent_cube_strength_<?=$i;?>" name="equivalent_cube_strength_<?=$i;?>" placeholder="Equivalent Cube Strength" /></td>
        			        </tr>
        			       <? } ?>
        			          <input type="hidden" value="10" id="countset" name="countset">
    			        </tbody>
						</table>
			        </div>
			        

			     <div style="clear:both"></div>
	       </div>
                
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 
              <button type="button" onclick="formsubmit();" class="btn btn-primary formsection" style="display:none;">Create Report</button>
                <button type="button" onclick="uidlink_urlno();" class="btn btn-primary uidsectionbutton">Get Details</button> 
                <a href="<?php echo base_url('concretecore/') ?>" class="btn btn-warning">Back</a>
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
 $("#concretecore_sample").on('input', function () 
    {
        var val = this.value;
        if(val == 'Concretecore (01 Set)')
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
           $('#countset').val('1');
        }
        if(val == 'Concretecore (02 Set)')
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
           $('#countset').val('2');
        }if(val == 'Concretecore (03 Set)')
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
           $('#countset').val('3');
        }if(val == 'Concretecore (04 Set)')
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
           $('#countset').val('4');
        }if(val == 'Concretecore (05 Set)')
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
           $('#countset').val('5');
        }if(val == 'Concretecore (06 Set)')
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
           $('#countset').val('6');
        }if(val == 'Concretecore (07 Set)')
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
           $('#countset').val('7');
        }if(val == 'Concretecore (08 Set)')
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
           $('#countset').val('8');
        }if(val == 'Concretecore (09 Set)')
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
           $('#countset').val('9');
        }if(val == 'Concretecore (10 Set)')
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
           $('#countset').val('10');
        }
        
    })
    
    
    function uidlink_urlno() 
    {
     var uid_no = $('#uid_no').val(); 
     $.ajax({
            url:base_url + 'concretecore/getClientDetails?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                   if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                        '</div>');
            
                            $('.uidsectionbutton').css('display','none');
                            $('.formsection').css('display','block');
                            
                             //$('#ulr_no').val(response.ulr_no);
                             $('#customer_details').val(response.reporting_address);
                            $('#agency_name').val(response.agency_name);
            $('#source_location').val(response.name_of_work);
                            $('#work_order_no').val(response.work_order_no);
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
         $.ajax({
            url:base_url + 'ulrlink/getulrbyuid?uid_no='+uid_no,
            type: 'post',
            dataType: 'json',
                success:function(response) 
                {
                    $('#ulrdata').html(response); 
                     
                       
                }
                });
    } 
    
    function  calculate_sectionalarea(id)
    {
        
        var dia = $('#dimension_core_facing_dia_'+id).val();
          if(dia == '')
        {
            alert('Enter Dia');
        }
        var data = 3.1429/4*dia; 
        var sectionalarea = data*dia;
        var strength = parseFloat(sectionalarea).toFixed(2);
        $('#core_sectional_area_'+id).val(strength);

    }
    
    
    function calculate_fector(id)
    {
        
        var dia = $('#dimension_core_facing_dia_'+id).val();
          var heigth = $('#dimension_core_facing_height_'+id).val();
          if(dia == '')
        {
            alert('Enter Dia');
        }
         
        if(heigth == '')
        {
            alert('Enter Heigth');
        }
       var data = heigth/dia*0.11;
      var  fector = data+0.78;
         var strength = parseFloat(fector).toFixed(3);
         $('#correction_factor_'+id).val(strength);
    }
    function measeuredcomp_strength(id)
    {
        var crushing_load = $('#crushing_load_'+id).val();
        var core_sectional_area = $('#core_sectional_area_'+id).val();
        var correction_factor = $('#correction_factor_'+id).val();
        var data = crushing_load*1000/core_sectional_area;
        var measured_comp_strength = parseFloat(data).toFixed(2);
        $('#measured_comp_strength_'+id).val(measured_comp_strength);
        
        var corrected_comp_strength = measured_comp_strength*correction_factor;
        var corrected_comp_strength = parseFloat(corrected_comp_strength).toFixed(2);
        $('#corrected_comp_strength_'+id).val(corrected_comp_strength);
        
        var equivalent_cube_strength = corrected_comp_strength*1.25;
        var equivalent_cube_strength = parseFloat(equivalent_cube_strength).toFixed(2);
        $('#equivalent_cube_strength_'+id).val(equivalent_cube_strength);
    }
     
</script>