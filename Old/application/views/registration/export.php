<?php
header('Content-Type: "registration/csv"');
header('Content-Disposition: attachment; filename=clients.csv');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header("Content-Transfer-Encoding: binary");
header('Pragma: public');
?> <?php echo 'UID NO';?>,<?php echo 'Date';?>,<?php echo 'Customer Details';?>,<?php echo 'Mobile No';?>,<?php echo 'Name Of Work';?>,<?php echo 'Sample Details';?>,<?php echo 'Advance Payment';?>,<?php echo 'Payment Dues';?>,<?php echo 'Total Payment';?>,
    <?php
  foreach ($registration as $value)
    {
       $customer_details = '';
        $customer_details = $value['agency_name'];

        $date = date('d/m/Y',strtotime($value['received_date'])); 
	 ?>
                    <?php echo $value['uid_no'];?>,<?php echo $date;?>,<?php echo $customer_details;?>,<?php echo $value['mobile_no'];?>,<?php echo $value['name_of_work'];?>,<?php echo $value['sample_details'];?>,<?php echo $value['advance_payment'];?>,<?php echo $value['balance_dues'];?>,<?php echo $value['total_payment'];?>, 
             <?php 
            }?>
                             