<?php
 // Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 1800; // 5 minutes in seconds
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

    include '../db.php';
    
    // Check if the email session variable is set
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    
        // Prepare and execute the SQL query
        $db = new PDO('mysql:host=sql311.infinityfree.com;dbname=if0_34904562_lionreads', 'if0_34904562', '2bkiU8B0pp2s');
        $stmt = $db->prepare("SELECT full_name, profile_picture FROM admin WHERE email = :email");
        $stmt->execute([':email' => $email]);
    
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Retrieve the name and profile picture
        if ($result) {
            $fullName = $result['full_name'];
            $profilePicture = $result['profile_picture'];
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <link rel="stylesheet" href="profile.css">
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <title>Admin Profile | LionReads</title>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'adminSidepanel.php';?>

    <!-- Profile start -->
    <div class="profile_container">
        <div class="profile_picture">
            <img src="../img/<?php echo $profilePicture;?>" alt="My Profile Picture">
        </div>
        <div class="profile_text">
            <h3><?php echo $email;?></h3>
            <h2><?php echo $fullName;?></h2>
        </div>

        <a href="logout.php">Logout</a>
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