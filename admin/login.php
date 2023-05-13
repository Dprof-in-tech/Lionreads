
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

//connect to the database
$db = mysqli_connect("localhost", "root", "", "lionreadz");

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
        <h1>Quick and Easy</h1>
    <input class="input" type="email" name="email" placeholder=" Email">
    <input class="input" type="password" name="password" placeholder=" Password"required="required">
    <?php
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
    
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
            $results = mysqli_query($db, $query);
            if(!$results){
                die(mysqli_error($db));
            }
            if (mysqli_num_rows($results) == 1) {
                $user = mysqli_fetch_assoc($results);
                if (password_verify($password, $user['password'])) {
                    //log user in
                    $_SESSION['email'] = $email;
                    $_SESSION['success'] = "You are now logged in";
                    header('location: admin.php');
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
</body>
</html>
