
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 // Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 3600; // 5 minutes in seconds
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

//connect to the database
include "../config.php";
//initialize variables
$email = "";
$password = "";
$errors = array();

//form submission


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <title>Admin Login | LionReads</title>
</head>
<body>
    <form  method="post">
        <h3>Login to your Account</h3>
        <br>
        <h1>Quick and Easy</h1>
    <input class="input" type="email" name="email" placeholder=" Email">
    <input class="input" type="password" name="password" placeholder=" Password"required="required">
    <br>
     <!-- Add the "Forgot Password" link with a unique ID -->
     <a href="#" id="forgot-password-link">Forgot Password</a>
    <br>
    <!-- Container to display the message -->
    <div id="forgot-password-message" style="display: none;">
        So sorry, please remember your password!
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
    
        //form validation
        if (empty($email)) {
            echo "<p class='error'>Email is required</p>";
        }else{

        }
        if (empty($password)) {
            echo "<p class= 'error'>Password is required</p>";
        }else{

        }
    
        //check for errors
        if (!empty($password)) {
            $query = "SELECT * FROM admin WHERE email='$email'";
            $results = mysqli_query($con, $query);
            if(!$results){
                die(mysqli_error($con));
            }
            if (mysqli_num_rows($results) == 1) {
                $user = mysqli_fetch_assoc($results);
                if (password_verify($password, $user['password'])) {
                    //log user in
                    $_SESSION['email'] = $email;

                    // Fetch and store the admin role
                    $admin_role = $user['admin_role'];
                    $_SESSION['admin_role'] = $admin_role; 
                    $_SESSION['success'] = "You are now logged in";
                    header('location: profile.php');
                } else {
                    echo "<p class='error'>Wrong email/password combination</p>";
                }
            }else{
                echo "<p class='error'>No such user exists</p>";
            }
        }
    }
    ?>
    <input class="submit" type="submit" value="login" name="submit">
    </form>


     <!-- JavaScript to display the "Forgot Password" message -->
     <script>
        document.getElementById("forgot-password-link").addEventListener("click", function(e) {
            e.preventDefault();
            // Display the message by setting its style to "block"
            document.getElementById("forgot-password-message").style.display = "block";
        });
    </script>
</body>
</html>
