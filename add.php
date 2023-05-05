<?php

if (isset($_POST['submit'])){
    require "db.php";
    $bookTitle = $_POST['book_title'];
    $bookAuthor = $_POST['book_author'];
    $bookPrice = $_POST['book_price'];
    $bookImage= $_POST['book_image'];
    
    $sql ="INSERT INTO books (book_title, book_image, book_author, book_price) VALUES ('$bookTitle', '$bookImage', '$bookAuthor', '$bookPrice')";

    ///perform query
    $result = mysqli_query($con, $sql);
    if ($result) {
        $con->close();
    }else{
        echo "Error: ";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="add.css">
    <link rel="stylesheet" href="bookshop.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "sidepanel.php";?>

    <div class="addbook">
    <h3> Add New Book</h3>
    <form action="" method="post">
        <label for="book_title">Book Title</label>
        <input type="text" name="book_title" >
        <label for="book_price"> Book Price</label>
        <input type="text" name="book_price">
        <label for="book_author"> Author</label>
        <input type="text" name="book_author">
        <label for="book_image"> Image</label>
        <input type="file" name="book_image" class="book_image" >
        <input type="submit" value="Add Book" name="submit" class="add_button">
    </form>
    </div>
    
    <script>    
        /* Set the width of the sidebar to 250px (show it) */
    function openNav() {
        document.getElementById("mySidepanel").style.width = "75%";
    }
    /* Set the width of the sidebar to 0 (hide it) */
    function closeNav() {
        document.getElementById("mySidepanel").style.width = "0";
    }
    </script>
</body>
</html>