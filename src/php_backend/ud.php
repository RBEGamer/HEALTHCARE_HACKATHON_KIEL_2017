<?php

include 'db.php';
 $pid  = 1;
$fetchinfo_dev = mysqli_query($mysqli,"SELECT * FROM `patient_info` WHERE `shows_on_screen`='1' LIMIT 1");
while($row_dev = mysqli_fetch_array($fetchinfo_dev)) {
   $pid = $row_dev['id'];
   break;
}
$rew_1 = mysqli_query($mysqli,"INSERT INTO `patient_db`.`vital_data` (`id`, `systole`, `diastole`, `puls`, `pid`, `ts`) VALUES (NULL, '".$_POST['Systole']."', '".$_POST['Diastole']."', '".$_POST['Puls']."', '".$pid."', CURRENT_TIMESTAMP);");
echo $pid;
 ?>
