<?php
// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 2300; // 30 minutes in seconds
session_set_cookie_params($sessionLifetime);
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

// Connect to the database
include "../config.php";

// Initialize variables
$email = "";
$password = "";
$errors = array();

// Form submission
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Form validation
    if (empty($email) || empty($password)) {
        echo "<p class='error'>Email and Password are required</p>";
    } else {
        // Check for errors
        $query = "SELECT * FROM admin WHERE email='$email'";
        $results = mysqli_query($con, $query);

        if (!$results) {
            die(mysqli_error($con));
        }

        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);
            if (password_verify($password, $user['password'])) {
                // Log user in
                $_SESSION['email'] = $email;

                // Fetch and store the admin role
                $admin_role = $user['admin_role'];
                $_SESSION['admin_role'] = $admin_role;
                $_SESSION['success'] = "You are now logged in";
                header('Location: profile.php');
                exit(); // Ensure nothing else is sent to the browser
            } else {
                echo "<p class='error'>Wrong email/password combination</p>";
            }
        } else {
            echo "<p class='error'>No such user exists</p>";
        }
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
    <link rel="shortcut icon" href="../img/Lionreads-logo-1.png" type="image/x-icon">
    <title>Admin Login | LionReads</title>
</head>
<body>
    <form method="post">
        <h3>Login to your Account</h3>
        <br>
        <h1>Quick and Easy</h1>
        <input class="input" type="email" name="email" placeholder=" Email">
        <input class="input" type="password" name="password" placeholder=" Password" required="required">
        <br>
        <!-- Add the "Forgot Password" link with a unique ID -->
        <a href="#" id="forgot-password-link">Forgot Password</a>
        <br>
        <!-- Container to display the message -->
        <div id="forgot-password-message" style="display: none;">
            So sorry, please remember your password!
        </div>
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
