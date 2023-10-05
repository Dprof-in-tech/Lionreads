<?php
    session_start();
    require 'config.php';

    // Initialize the response array
    $response = array();

    if (isset($_GET['bookName']) && isset($_GET['quantity'])) {
        $bookName = $_GET['bookName'];
        $quantityPurchased = intval($_GET['quantity']); // Ensure quantity is an integer

        // Query the database to get the available quantity of the book
        $checkQuantitySql = "SELECT book_quantity FROM books WHERE book_title = ?";
        $stmtCheckQuantity = mysqli_prepare($con, $checkQuantitySql);
        mysqli_stmt_bind_param($stmtCheckQuantity, "s", $bookName);

        if (mysqli_stmt_execute($stmtCheckQuantity)) {
            mysqli_stmt_store_result($stmtCheckQuantity);

            if (mysqli_stmt_num_rows($stmtCheckQuantity) > 0) {
                mysqli_stmt_bind_result($stmtCheckQuantity, $availableQuantity);
                mysqli_stmt_fetch($stmtCheckQuantity);

                if ($availableQuantity >= $quantityPurchased) {
                    // Book is available in the desired quantity
                    $response['available'] = true;
                } else {
                    // Book is not available in the desired quantity
                    $response['available'] = false;
                }
            } else {
                // Book not found in the database
                $response['error'] = "Book not found in the database.";
            }
        } else {
            // Error executing the SQL statement
            $response['error'] = "Error executing SQL statement.";
        }
    } else {
        // Invalid or missing parameters in the AJAX request
        $response['error'] = "Invalid request parameters.";
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

?>