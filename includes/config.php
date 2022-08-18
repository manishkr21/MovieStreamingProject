<?php

ob_start(); // turns on ouput buffering
session_start(); // means user logged in

date_default_timezone_set("Asia/Kolkata");

try {
    $connection = new PDO("mysql:dbname=mkflix; host=localhost","root","");
    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

}
catch(PDOException $e){
    exit("connection failed: ". $e->getMessage());
}

?>