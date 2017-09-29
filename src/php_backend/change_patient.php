<?php



include 'db.php';


if(isset($_GET['pid'])){
$rew_1 = mysqli_query($mysqli,"UPDATE `patient_info` SET `shows_on_screen`='0' WHERE 1");
$rew_2 = mysqli_query($mysqli,"UPDATE `patient_info` SET `shows_on_screen`='1' WHERE `barcodedata`='".$_GET['pid']."'");
echo "ok";
}
