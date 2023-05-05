<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "lionReadz";

//create connection to database

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
if($con){
}else{
    die("Create Database connection");
}
?>