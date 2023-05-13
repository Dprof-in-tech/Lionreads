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
 
if(isset($_POST['submit'])){
    require "../db.php";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $profile_picture = $_POST['picture'];
    $confirmpassword = $_POST['confirmpassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);    

    // Handle file upload
    $bookImage = $_FILES['picture']['tmp_name'];
    $imageFileName = $_FILES['picture']['name'];
    $imageDestination = '../img/' . $imageFileName;
    
    // Move the uploaded file to the destination folder
    if (move_uploaded_file($bookImage, $imageDestination)) {}
        // File move successful, insert the data into the database
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <title> Add Admin | LionReads</title>
</head>
<body>
    <form  method="post"  enctype="multipart/form-data">
        <h2>Add an Admin</h2>
        <h1>Just for Admins!!</h1>
    <input class="input" type="email" name="email" placeholder="Your Email" autocomplete="off">
    <?php
    if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      echo '<p class="error">Invalid email</p>';
    }
  ?>
    <input class="input" type="text" name="name" placeholder="Full Name" required= 'required'>
    <input class="input" type="text" name="phone_number" placeholder="Phone Number" autocomplete="off">
    <input class="input" type="password" name="password" placeholder="Password" autocomplete="off" required="required">
    <input class="input" type="password" name="confirmpassword" placeholder="Confirm Password" autocomplete="off" required="required">
    <label for="picture">Upload a Picture</label>
    <input type="file" name="picture" id="Picture" class="picture">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $password = $_POST['password'];
      $confirmpassword = $_POST['confirmpassword'];

      if ($password != $confirmpassword) {
        echo '<p class="error">Passwords dont match!! Please try again.</p>';
      } else {

        // continue with the rest of the form processing
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=lionreadz', 'root', '');
        // Prepare a SQL statement to check if the email already exists in the database
        $stmt= $db->prepare('SELECT * FROM admin WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        // Execute the SQL statement
        $stmt->execute();
        // If a record is found, display an error message
        if ($stmt->rowCount() > 0) {
          echo '<p class="error">This email is already registered. Please Login!!</p>';
        } elseif ($password == $confirmpassword) {
          $sql = "INSERT INTO admin(full_name, email, password, phone_number, profile_picture ) VALUES ('$name', '$email', '$hashed_password', '$phone_number', '$imageFileName')";
          $result = mysqli_query($con, $sql);

          if ($result) {
            header('location:login.php');
          }else{

          }
        }

      }
     
    }
?>
    <input class="submit" type="submit" value="Submit" name="submit">
    <h5>You have an account with us,<a href="login.php">Login</a></h5>
    <h5>By Clicking submit, you consent to our company and customer's <a href="">Privacy Policies</a></h5>
    </form>
</body>
</html>