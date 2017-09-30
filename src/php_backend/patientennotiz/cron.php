<?php
include 'db.php';
//delete old times
$rew = mysql_query("UPDATE `termine` SET `old`='1' WHERE `timestamp` < TIMESTAMPADD(DAY,-1,NOW());");

?>
