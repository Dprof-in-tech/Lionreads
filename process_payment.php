<?php
session_start();
if(isset($_POST['pay_for_books'])){
  // Get the product ID and quantity from the form submission
  $email = $_POST['email_address'];
  $amount_paid = $_POST['amount_paid'];
  $name = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  $order_number = $_POST['order_number'];
  $session_id = $_POST['session_id'];
  $books_Paidfor =  $_POST['books_paid_for'];
  $location = $_POST['location'];

    // Set session variables
    $_SESSION['email_address'] = $email;
    $_SESSION['amount'] = $amount_paid;
    $_SESSION['name'] = $name;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['order_number'] = $order_number;
    $_SESSION['session_id'] = $session_id;
    $_SESSION['books_paid_for'] = $books_Paidfor;
    $_SESSION['location'] = $location;

  // Make sure to set your secret key
$secretKey = "FLWSECK_TEST-0a160a281580a998fc9c56c72489a65e-X";

// Define the data to be sent in the request
$data = array(
    "tx_ref" => "LR_A" . uniqid(),
    "amount" => $amount_paid,
    "currency" => "NGN",
    "redirect_url" => "http://localhost:8000/verify_payment.php",
    "meta" => array(
        "consumer_id" => 23,
        "consumer_mac" => "92a3-912ba-1192a"
    ),
    "customer" => array(
        "email" => $email,
        "phonenumber" => $phone_number,
        "name" => $name
    ),
    "customizations" => array(
        "title" => "Lionreads Book Purchase",
        "logo" => "http://localhost:8000/img/LionReads-logo.png"
    )
);

// Convert data to JSON
$dataJSON = json_encode($data);

// Set the headers
$headers = array(
    "Authorization: Bearer $secretKey",
    "Content-Type: application/json",
);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/payments");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and capture the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Handle the response data as needed
if (isset($responseData['data']['link'])) {
    // Redirect the user to the payment link
    header('Location: ' . $responseData['data']['link']);
} else {
    // Handle the error
    echo 'API returned an error: ' . $responseData['message'];
}
    }
    ?>
