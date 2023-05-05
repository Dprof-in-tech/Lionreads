<?php
session_start();
$reference = $_GET['reference'];
$name = $_GET['name'];
$orderCR = $_GET['order_number'];
$amount = $_GET['amount'];
$description = $_GET['description'];


// set session variables
$_SESSION['payment_status'] = $status;
$_SESSION['reference'] = $reference;
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['order_number'] = $orderCR;
$_SESSION['books_paid_for'] = $books_Paidfor;
$_SESSION['amount'] = $amount;

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
      "Authorization: Bearer sk_test_2cb7da0890fe267509938ac8cc26b85cdb3cfe92",
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

    require "db.php";
    $sql ="INSERT INTO customer_details (payment_status,reference, name, phone, order_number, amount, payment_description) VALUES ('$status','$ref', '$name', '$phone', '$orderCR', '$amount', '$description')";
    $query = mysqli_query($con, $sql);
    
    if(!$query){
        echo "Error: unable to prepare statement" . mysqli_error($con);
    } else {
        header("location: receipt.php");
        exit();
    }
    
    $con->close();
} else {
    header("Location: cart.php");
}
?>
