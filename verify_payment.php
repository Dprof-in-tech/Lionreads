<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$reference = $_GET['reference'];
$name = $_GET['name'];
$orderCR = $_GET['order_number'];
$amount = $_GET['amount'];
$description = $_GET['description'];
$location = $_GET['location'];

// Define the missing variables
$status = $_SESSION['payment_status']; // Define $status
$email = $_SESSION['email']; // Define $email
$books_Paidfor = $_SESSION['books_paid_for']; // Define $books_Paidfor

// set session variables
$_SESSION['payment_status'] = $status;
$_SESSION['reference'] = $reference;
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['order_number'] = $orderCR;
$_SESSION['books_paid_for'] = $books_Paidfor;
$_SESSION['amount'] = $amount;
$_SESSION['location'] = $location;
$_SESSION['description'] = $description;

// retreive session variables
// $books_Paidfor = $_SESSION['books_paid_for'];

// Include the database configuration file
include "config.php";

// Extract the book title and quantity from the payment description
$pattern = '/^(.*?)\s\((\d+)\)$/';
if (preg_match($pattern, $description, $matches)) {
    $book_title = $matches[1];
    $quantity_purchased = intval($matches[2]);

    // Check if the quantity requested is available in the database
    $checkQuantitySql = "SELECT book_quantity FROM books WHERE book_title = ?";
    $stmtCheckQuantity = mysqli_prepare($con, $checkQuantitySql);
    mysqli_stmt_bind_param($stmtCheckQuantity, "s", $book_title);
    
    if (mysqli_stmt_execute($stmtCheckQuantity)) {
        mysqli_stmt_store_result($stmtCheckQuantity);
        if (mysqli_stmt_num_rows($stmtCheckQuantity) > 0) {
            mysqli_stmt_bind_result($stmtCheckQuantity, $available_quantity);
            mysqli_stmt_fetch($stmtCheckQuantity);

            if ($available_quantity >= $quantity_purchased) {
                // Quantity is available, proceed with payment verification
                // Your existing payment verification code goes here
                $curl = curl_init();
  
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer sk_live_42d9a6ab9ae085c4ba7a9802916b26acc04f1de2",
                    "Cache-Control: no-cache",
                    ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                
                if ($err) {
                    echo "<script>alert('cURL Error #: $err');</script>";
                } else {
                    // echo $response;
                    $result = json_decode($response);
                }

                // Check if the transaction was successful
                if ($result && $result->data->status == 'success') {
                    $status = $result->data->gateway_response;
                    $ref = $result->data->reference;
                    $phone = $result->data->customer->phone;
                    $date = $result->data->paid_at;
                   
                    // Include the email sending file
                    require 'email-alert.php';

                    // Deduct the purchased quantity from the book's quantity in the database
                    $updateSql = "UPDATE books SET book_quantity = book_quantity - ? WHERE book_title = ?";
                    $stmt = mysqli_prepare($con, $updateSql);
                    mysqli_stmt_bind_param($stmt, "is", $quantity_purchased, $book_title);

                    if (mysqli_stmt_execute($stmt)) {
                        // Insert data into customer_details table
                        $sqlCustomerDetails = "INSERT INTO customer_details (payment_status, reference, name, phone, order_number, amount, payment_description, pickup_location, payment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmtCustomerDetails = mysqli_prepare($con, $sqlCustomerDetails);
                        mysqli_stmt_bind_param($stmtCustomerDetails, "sssssssss", $status, $ref, $name, $phone, $orderCR, $amount, $description, $location, $date);

                        if (mysqli_stmt_execute($stmtCustomerDetails)) {
                            // Insert data into Transactions table with pickup_status as incomplete
                            $sqlTransactions = "INSERT INTO Transactions (payment_status, name, order_number, amount, payment_description, pickup_location, payment_date, pickup_status, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmtTransactions = mysqli_prepare($con, $sqlTransactions);
                        
                            // Bind placeholders
                            mysqli_stmt_bind_param($stmtTransactions, "sssssssss", $status, $name, $orderCR, $amount, $description, $location, $date, $pickup_status, $ref);
                        
                            // Assign values to the placeholders
                            $pickup_status = 'incomplete';
                        
                            if (mysqli_stmt_execute($stmtTransactions)) {
                                header("location: receipt.php");
                                exit();
                            } else {
                                // Show an error message if the transaction insertion fails
                                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                            }
                        }
                        
                    } else {
                        // Show an error message if the payment description doesn't match the expected pattern
                        echo "<script>alert('Error: Payment description format is incorrect.');</script>";
                    }
                } else {
                    // Show an error message if the transaction verification fails
                    echo "<script>alert('Error: Transaction verification failed. Please try again later.');</script>";
                }

            } else {
                // Redirect to an error page because the requested quantity is not available
                header("location: outOfStock_error.php");
                exit();
            }
        }
    }
} else {
    // Show an error message if the payment description doesn't match the expected pattern
    echo "<script>alert('Error: Payment description format is incorrect.');</script>";
}

?>
