<?php
$dbHost = "localhost";
$dbUser = "lionread_admin";
$dbPassword = "admin@lionreads";
$dbName = "lionread_lionreads";

//create connection to database

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
if($con){
}else{
    die("Create Database connection");
}
?>