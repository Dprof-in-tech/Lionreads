<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the session timeout to 5 minutes
ini_set('session.gc_maxlifetime', 2300);
session_set_cookie_params(2300);

// Start the session
session_start();

// Regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// Set the last activity time to the current time
$_SESSION['last_activity'] = time();

// Debugging Step 2: Check for session timeout.
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 2300)) {
    // Session timed out, destroy the session
    session_unset();
    session_destroy();
    header("location: home.php");
}

// Update the last activity time
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <title>LionReads Bookshop | Get your Books quick and Easy</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: whitesmoke;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .verify-order{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .verify-order form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        label{
            align-self: flex-start;
            padding-left: 30px;
            margin-bottom: 0.2rem;
            font-family: 'JetBrains Mono', sans-serif;
        }
        .verify{
            height: 2rem;
            width: 85%;
            border-radius: 8px;
            font-size: 1rem;
            padding-left: 10px;
            font-family: 'JetBrains Mono', serif;
            margin-bottom: 1rem;
            border: 1px thin silver;
        }
        .submit{
            width: 30%;
            height: 2rem;
            background-color: rgb(6, 68, 16);
            color: white;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: 'JetBrains Mono', serif;
            font-style: oblique;
        }

        h2{
            font-family: 'JetBrains Mono', sans-serif;
            
        }
    </style>
</head>
<body>
     <!-- Include Navbar -->
     <?php include 'adminSidepanel.php'; ?>
    <!-- Navbar ends. -->

    <div class="verify-order">
        <h2>Verify Orders..</h2>
        <form action="results.php" method="GET">
            <label for="order-number">Input the Order Number...</label>
            <input type="text" name="order_number" class="verify" autocomplete= "off">
            <input type="submit" value="Verify.." class="submit">
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