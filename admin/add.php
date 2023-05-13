<?php
 // Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 300; // 5 minutes in seconds
 session_set_cookie_params($sessionLifetime);
  // start the session
  session_start();
  
  
 // Check if the session expiration time is set
 if (isset($_SESSION['expire_time'])) {
   // Check if the session has expired
   if (time() > $_SESSION['expire_time']) {
       // Redirect to logout.php
       header("Location: logout.php");
       exit();
   }
 }
 
 // Set the new expiration time
 $_SESSION['expire_time'] = time() + $sessionLifetime;
 

if (isset($_POST['submit'])){
    require "../db.php";
    $bookTitle = $_POST['book_title'];
    $bookAuthor = $_POST['book_author'];
    $bookPrice = $_POST['book_price'];
    
      // Handle file upload
      $bookImage = $_FILES['book_image']['tmp_name'];
      $imageFileName = $_FILES['book_image']['name'];
      $imageDestination = '../img/' . $imageFileName;
      
      // Move the uploaded file to the destination folder
      if (move_uploaded_file($bookImage, $imageDestination)) {
          // File move successful, insert the data into the database
    $sql ="INSERT INTO books (book_title, book_image, book_author, book_price) VALUES ('$bookTitle', '$imageFileName', '$bookAuthor', '$bookPrice')";

    ///perform query
    $result = mysqli_query($con, $sql);
    if ($result) {
        $con->close();
    }else{
        echo "Error: ";
    }

}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="add.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "adminSidepanel.php";?>

    <div class="addbook">
    <h3> Add New Book</h3>
    <form action="" method="post"  enctype="multipart/form-data">
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