<?php
include '../db.php';

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Prepare and execute the SQL query
    $db = new PDO('mysql:host=localhost;dbname=lionreadz', 'root', '');
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
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="style.css">
    <title>AdminSide Panel.</title>
</head>
<body>
     <!-- Navbar begins -->
     <div class="navbar">
        <div class="n-left">
            <div id="mySidepanel" class="sidepanel">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa-solid fa-xmark"></i></a>
                <a href="../home.php" alt=""><i class="fa-solid fa-light fa-house" style="color: white;"></i> Home</a>
                <a href="add.php"><i class="fa-solid fa-book" style="color: white;"></i>  Add Books</a>
                <a href="transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Transactions</a>
                <a href="books.php"><i class="fa-solid fa-book" style="color: white;"></i> Books</a>
                <a href="profile.php"><i class="fa-solid fa-user" style="color: white;"></i> Profile</a>
                <a href="register.php"><i class="fa-solid fa-user-plus" style="color: white;"></i> Add Admin</a>
                <a href="logout.php"><i class="fa-solid fa-user-secret" style="color: white;"></i>  Logout</a>
                <span>
                    <h5>All Rights Reserved</h5>
                    <h5>LionReadz, 2023</h5>
                </span>
           </div>
                  
           <div class="openbtn" onclick="openNav()">&#9776;</div>
        </div>

        <div class="n-right">
            <span>
                <h2>
                    LionReads Bookstore
                </h2>
                <h3>
                    Admin
                </h3>
            </span>
            <div class="admin_image">
                <img src="../img/<?php echo $profilePicture;?>" alt="Admin Profile Picture">
            </div>

        </div>


    </div>
    <!-- Navbar ends -->
</body>
</html>