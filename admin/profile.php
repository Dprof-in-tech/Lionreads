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
            <h2><?php echo $fullName;?></h2>
            <h3><?php echo $email;?></h3>
            <h3>Lionreads <?php echo $_SESSION['admin_role'];?></h3>
            <div class="profile_actions">
                <button id="changePasswordBtn" onclick="toggleChangePassword()">Change Password</button>
                <button id="editNameBtn" onclick="toggleEditName()">Edit Name</button>
            </div>
            <div id="changePasswordFields" class="password-input" style="display: none;">
                <input type="password" id="newPassword" placeholder="New Password">
                <input type="password" id="confirmPassword" placeholder="Confirm Password">
                <button onclick="saveNewPassword()">Save</button>
            </div>
            <div id="editNameFields" class="name-input" style="display: none;">
                <input type="text" id="newName" placeholder="New Name">
                <button onclick="saveNewName()">Save</button>
            </div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <script>
        function toggleChangePassword() {
        const changePasswordBtn = document.getElementById("changePasswordBtn");
        const changePasswordFields = document.getElementById("changePasswordFields");

        if (changePasswordFields.style.display === "none") {
            changePasswordBtn.style.display = "none";
            changePasswordFields.style.display = "block";
        } else {
            changePasswordBtn.style.display = "block";
            changePasswordFields.style.display = "none";
        }
    }

    function toggleEditName() {
        const editNameBtn = document.getElementById("editNameBtn");
        const editNameFields = document.getElementById("editNameFields");

        if (editNameFields.style.display === "none") {
            editNameBtn.style.display = "none";
            editNameFields.style.display = "block";
        } else {
            editNameBtn.style.display = "block";
            editNameFields.style.display = "none";
        }
    }

    function saveNewPassword() {
    // Get the values from the input fields
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    // Check if newPassword and confirmPassword are not empty
    if (!newPassword || !confirmPassword) {
        alert("Please fill in both password fields.");
        return;
    }

    // Check if newPassword and confirmPassword match
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    // Implement logic to save the new password to the database

    // Make an AJAX request to changePassword.php to update the password
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "changePassword.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle the response from changePassword.php (e.g., display a success message)
                console.log(xhr.responseText);
                // Revert to buttons if successful
                toggleChangePassword();
            } else {
                // Handle errors or display an error message
                console.error("Error: " + xhr.statusText);
            }
        }
    };
    xhr.send("newPassword=" + newPassword);
}


        function saveNewName() {
            const newName = document.getElementById("newName").value;

            // Check if newName is not empty
            if (!newName) {
                alert("Please fill in the name field.");
                return;
            }
          // Make an AJAX request to editName.php to update the name
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "editName.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from editName.php (e.g., display a success message)
                    console.log(xhr.responseText);
                    // Revert to buttons if successful
                    toggleEditName();
                }
            };
            xhr.send("newName=" + newName);
        }
    </script>
    

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