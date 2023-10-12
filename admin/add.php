<?php
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

// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 2300; // 30 minutes in seconds

// Database connection code - replace with your actual database connection code
include "../config.php";


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
    <style>
        #message-container {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 999;
        }
    </style>
</head>
<body>
    <!-- include navbar -->
    <?php include "adminSidepanel.php";?>

    <div class="addbook">
    <h3> Add New Book</h3>
    <form action="" method="post"  enctype="multipart/form-data">
        <label for="book_title">Book Title</label>
        <input type="text" name="book_title" autocomplete="off">
        <label for="book_price"> Book Price</label>
        <input type="text" name="book_price" autocomplete="off">
        <label for="book_quantity"> Book Quantity</label>
        <input type="text" name="book_quantity" autocomplete="off">
        <label for="book_author"> Author</label>
        <input type="text" name="book_author" autocomplete="off">
        <!--<label for="book_image"> Image</label>
        <input type="file" name="book_image" class="book_image" >-->
        <label for="camera_image">Book Image</label>
        <input type="file" name="camera_image" accept="image/*;capture=camera">
        <input type="submit" value="Add Book" name="submit" class="add_button">
    </form>
    </div>
 
    <div id="message-container" style="display: none;">
        <div id="message"><?php echo $message;?></div>
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


<?php
     $message = "Book added successfully";
    if (isset($_POST['submit'])) {
        $bookTitle = mysqli_real_escape_string($con, $_POST['book_title']);
        $bookAuthor = mysqli_real_escape_string($con, $_POST['book_author']);
        $bookPrice = mysqli_real_escape_string($con, $_POST['book_price']);
        $book_quantity = mysqli_real_escape_string($con, $_POST['book_quantity']);
    
        // Handle file upload
        $imageFileName = '';
        if (isset($_FILES['camera_image']['tmp_name']) && !empty($_FILES['camera_image']['tmp_name'])) {
            $bookImage = $_FILES['camera_image']['tmp_name'];
            $imageFileName = $_FILES['camera_image']['name'];
            $imageDestination = '../img/' . $imageFileName;
    
            // Move the camera-captured image to the destination folder
            if (move_uploaded_file($bookImage, $imageDestination)) {
                // File move successful, insert the data into the database using prepared statement
                $stmt = $con->prepare("INSERT INTO books (book_title, book_image, book_author, book_price, book_quantity) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $bookTitle, $imageFileName, $bookAuthor, $bookPrice, $book_quantity);
    
                if ($stmt->execute()) {
                    // Successfully inserted into the database
                    $stmt->close();
                    $con->close();
    
                      // Book successfully added to cart, trigger an alert
                    echo '<script>
                    function showMessage(message) {
                        const messageContainer = document.getElementById("message-container");
                        const messageElement = document.getElementById("message");
                        messageElement.textContent = message;
    
                        messageContainer.style.display = "block";
    
                        setTimeout(function() {
                            messageContainer.style.display = "none";
                        }, 3000); // Hide the message after 3 seconds
                    }
    
                    // Call this function to display the message
                    showMessage("' . $message . '");
                    </script>';
                
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        }
    }
?>
</body>
</html>