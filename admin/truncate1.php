<?php
if(isset($_GET['truncate-table'])){
    $id = $_GET['truncate-table'];
    include "config.php";
    $sql = "TRUNCATE TABLE books";
    $result = mysqli_query($con, $sql);
    if($result){
        header('location:books.php');
    }
}
?>