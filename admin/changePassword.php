<?php
// Start the session and include the database configuration
session_start();
require_once "../config.php";

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Get the new password from the POST data
    $newPassword = $_POST['newPassword'];

    // Hash the new password before updating it in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $con->prepare("UPDATE admin SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        // Password updated successfully
        echo "Password updated successfully.";
    } else {
        // Error occurred while updating the password
        echo "Error updating the password.";
    }

    // Close the statement and database connection
    $stmt->close();
    $con->close();
}
?>
