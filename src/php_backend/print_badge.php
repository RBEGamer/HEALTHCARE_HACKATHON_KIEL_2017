<?php
include 'db.php';
  $result = "";
  $id = -1;
  $fetchinfo_dev = mysql_query("SELECT * FROM `patient_info` WHERE `badge_printed`='0' Limit 1");
  while($row_dev = mysql_fetch_array($fetchinfo_dev)) {
  	 $result = $result .$row_dev['station']."_".$row_dev['first_name'] ."_" .$row_dev['last_name'] ."_" .$row_dev['birthday'] ."_" .$row_dev['bwm'] ."_" .$row_dev['hsm'] ."_" .$row_dev['allergene'] ."_" .$row_dev['barcodedata'] . "___";
     //$result = str_replace('/', '', $result);
     $id = $row_dev['id'];
     break;
  }
  $fetchinfo_dev_1 = mysql_query("UPDATE `patient_info` SET `badge_printed`='1' WHERE `id`='".$id."'");
  $result = $result ."</select>";
  echo $result;
  ?>
