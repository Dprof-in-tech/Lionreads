<?php
// Start the session and include the database configuration
session_start();
require_once "../config.php";

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Get the new name from the POST data
    $newName = $_POST['newName'];

    // Update the name in the database
    $stmt = $con->prepare("UPDATE admin SET full_name = ? WHERE email = ?");
    $stmt->bind_param("ss", $newName, $email);

    if ($stmt->execute()) {
        // Name updated successfully
        echo "Name updated successfully.";
    } else {
        // Error occurred while updating the name
        echo "Error updating the name.";
    }

    // Close the statement and database connection
    $stmt->close();
    $con->close();
}
?>
