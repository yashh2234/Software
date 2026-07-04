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
          <form role="form" action="<?php base_url('interlockingtiles/create') ?>" method="post" class="form-horizontal" id="formsubmitn">
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
                          <select class="form-control" id="material_details" name="material_details">
                                        <option value="">Select Details</option>
        			                    <option value="Inter Locking Tile (60mm)">Inter Locking Tile (60mm)</option>
        			                    <option value="Inter Locking Tile (80mm)">Inter Locking Tile (80mm)</option>
        			                    <option value="Inter Locking Tile (100mm)">Inter Locking Tile (100mm)</option>
        			                    <option value="Inter Locking Tile (120mm)">Inter Locking Tile (120mm)</option>
        			                </select>
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
                    			              <input type="text" class="form-control" value="As Per the Prescribed test Method" id="environment_condition" name="environment_condition" placeholder="Enter Environment Condition" />
                    			           </div>
                    			     </div>	<div class="col-xs-12" style="margin: 5px 0px;">
                      <div class="col-xs-4">
                          <p>Dispatch Date</p>
                      </div>
                      <div class="col-xs-8">
                          <input type="text" class="form-control" id="dispatch_date" name="dispatch_date"/>
                       </div>
                    </div>
                    			     <input type="hidden" id="tiles_value" name="tiles_value" value="">
                    			      <input type="hidden" id="tiles_size" name="tiles_size" value="">
			      </div>
			    
			       <div class="row formsection" style="display:none;">
                        <div class="col-xs-12 col-sm-12">
                        <h5 style="padding:8px;border:1px solid #000;color:#000;text-transform: uppercase;text-align:center;">TEST RESULTS : Compressive Strength of Inter locking Tiles as per IS:15658-2021</h5>
                       </div>
                    </div>
			        <div class="row formsection" style="display:none;">
                      
<div class="col-xs-12 col-sm-12">
  <table class="table table-striped">
    			        <tbody>
						<tr>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">S. N</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Shape & Location</th>
    			             <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Size of Tiles</th>
							 <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Date of Testing</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Age of Specimen</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Crushing Load(KN)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Corrected Comp. Strength(N/mm2)</th>
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">Ave. Corrected Comp. Strength(N/mm2)</th>
    			            
    			            <th style="border:1px solid #000;color:#000;text-transform: uppercase;">As per IS Code 28 Days comp. strength(N/mm2)</th>
    			        </tr>
    			         
        			     <tr>
        			            <td>1</td>
        			            <td rowspan="8">
        			                <select class="form-control" id="location" name="location">
        			                    <option value="">Select Shape</option>
        			                    <option value="Inter Locking Tile (60mm)">Inter Locking Tile (60mm)</option>
        			                    <option value="Inter Locking Tile (80mm)">Inter Locking Tile (80mm)</option>
        			                    <option value="Inter Locking Tile (100mm)">Inter Locking Tile (100mm)</option>
        			                    <option value="Inter Locking Tile (120mm)">Inter Locking Tile (120mm)</option>
        			                </select>
        			            </td>
                                <td rowspan="8"><input type="text" class="form-control" id="size" name="size" placeholder = "Size/Area of Tiles"/></td>
                                <td rowspan="8"><input type="text" class="form-control" id="date_of_testing" name="date_of_testing" /></td>
                                <td rowspan="8">
                                    <select class="form-control" id="age_of_specimen" name="age_of_specimen">
        			                    <option value="7 Days">7 Days</option>
        			                    <option value="28 Days">28 Days</option>
        			                    <option value="After 28 Days">After 28 Days</option> 
        			                </select>
                                </td>
                                <td><input type="text" class="form-control" id="crushing_load_1" name="crushing_load_1" placeholder="Crushing Load" onkeyup="calculate_compstrength(1);"/></td>
                                <td><input type="text" class="form-control" id="currected_comp_strength_1" name="currected_comp_strength_1" placeholder="Currected Comp.Strength" /></td>
                                
                                <td rowspan="8"><input type="text" class="form-control" id="avg_comp_strength" name="avg_comp_strength" placeholder="Avg Comp Strength" /></td>
                                <td rowspan="8"><select class="form-control" id="is_code_comp_strength" name="is_code_comp_strength">
        			                    <option value="30/(For M-30)">30/(For M-30)</option>
        			                    <option value="40/(For M-40)">40/(For M-40)</option>
        			                    <option value="50/(For M-50)">50/(For M-50)</option> 
        			                </select>
        			            </td>
        			        </tr>
        			        
        			        <?php for($p=1;$p<8;$p++)
        			        {
        			            $i = $p+1;
        			            ?>
        			         
        			         <tr>
        			            <td><?=$i;?></td>
        			            <td><input type="text" class="form-control" id="crushing_load_<?=$i;?>" name="crushing_load_<?=$i;?>" placeholder="Crushing Load" onkeyup="calculate_compstrength(<?=$i;?>);"/></td>
                                <td><input type="text" class="form-control" id="currected_comp_strength_<?=$i;?>" name="currected_comp_strength_<?=$i;?>" placeholder="Currected Comp.Strength" /></td>
                                 
        			        </tr>
        			        <? } ?>
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
                <a href="<?php echo base_url('interlockingtiles/') ?>" class="btn btn-warning">Back</a>
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
 
    function uidlink_urlno() 
    {
     var uid_no = $('#uid_no').val(); 
     $.ajax({
            url:base_url + 'interlockingtiles/getClientDetails?uid_no='+uid_no,
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
                            // $('#ulr_no').val(response.ulr_no);
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
    $("#material_details").on('input', function () 
    {
        var material_details = this.value;
        $('#location').val(material_details);
        if(material_details == 'Inter Locking Tile (60mm)')
        {
             $('#tiles_value').val('1.06');
             $('#tiles_size').val('60');
        }
        else if(material_details == 'Inter Locking Tile (80mm)')
        {
             $('#tiles_value').val('1.18');
             $('#tiles_size').val('80');
        }
        else if(material_details == 'Inter Locking Tile (100mm)')
        {
             $('#tiles_value').val('1.24');
             $('#tiles_size').val('100');
        }
        else if(material_details == 'Inter Locking Tile (120mm)')
        {
             $('#tiles_value').val('1.34');
             $('#tiles_size').val('120');
        }
        
        
        
    });
    function calculate_compstrength(id)
    {
         var tiles_value = $('#tiles_value').val();
        if(tiles_value == '')
        {
            alert('Select Material Identification Details');
            return false
        }
        var crushing_load = $('#crushing_load_'+id).val();
        var material_details = $('#material_details').val();
        var tiles_size =  $('#tiles_size').val();
        var size = $('#size').val();
        var data = crushing_load/size*1000;
        var strength = data*tiles_value;
       var strength = parseFloat(strength).toFixed(2);
       $('#currected_comp_strength_'+id).val(strength);  
       
       
       var comp1 = $('#currected_comp_strength_1').val(); 
        var comp2 = $('#currected_comp_strength_2').val(); 
        var comp3 = $('#currected_comp_strength_3').val(); 
        var comp4 = $('#currected_comp_strength_4').val(); 
        var comp5 = $('#currected_comp_strength_5').val(); 
        var comp6 = $('#currected_comp_strength_6').val(); 
        var comp7 = $('#currected_comp_strength_7').val(); 
        var comp8 = $('#currected_comp_strength_8').val();
         
        
        var totaladd = Math.abs(comp1)+Math.abs(comp2)+Math.abs(comp3)+Math.abs(comp4)+Math.abs(comp5)+Math.abs(comp6)+Math.abs(comp7)+Math.abs(comp8);
        total = totaladd/8;
        var total = parseFloat(total).toFixed(2);
        $('#avg_comp_strength').val(total);
    }
</script>