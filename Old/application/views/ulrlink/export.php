<?php
header('Content-Type: "registration/csv"');
header('Content-Disposition: attachment; filename=ulr.csv');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header("Content-Transfer-Encoding: binary");
header('Pragma: public');
?> <?php echo 'Date';?>,<?php echo 'ULR Number';?>,<?php echo 'UID Number';?>,<?php echo 'Name of Agency';?>,<?php echo 'Name of Work';?>,<?php echo 'Sample Details';?>,
    <?php
  foreach ($ulrlink as $value)
    {
    ?>
    <?php echo $value['date'];?>,<?php echo $value['ulr_no'];?>,<?php echo $value['uid_no'];?>,<?php echo $value['name_of_agency'];?>,<?php echo $value['name_of_project'];?>,<?php echo $value['sample_details'];?>,
    <?php 
    }
    ?> 