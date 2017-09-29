<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'db.php';


//delete old times
$rew = mysqli_query($mysqli,"UPDATE `termine` SET `old`='1' WHERE `timestamp` < TIMESTAMPADD(DAY,-1,NOW());");

$pid = 1; //default patient
if(isset($_GET['pid'])) {
    $pid = $_GET['pid'];
}

  $fetchinfo_dev = mysqli_query($mysqli,"SELECT * FROM `termine` WHERE pid='".$pid."' AND `old`='0' Limit 3");
  $result = "";
  $c = 0;

  $max =  mysqli_num_rows ( $fetchinfo_dev );

  while($row_dev = mysqli_fetch_array($fetchinfo_dev)) {
    $time =explode(' ',$row_dev['timestamp']);
    $sp_time = explode(':',$time[1]);
    $cm_time = $sp_time[0] .":" .$sp_time[1];
if($c < $max-1){
     $result = $result.  $row_dev['activity'] ."_" .$time[0] ."_" .$cm_time ."_" .$row_dev['location'] ."_,";
}else{
  $result = $result.  $row_dev['activity'] ."_" .$time[0] ."_" .$cm_time ."_" .$row_dev['location'] ."_";
}
     $c = $c + 1;
  }
 $result = str_replace('ü', 'ue', $result);
 $result = str_replace('ä', 'ae', $result);
 $result = str_replace('ö', 'oe', $result);

echo $result;

  ?>
