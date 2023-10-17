<?php
 // Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 2300; // 5 minutes in seconds
 session_set_cookie_params($sessionLifetime);
  
  // start the session
  session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    include "../config.php";
    $bookTitle = $_POST['book_title'];
    $book_price = $_POST['book_price'];
    
          // File move successful, insert the data into the database
   $sql = "UPDATE books SET book_price = ? WHERE book_title = ?";

    ///perform query
    $stmt = $con->prepare($sql);
$stmt->bind_param("is", $book_price, $bookTitle);

$book_price = $_POST['book_price'];
$bookTitle = $_POST['book_title'];

if ($stmt->execute()) {
    $con->close();
} else {
    echo "Error: " . $stmt->error;
}


}

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
    <title>Lionreads Bookshop | Update Book Price</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "adminSidepanel.php";?>

    <div class="addbook">
    <h3> Update Book Price</h3>
    <form action="" method="post"  enctype="multipart/form-data">
        <label for="book_title">Book Title</label>
        <input type="text" name="book_title" >
        <label for="book_price">New Book Price</label>
        <input type="text" name="book_price">
        <input type="submit" value="Update" name="submit" class="add_button">
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