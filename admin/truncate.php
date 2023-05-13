<?php
if(isset($_GET['truncate-table'])){
    $id = $_GET['truncate-table'];
    include '../db.php';
    $sql = "TRUNCATE TABLE customer_details";
    $result = mysqli_query($con, $sql);
    if($result){
        header('location:transactions.php');
    }
}
?>