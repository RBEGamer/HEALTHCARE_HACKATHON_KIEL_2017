<?php

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

include 'db.php';

$use_get = 0;

if($use_get > 0){
  if(!isset($_GET['Vorname']) || !isset($_GET['Nachname'])|| !isset($_GET['Geburtsdatum'])|| !isset($_GET['Blutverduenner'])|| !isset($_GET['Herzschrittmacher'])|| !isset($_GET['Allergien'])){
    echo "err_not_all_get_set";
   exit();
  }
  $Vorname = $_GET['Vorname'];
  $Nachname = $_GET['Nachname'];
  $Geburtsdatum = $_GET['Geburtsdatum'];
  $Blutverduenner = $_GET['Blutverduenner'];
  $Herzschrittmacher = $_GET['Herzschrittmacher'];
  $Allergien = $_GET['Allergien'];
}else{
  if(!isset($_POST['Vorname']) || !isset($_POST['Nachname'])|| !isset($_POST['Geburtsdatum'])|| !isset($_POST['Blutverduenner'])|| !isset($_POST['Herzschrittmacher'])|| !isset($_POST['Allergien'])){
    echo "err_not_all_posts_set";
    exit();
  }
  $Vorname = $_POST['Vorname'];
  $Nachname = $_POST['Nachname'];
  $Geburtsdatum = $_POST['Geburtsdatum'];
  $Blutverduenner = $_POST['Blutverduenner'];
  $Herzschrittmacher = $_POST['Herzschrittmacher'];
  $Allergien = $_POST['Allergien'];
}



$rew_1 = mysqli_query($mysqli,"SELECT * FROM `patient_info` WHERE 1");
  $max =  mysqli_num_rows ( $rew_1 );

//create a hash string
$hash = $Vorname .$Nachname .$Geburtsdatum;
$hash = str_replace('.', '', $hash);
$hash = str_replace('0', '', $hash);
$hash = sha1($hash);

//generate shorter barcode data
$bc_data =  substr($hash, 0, -30) .generateRandomString(5);  //kürze 25zeichen (hash ist 40 lang) + 5 random zeichen
//echo $bc_data;
$resw = mysqli_query($mysqli,"INSERT INTO `patient_db`.`patient_info` (`id`, `station`, `first_name`, `last_name`, `birthday`, `bwm`, `hsm`, `allergene`, `barcodedata`, `creationdate`, `badge_printed`, `img_path`, `hash_sh1`) VALUES (NULL, 'ICP', '".$Vorname."', '".$Nachname."', '".$Geburtsdatum."', '".$Blutverduenner."', '".$Herzschrittmacher."', '".$Allergien."', '".$bc_data."', CURRENT_TIMESTAMP, '0', './images/default.jpg', '".$hash."')");
echo "ok";

 ?>p
