<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$session_id = session_id();
// Define the missing variables using session variables
$orderCR = $_SESSION['order_number'];
$name = $_SESSION['name'];
$email = $_SESSION['email_address'];
$books_Paidfor = $_SESSION['books_paid_for'];
$amountPaid = $_SESSION['amount'];
$location = $_SESSION['location'];
$phone_number = $_SESSION['phone_number'];
$description = $_SESSION['concatenatedInputs'];

// Set session variables
$_SESSION['email_address'] = $email;
$_SESSION['amount'] = $amountPaid;
$_SESSION['name'] = $name;
$_SESSION['phone_number'] = $phone_number;
$_SESSION['order_number'] = $orderCR;
$_SESSION['session_id'] = $session_id;
$_SESSION['books_paid_for'] = $books_Paidfor;
$_SESSION['location'] = $location;
$_SESSION['ConcatenatedInputs'] = $description;

$FLW_SECRET_KEY = 'FLWSECK_TEST-7ccf562064f3de3d9197f3fa1dd2bcc6-X'; // Replace with your Flutterwave secret key
$transactionId = $_GET['transaction_id']; // Assuming you get the transaction ID from the URL
$expectedAmount = 100; // Replace with your expected amount
$expectedCurrency = 'NGN'; // Replace with your expected currency

// Create the URL for the verification endpoint
$url = "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify";

// Initialize cURL session
$curl = curl_init($url);

// Turn off SSL certificate verification (for testing, you should use a valid SSL certificate in production)
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

// Set the API headers including your Flutterwave secret key
$headers = [
    "Authorization: Bearer $FLW_SECRET_KEY",
    "Content-Type: application/json",
];
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Execute the cURL request
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo "Curl error: " . curl_error($curl);
    exit;
}

// Close the cURL session
curl_close($curl);

// Parse the JSON response
$result = json_decode($response, true);

if (
    $result['data']['status'] === "successful"
    && $result['data']['currency'] === $expectedCurrency
) {
    // Success! Confirm the customer's payment
    include "config.php";
    // You can access payment details from $result['data']
    $amount = $result['data']['amount'];
    $name = $result['data']['customer']['name'];
    $email = $result['data']['customer']['email'];
    $date = $result['data']['created_at'];
    $phone = $result['data']['customer']['phone_number'];

    // Further processing, such as updating your database, sending emails, etc.
    // Split the concatenatedInputs into individual book descriptions
    // Extract the book title and quantity from the payment description
    $pattern = '/^(.*?)\s\((\d+)\)$/';
    if (preg_match($pattern, $description, $matches)) {
        $book_title = $matches[1];
        $quantity_purchased = intval($matches[2]);

        // Assuming you have a 'books' table with columns 'name' and 'quantity'
        // Update the quantity in the database
       // Deduct the purchased quantity from the book's quantity in the database
        $updateSql = "UPDATE books SET book_quantity = book_quantity - ? WHERE book_title = ?";
        $stmt = mysqli_prepare($con, $updateSql);
        mysqli_stmt_bind_param($stmt, "is", $quantity_purchased, $book_title);

        if ($stmt->execute()) {
            echo '<script>alert("Quantity for $bookName subtracted by $quantity.<br>")</script>';
        } else {
            echo "Failed to update quantity for $bookName.<br>";
        }
    } 
    
    // Insert into the 'customer_details' table
     $insertCustomerDetailsSQL = "INSERT INTO customer_details (payment_status, reference, name, phone, amount, order_number, payment_description, pickup_location, payment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
     $paymentStatus = $result['data']['status'];
     $reference = $result['data']['tx_ref'];
 
     $_SESSION['reference'] = $reference;
     $_SESSION['paymentStatus'] = $paymentStatus;
     $stmt = $con->prepare($insertCustomerDetailsSQL);
     $stmt->bind_param("sssssssss", $paymentStatus, $reference, $name, $phone_number, $amount, $orderCR, $description, $location, $date);
     
     if ($stmt->execute()) {
         // Insert into the 'transactions' table
         $insertTransactionSQL = "INSERT INTO Transactions (payment_status, name, order_number, amount, payment_description, pickup_location, payment_date, pickup_status, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         $pickup_status = 'incomplete';
 
         $stmt = $con->prepare($insertTransactionSQL);
         $stmt->bind_param("sssssssss", $paymentStatus, $name, $orderCR, $amount, $description, $location, $date, $pickup_status, $reference);
         
         if ($stmt->execute()) {   
             // Include the email sending file
            //  require_once 'email-alert.php';
             header("location: receipt.php");
             exit();
         } else {
             // Show an error message if the transaction insertion fails
             echo "<script>alert('Error: " . $stmt->error . "');</script>";
         }
     } else {
         // Handle the case where the customer_details insertion fails
         echo "Failed to insert customer details into the database: " . $stmt->error;
     }
 
     // Close the database connection
     $con->close();
 
     // Redirect to a success page or perform additional actions as needed
     header("Location: receipt.php");
     exit;
} else {
    // Payment verification failed
    echo "Payment verification failed. Please check the payment status.";
    header("Location: cart.php"); // Redirect to an error page
    exit;
}
?>
