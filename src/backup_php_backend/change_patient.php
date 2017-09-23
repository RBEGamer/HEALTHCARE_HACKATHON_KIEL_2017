<?php



include 'db.php';


if(isset($_GET['pid'])){
$rew_1 = mysql_query("UPDATE `patient_info` SET `shows_on_screen`='0' WHERE 1");
echo "yeah";
$rew_2 = mysql_query("UPDATE `patient_info` SET `shows_on_screen`='1' WHERE `barcodedata`='".$_GET['pid']."'");
}
