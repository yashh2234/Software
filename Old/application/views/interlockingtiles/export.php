<?php

header('Content-Type: "text/csv"');
header('Content-Disposition: attachment; filename=clients.csv');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header("Content-Transfer-Encoding: binary");
header('Pragma: public');

?>
            <?php echo 'GR No';?>,<?php echo 'Date';?>,<?php echo 'Consignor Name';?>,<?php echo 'Consignor Gst';?>,<?php echo 'Consignee Name';?>,<?php echo 'Consignee Gst';?>,<?php echo 'Vehicles Number';?>,<?php echo 'Vehicle Size';?>,<?php echo 'Goods Qty';?>,<?php echo 'Driver Name';?>,<?php echo 'Driver Number';?>,<?php echo 'Loading';?>,<?php echo 'Unloading';?>,<?php echo 'Net Amount';?>,<?php echo 'Freight';?>,<?php echo 'Order Stauts';?>
                          
                          <?php
                          foreach ($orders as $value)
                            {
                                
                                $date = date('d-m-Y', $value['date_time']);
                                $time = date('h:i a', $value['date_time']);
                                
                                $date_time = $date . ' ' . $time;
                                
                                if($value['paid_status'] == 1) {
                                $paid_status = 'Freight Paid';	
                                }
                                else if($value['paid_status'] == 2){
                                $paid_status = 'To Pay Delivery Point';
                                }
                                else
                                {
                                $paid_status = 'Freight Pending';
                                }
             
                                 
                    		 ?>
        <?php echo $value['id'];?>,<?php echo $date_time;?>,<?php echo $value['consignor_name'];?>,,<?php echo $value['consignor_gst'];?>,<?php echo $value['consignee_name'];?>,,<?php echo $value['consignee_gst'];?>,<?php echo $value['vehicle'];?>,<?php echo $value['vehicle_size'];?>,<?php echo $value['qty'];?><?php echo $value['driver'];?>,<?php echo $value['driver_mobile'];?>, <?php echo $value['loading'];?>,<?php echo $value['unloading'];?>,<?php echo $value['net_amount'];?>,<?php echo $paid_status;?> 
                                <?php 
                            }?>
                            
                             