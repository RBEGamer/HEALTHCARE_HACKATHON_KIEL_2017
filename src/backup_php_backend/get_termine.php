<?php
include 'db.php';


//delete old times
$rew = mysql_query("UPDATE `termine` SET `old`='1' WHERE `timestamp` < TIMESTAMPADD(DAY,-1,NOW());");

$pid = 1; //default patient
if(isset($_GET['pid'])) {
    $pid = $_GET['pid'];
}
  $fetchinfo_dev = mysql_query("SELECT * FROM `termine` WHERE pid='".$pid."' AND `old`='0' Limit 3");
  $result = "";
  $c = 0;

  $max =  mysql_num_rows ( $fetchinfo_dev );

  while($row_dev = mysql_fetch_array($fetchinfo_dev)) {
    $time =split(' ',$row_dev['timestamp']);
    $sp_time = split(':',$time[1]);
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
//if($c == 1){
//  echo "Du hast heute einen Termin : " .$result;
//}else if($c <= 0){/
//    echo "Du hast heute keine Termine, hurra!!!111Elf";
//}else{
//    echo "Du hast heute " .$c ." Termine : " .$result;
//}
  ?>
