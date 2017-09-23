<?php



include 'db.php';




$rew_1 = mysql_query("SELECT * FROM `patient_info` WHERE 1");
  $max =  mysql_num_rows ( $rew_1 );
  echo $max;
$bc_data =  ($max+1); //the printer software generated the complete string
$resw = mysql_query("INSERT INTO `patient_db`.`patient_info` (`id`, `station`, `first_name`, `last_name`, `birthday`, `bwm`, `hsm`, `allergene`, `barcodedata`, `creationdate`, `badge_printed`) VALUES (NULL, 'ICP', '".$_POST['Vorname']."', '".$_POST['Nachname']."', '".$_POST['Geburtsdatum']."', '".$_POST['Blutverduenner']."', '".$_POST['Herzschrittmacher']."', '".$_POST['Allergien']."', '".$bc_data."', CURRENT_TIMESTAMP, '0')");
//INSERT INTO `patient_info`(`id`, `station`, `first_name`, `last_name`, `birthday`, `bwm`, `hsm`, `allergene`, `barcodedata`, `creationdate`, `termine`, `badge_printed`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12])Blutverduenner Herzschrittmacher Allergien
echo "ok";
 ?>
