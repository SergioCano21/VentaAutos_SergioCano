<?php

$db_host = 'localhost';
$db_username = 'sysAdmin';
$db_password = "Chimo2021";
$db_database = "ventaautos";

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('No es posible conectarse a la base de datos ['. $db->connect_error .']');
}
