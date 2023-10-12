<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 3600; // 30 minutes in seconds
session_set_cookie_params($sessionLifetime);
// Start the session
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

if (isset($_POST['submit'])) {
    include "../config.php";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $admin_role = $_POST['admin_role'];
    $password = $_POST['password'];
    $profile_picture = $_POST['picture'];
    $confirmpassword = $_POST['confirmpassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $bookImage = $_FILES['picture']['tmp_name'];
    $imageFileName = $_FILES['picture']['name'];
    $imageDestination = '../img/' . $imageFileName;

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($bookImage, $imageDestination)) {
        // File move successful, insert the data into the database

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM admin WHERE email = '$email'";
        $checkEmailResult = mysqli_query($con, $checkEmailQuery);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            echo '<p class="error">This email is already registered. Please Login!!</p>';
        } elseif ($password == $confirmpassword) {
            // Insert the data into the database
            $insertQuery = "INSERT INTO admin(full_name, email, password, admin_role, phone_number, profile_picture ) VALUES ('$name', '$email', '$hashed_password', '$admin_role', '$phone_number', '$imageFileName')";
            $result = mysqli_query($con, $insertQuery);

            if ($result) {
                header('location:register.php');
            } else {
                echo '<p class="error">Error: ' . mysqli_error($con) . '</p>';
            }
        }

        // Close the database connection
        mysqli_close($con);
    } else {
        echo '<p class="error">File upload failed.</p>';
    }
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
        <br>
        <h1>Just for Admins!!</h1>
        <input class="input" type="email" name="email" placeholder="Your Email" autocomplete="off">
        <?php
        if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo '<p class="error">Invalid email</p>';
        }
        ?>
        <input class="input" type="text" name="name" placeholder="Full Name" required="required">
        <input class="input" type="text" name="phone_number" placeholder="Phone Number" autocomplete="off">
        <input class="input" type="password" name="password" placeholder="Password" autocomplete="off" required="required">
        <input class="input" type="password" name="confirmpassword" placeholder="Confirm Password" autocomplete="off" required="required">
        <div class="container">
            <select id="admin_role" name="admin_role">
                <option value="" disabled selected>Select Admin role</option>
                <option value="super-Management">Super Management</option>
                <option value="location-Head">Location Head</option>
                <option value="distributor">Distributor</option>
                <option value="finance">Finance</option>
            </select>
            <input type="file" name="picture" id="Picture" class="picture" value="Upload picture">
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            if ($password != $confirmpassword) {
                echo '<p class="error">Passwords dont match!! Please try again.</p>';
            }
        }
        ?>
        <input class="submit" type="submit" value="Submit" name="submit">
    </form>
</body>
</html>
