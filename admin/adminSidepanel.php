<?php
// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 3600; // 5 minutes in seconds

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

require_once "../config.php";

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Prepare and execute the SQL query using MySQLi
    $stmt = $con->prepare("SELECT full_name, profile_picture FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($fullName, $profilePicture);

    // Fetch the result
    if ($stmt->fetch()) {
        // Data fetched successfully
        $stmt->close();
        // Continue with displaying data
    } else {
        // No data found
        $stmt->close();
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
                <?php
            // Check the admin_role and show/hide menu items accordingly
            if ($_SESSION['admin_role'] == 'super-Management') {
                echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa-solid fa-xmark"></i></a>';
                echo '<a href="../home.php" alt=""><i class="fa-solid fa-light fa-house" style="color: white;"></i> Home</a>';
                echo '<a href="admin.php" alt=""><i class="fa-solid fa-light fa-house" style="color: white;"></i> Admin Dashboard</a>';
                echo '<a href="add.php"><i class="fa-solid fa-book" style="color: white;"></i>  Add Books</a>';
                echo '<a href="update_bookquantity.php"><i class="fa-solid fa-book" style="color: white;"></i>  Update Book </a>';
                echo '<a href="update_bookquantity.php"><i class="fa-solid fa-book" style="color: white;"></i>  Update Book Quantity</a>';
                echo '<a href="update_bookprice.php"><i class="fa-solid fa-book" style="color: white;"></i>  Update Book Price</a>';
                echo '<a href="transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Transaction History</a>';
                echo '<a href="pending_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Pending Transactions</a>';
                echo '<a href="completed_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Completed Transactions</a>';
                echo '<a href="location_order.php"><i class="fa-solid fa-message" style="color: white;"></i> Order by Location</a>';
                echo '<a href="verify_reciept.php"><i class="fa-solid fa-message" style="color: white;"></i> Verify Receipt</a>';
                echo '<a href="books.php"><i class="fa-solid fa-book" style="color: white;"></i> Books</a>';
                echo '<a href="profile.php"><i class="fa-solid fa-user" style="color: white;"></i> Profile</a>';
                echo '<a href="register.php"><i class="fa-solid fa-user-plus" style="color: white;"></i> Add Admin</a>';
                echo '<a href="logout.php"><i class="fa-solid fa-user-secret" style="color: white;"></i>  Logout</a>';
            } elseif ($_SESSION['admin_role'] == 'distributor') {
                echo '<a href="verify_reciept.php"><i class="fa-solid fa-message" style="color: white;"></i> Verify Receipt</a>';
                echo '<a href="profile.php"><i class="fa-solid fa-user" style="color: white;"></i> Profile</a>';
                echo '<a href="logout.php"><i class="fa-solid fa-user-secret" style="color: white;"></i>  Logout</a>';
                echo '<a href="pending_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Pending Transactions</a>';
                echo '<a href="completed_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Completed Transactions</a>';
            }elseif ($_SESSION['admin_role'] == 'location-Head'){
                echo '<a href="verify_reciept.php"><i class="fa-solid fa-message" style="color: white;"></i> Verify Receipt</a>';
                echo '<a href="location_order.php"><i class="fa-solid fa-message" style="color: white;"></i> Order by Location</a>';
                echo '<a href="pending_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Pending Transactions</a>';
                echo '<a href="completed_transactions.php"><i class="fa-solid fa-message" style="color: white;"></i> Completed Transactions</a>';
                echo '<a href="profile.php"><i class="fa-solid fa-user" style="color: white;"></i> Profile</a>';
                echo '<a href="logout.php"><i class="fa-solid fa-user-secret" style="color: white;"></i>  Logout</a>';
            }
            ?>
                <span>
                    <h5>All Rights Reserved</h5>
                    <h5>LionReads, 2023</h5>
                </span>
           </div>
                  
           <div class="openbtn" onclick="openNav()">&#9776;</div>
        </div>

        <div class="n-right">
            <span>
                <h2>
                    LionReads Admin
                </h2>
                <h3>
                    <?php echo $_SESSION['admin_role'];?>
                </h3>
            </span>

        </div>


    </div>
    <!-- Navbar ends -->
</body>
</html>