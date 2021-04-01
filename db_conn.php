<?php

$dbServer = "xxxxxxx";
$dbServerName = "xxxxxxxx";
$password = "xxxxxxx";

$db_name = "xxxxxxxxxxxxxxx";

$connection = mysqli_connect($dbServer, $dbServerName, $password, $db_name);

if(!$connection){
    echo "Connection failed";
}else{
}
?>