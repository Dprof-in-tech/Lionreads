<?php
// Check if the orderNumber parameter is provided in the POST request
if (isset($_POST['orderNumber'])) {
    // Retrieve the orderNumber from the POST data
    $orderNumber = $_POST['orderNumber'];

    // Connect to your database (replace with your database credentials)
    // Include your database connection code here
    include "../config.php";

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the SQL query to update the pickup_status
    $sql = "UPDATE Transactions SET pickup_status = 'completed' WHERE order_number = '$orderNumber'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Update the status immediately to "completed" in the database
        echo "Pickup status updated successfully";
    } else {
        // Error message
        echo "Error updating pickup status: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request message
    echo "Invalid request";
}
?>
