<?php
include 'db.php';
  $fetchinfo_dev = mysql_query("SELECT * FROM `menu` WHERE `day` = 'Thu' Limit 1");
  while($row_dev = mysql_fetch_array($fetchinfo_dev)) {
  	 echo "Hier ist eine Liste der heutigen Menues. Menu 1: ". $row_dev['menu_a'].". Menu 2:".$row_dev['menu_b'] .". Menu 3:" .$row_dev['menu_c'] .". Welches Menu haetten sie gerne ?";
     break;
  }
  ?>
