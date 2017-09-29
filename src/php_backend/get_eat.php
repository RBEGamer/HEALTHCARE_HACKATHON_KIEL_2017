<?php
include 'db.php';



//ALLERGENE BITTE
//wenn patient id gegebn dann nach allgerene filtern
//DB ANPASSEN
//to lower

$current_data_abk = date("D");
$fetchinfo_dev = mysqli_query($mysqli,"SELECT * FROM `menu` WHERE `day` = '".$current_data_abk."' Limit 1");
while($row_dev = mysqli_fetch_array($fetchinfo_dev)) {

if(isset($_GET['pid'])){
  //get user allergene
  //ans split it into array
$allginfo = mysqli_query($mysqli,"SELECT * FROM `patient_info` WHERE `id` = '".$_GET['pid']."' LIMIT 1");
$rowuserallg = mysqli_fetch_array($allginfo);

$allarr = strtolower($rowuserallg['allergene']);
$allarr = explode(',', $allarr);

$menalla = strtolower($row_dev['allergene_a']);
$menalla = explode(',', $menalla);

$menallb = strtolower($row_dev['allergene_b']);
$menallb = explode(',', $menallb);

$menallc = strtolower($row_dev['allergene_c']);
$menallc = explode(',', $menallc);


$maok = 1;
$mbok = 1;
$mcok = 1;

//chek ig any menu contains a user allergene
for($i=0; $i < sizeof($allarr); $i++) {
for($ic=0; $ic < sizeof($menallc); $ic++) {
  if ($menallc[$ic] == $allarr[$i]) {
      $mcok = 0;
  }
}
for($ib=0; $ib < sizeof($menallb); $ib++) {
  if ($menallb[$ib] == $allarr[$i]) {
      $mbok = 0;
  }
}
for($ia=0; $ia < sizeof($menalla); $ia++) {
  if ($menalla[$ia] == $allarr[$i]) {
      $maok = 0;
  }
}
}

//create response string
if($maok == 0 && $mbok == 0 && $mcok == 0){
  echo "Es gibt heute keine Menus die mit deinen Allergenen uebereinstimmen. Bitte wende dich an das Klinikpersonal.";
}else{
$res = "Hier ist eine Liste der heutigen Menues. ";
$counter =1;
if($maok > 0){
  $res = $res .$counter ." " . $row_dev['menu_a'] .". ";
  $counter = $counter +1;
}
if($mbok > 0){
  $res = $res .$counter ." " . $row_dev['menu_b'] .". ";
  $counter = $counter +1;
}
if($mcok > 0){
  $res = $res .$counter ." " . $row_dev['menu_c'] .". ";
  $counter = $counter +1;
}
echo $res;
}


}else{
 echo "Hier ist eine Liste der heutigen Menues. Menu 1: ". $row_dev['menu_a'].". Menu 2:".$row_dev['menu_b'] .". Menu 3:" .$row_dev['menu_c'] .". Welches Menu haetten sie gerne ?";
}
break;
}
  ?>
