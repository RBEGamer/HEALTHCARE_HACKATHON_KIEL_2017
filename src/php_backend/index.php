<html>

<head>
<meta http-equiv="refresh" content="1" >
<script src='canvasjs.min.js'></script>

<script type='text/javascript'>
window.onload=function(){
  var BPM_DATA = new CanvasJS.Chart('BPM_DATA_CONT', {title:{text:'HEARTRATE'},axisX:{interval: 1},data:[{type: 'line',xValueType:'none',dataPoints:[


    <?php
    include 'db.php';

    $pid  = 1;
   $fetchinfo_dev2 = mysql_query("SELECT * FROM `patient_info` WHERE `shows_on_screen`='1' LIMIT 1");
   while($row_dev2 = mysql_fetch_array($fetchinfo_dev2)) {
      $pid = $row_dev2['id'];
      break;
   }
     $c = 1;
     $bla = "";
    $fetchinfo_dev1 = mysql_query("SELECT * FROM `vital_data` WHERE `pid`='".$pid."' LIMIT 25");
    while($row_dev1 = mysql_fetch_array($fetchinfo_dev1)) {
       $bla = $bla ."{x:".$c.",y:".$row_dev1['puls']."},";
       $c = $c+ 1;
    }
    echo $bla ."]}]});";
    ?>


    BPM_DATA.render();}

    </script>
</head>

<body>
  <center>
<h1>Digitales Patienten Informations-System</h1>


<table width='40%'>
  <?php
  include 'db.php';
   $pid  = -1;
  $fetchinfo_dev1 = mysql_query("SELECT * FROM `patient_info` WHERE `shows_on_screen`='1' LIMIT 1");
  while($row_dev1 = mysql_fetch_array($fetchinfo_dev1)) {
    $pid  = $row_dev1['id'];

     echo "<tr><td><br></td><td><img src='".$row_dev1['img_path']."' width='60%'></td></tr>";
     echo "<tr><td><br></td></td><br><td><br><td></tr>";
echo "<tr><td><br></td><td></td><td><b>Name:<td>".$row_dev1['first_name']."<td></tr>";
echo "<tr><td><br></td><td><b>Vorname:<td>".$row_dev1['last_name']."<td></tr>";
echo "<tr><td><br></td><td><b>Geburtsdatum:<td>".$row_dev1['birthday']."<td></tr>";
echo "<tr><td><br></td><td><b>Blutverduen. Med.:<td>".$row_dev1['bwm']."<td></tr>";
echo "<tr><td><br></td><td><b>Herzschrittmacher:<td>".$row_dev1['hsm']."<td></tr>";
echo "<tr><td><br></td><td><b>Allergien:<td>".$row_dev1['allergene']."<td></tr>";
break;
}

if($pid < 0){
  echo "<tr><td><br></td><td><img src='default.jpg' width='60%'></td></tr>";
  echo "<tr><td><br></td></td><br><td><br><td></tr>";
  echo "<tr><td><br></td><td></td><td><b>Name:<td>no data<td></tr>";
  echo "<tr><td><br></td><td><b>Vorname:<td>no data<td></tr>";
  echo "<tr><td><br></td><td><b>Geburtsdatum:<td>no data<td></tr>";
  echo "<tr><td><br></td><td><b>Blutverduen. Med.:<td>no data<td></tr>";
  echo "<tr><td><br></td><td><b>Herzschrittmacher:<td>no data<td></tr>";
  echo "<tr><td><br></td><td><b>Allergien:<td>no data<td></tr>";
}
?>
<tr><td><br></td><td><br></td><br><td><br><td></tr>
  <tr><td><div id='BPM_DATA_CONT' style='height: 200px; width: 500%;position: relative;left: -100%;'></td></tr>

<tr><td><br></td><br><td><br><td></tr>

<tr><th widht='20%'>TIMESTAMP</th><th>systolisch</th><th>diastolisch</th><th>BPM</th></tr>


<?php
include 'db.php';
 $pid  = 1;
$fetchinfo_dev1 = mysql_query("SELECT * FROM `patient_info` WHERE `shows_on_screen`='1' LIMIT 1");
while($row_dev1 = mysql_fetch_array($fetchinfo_dev1)) {
   $pid = $row_dev1['id'];
   break;
}
$res = "";
$fetchinfo_dev = mysql_query("SELECT * FROM `vital_data` WHERE `pid` = '".$pid ."' LIMIT 25");
while($row_dev = mysql_fetch_array($fetchinfo_dev)) {
   $res = $res ."<tr><td>".$row_dev['ts'] ."</td><td>" .$row_dev['systole'] ."</td><td>" .$row_dev['diastole'] ."</td><td>" .$row_dev['puls'] . "</td></tr>";
}
echo $res;
?>

</table>


</center>
</bod<>
</html>
