<?php

$db_host="localhost"; // Host name
$db_username="root"; // Mysql username
$db_password="root"; // Mysql password
$db_name="patient_db"; // Database name
$verbindung = mysql_connect ($db_host,
$db_username, $db_password)or die ("keine Verbindung möglich. Benutzername oder Passwort sind falsch");
mysql_select_db($db_name)or die ("Die Datenbank existiert nicht.");

?>
