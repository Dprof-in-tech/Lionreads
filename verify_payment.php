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


// set session variables
$_SESSION['payment_status'] = $status;
$_SESSION['reference'] = $reference;
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['order_number'] = $orderCR;
$_SESSION['books_paid_for'] = $books_Paidfor;
$_SESSION['amount'] = $amount;
$_SESSION['location'] = $location;

// retreive session variables
// $books_Paidfor = $_SESSION['books_paid_for'];

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
    echo "cURL Error #:" . $err;
} else {
    // echo $response;
    $result = json_decode($response);
}
// echo $amount;
if($result->data->status == 'success'){
    $status = $result->data->gateway_response;
    $ref = $result->data->reference;
    $phone = $result->data->customer->phone;
    $date = $result->data->paid_at;

    include "config.php";
    // Insert data into customer_details table
    $sqlCustomerDetails = "INSERT INTO customer_details (payment_status, reference, name, phone, order_number, amount, payment_description, pickup_location, payment_date) VALUES ('$status', '$ref', '$name', '$phone', '$orderCR', '$amount', '$description', '$location', '$date')";
    $queryCustomerDetails = mysqli_query($con, $sqlCustomerDetails);

    if (!$queryCustomerDetails) {
        echo "Error: unable to prepare statement" . mysqli_error($con);
    } else {
        // Insert data into Transactions table with pickup_status as incomplete
        $sqlTransactions = "INSERT INTO Transactions (payment_status, name, order_number, amount, payment_description, pickup_location, payment_date, pickup_status, reference) VALUES ('$status', '$name', '$orderCR', '$amount', '$description', '$location', '$date', 'incomplete', '$ref')";
        $queryTransactions = mysqli_query($con, $sqlTransactions);
        
        if (!$queryTransactions) {
            echo "Error: unable to prepare statement for Transactions table" . mysqli_error($con);
        } else {
            header("location: receipt.php");
            exit();
        }
    }
    
    $con->close();
} else {
    header("Location: cart.php");
}
?>
