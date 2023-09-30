<?php
$dbHost = "sql311.infinityfree.com";
$dbUser = "if0_34904562";
$dbPassword = "2bkiU8B0pp2s";
$dbName = "if0_34904562_lionreads";

//create connection to database

$con = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
if($con){
}else{
    die("Create Database connection");
}
?>