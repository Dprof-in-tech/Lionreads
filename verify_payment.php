<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(isset($_GET["transaction_id"]) AND isset($_GET["status"])  AND isset($_GET["tx_ref"])){
    $transactionID = htmlspecialchars($_GET['transaction_id']);
    $trans_status = htmlspecialchars($_GET['status']);
    $trans_ref = htmlspecialchars($_GET['tx_ref']);

    //Define the missing variables using session variables
    $orderCR = $_SESSION['order_number'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email_address'];
    $books_Paidfor = $_SESSION['books_paid_for'];
    $amountPaid = $_SESSION['amount'];
    $location = $_SESSION['location'];
    $phone_number = $_SESSION['phone_number'];
    $description = $_SESSION['concatenatedInputs'];


    //Verify Endpoint
    $url = "https://api.flutterwave.com/v3/transactions/".$transactionID."/verify";

    //Create cURL session
    $curl = curl_init($url);

    //Turn off SSL checker
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    //Decide the request that you want
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
    //Set the API headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer FLWSECK_TEST-7ccf562064f3de3d9197f3fa1dd2bcc6-X",
        "Content-Type: Application/json"
    ]);

    //Run cURL
    $run = curl_exec($curl);

    //Check for erros
    $error = curl_error($curl);
    if($error){
        die("Curl returned some errors: " . $error);
    }

   //echo"<pre>" . $run . "</pre>";
   //Convert to json obj
   $result = json_decode($run);

  $status = $result->data->status;
  $message = $result->message;
  $id = $result->data->id;
  $reference =  $result->data->tx_ref;
  $amount =  $result->data->amount;
  $date = $result->data->created_at;
  $charged_amount = $result->data->charged_amount;
  $name =  $result->data->customer->name;
  $email =  $result->data->customer->email;
  $phone =  $result->data->customer->phone_number;

  // Set session variables
  $_SESSION['email_address'] = $email;
  $_SESSION['amount'] = $amountPaid;
  $_SESSION['name'] = $name;
  $_SESSION['reference'] = $reference;
  $_SESSION['phone_number'] = $phone_number;
  $_SESSION['order_number'] = $order_number;
  $_SESSION['session_id'] = $session_id;
  $_SESSION['books_paid_for'] = $books_Paidfor;
  $_SESSION['location'] = $location;

  if(($status != $trans_status) OR ($transactionID != $id)){
     header("Location: cart.php");
     exit;
  }else{
      //Give value
    //   echo "$reference";
      // Include the database configuration file
        include "config.php";
        // Quantity is available, proceed to insert details
        // Deduct the purchased quantity from the book's quantity in the database
        $updateSql = "UPDATE books SET book_quantity = book_quantity - ? WHERE book_title = ?";
        $stmt = mysqli_prepare($con, $updateSql);
        mysqli_stmt_bind_param($stmt, "is", $quantity_purchased, $book_title);

        if (mysqli_stmt_execute($stmt)) {
            // Insert data into customer_details table
            $sqlCustomerDetails = "INSERT INTO customer_details (payment_status, reference, name, phone, order_number, amount, payment_description, pickup_location, payment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtCustomerDetails = mysqli_prepare($con, $sqlCustomerDetails);
            mysqli_stmt_bind_param($stmtCustomerDetails, "sssssssss", $status, $reference, $name, $phone_number, $orderCR, $amountPaid, $description, $location, $date);

            if (mysqli_stmt_execute($stmtCustomerDetails)) {
                // Insert data into Transactions table with pickup_status as incomplete
                $sqlTransactions = "INSERT INTO Transactions (payment_status, name, order_number, amount, payment_description, pickup_location, payment_date, pickup_status, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtTransactions = mysqli_prepare($con, $sqlTransactions);

                // Bind placeholders
                $pickup_status = 'incomplete';
                mysqli_stmt_bind_param($stmtTransactions, "sssssssss", $status, $name, $orderCR, $amountPaid, $description, $location, $date, $pickup_status, $reference);

                // Assign values to the placeholders
                if (mysqli_stmt_execute($stmtTransactions)) {
                    // Include the email sending file
                    require 'email-alert.php';
                    header("location: receipt.php");
                    exit();
                } else {
                    // Show an error message if the transaction insertion fails
                    echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                }
            } else {
                // Show an error message if the transaction verification fails
                echo "<script>alert('Error: " . mysqli_error($con) . " ');</script>";
            }
        }
        else{
            // Show an error message if the transaction verification fails
            echo "<script>alert('Error: " . mysqli_error($con) . " ');</script>";
        }
        }
  curl_close($curl);

}else{
    header("Location: cart.php");
     exit;
}
// // Ensure the required variables are set and not empty
// if (isset($_GET['tx_ref']) && isset($_GET['status']) && isset($_GET['transaction_id'])) {
//     $reference = $_GET['tx_ref'];
//     $status = $_GET['status'];
//     $transactionID = $_GET['transaction_id'];

//     // Define the missing variables using session variables
//     $orderCR = $_SESSION['order_number'];
//     $name = $_SESSION['name'];
//     $email = $_SESSION['email_address'];
//     $books_Paidfor = $_SESSION['books_paid_for'];
//     $amount = $_SESSION['amount'];
//     $location = $_SESSION['location'];
//     $description = $_SESSION['concatenatedInputs'];

//     // Include the database configuration file
//     include "config.php";

//     // Extract the book title and quantity from the payment description
//     $pattern = '/^(.*?)\s\((\d+)\)$/';
//     if (preg_match($pattern, $description, $matches)) {
//         $book_title = $matches[1];
//         $quantity_purchased = intval($matches[2]);

//         // Check if the quantity requested is available in the database
//         $checkQuantitySql = "SELECT book_quantity FROM books WHERE book_title = ?";
//         $stmtCheckQuantity = mysqli_prepare($con, $checkQuantitySql);
//         mysqli_stmt_bind_param($stmtCheckQuantity, "s", $book_title);

//         if (mysqli_stmt_execute($stmtCheckQuantity)) {
//             mysqli_stmt_store_result($stmtCheckQuantity);
//             if (mysqli_stmt_num_rows($stmtCheckQuantity) > 0) {
//                 mysqli_stmt_bind_result($stmtCheckQuantity, $available_quantity);
//                 mysqli_stmt_fetch($stmtCheckQuantity);

//                 if ($available_quantity >= $quantity_purchased) {
//                     // Quantity is available, proceed with payment verification
//                     $query = array(
//                         "SECKEY" => "FLWSECK_TEST-0a160a281580a998fc9c56c72489a65e-X",
//                         "txref" => $reference
//                     );

//                     $data_string = json_encode($query);

//                     $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
//                     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//                     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//                     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//                     $response = curl_exec($ch);

//                     if ($response === false) {
//                         // Handle CURL error
//                         echo "<script>alert('Error: " . curl_error($ch) . "');</script>";
//                     } else {
//                         $response = json_decode($response, true);

//                         $paymentStatus = $response['data']['status'];
//                         $chargeResponsecode = $response['data']['chargecode'];
//                         $chargeAmount = $response['data']['amount'];
//                         $chargeCurrency = $response['data']['currency'];

//                         if ($paymentStatus == 'successful') {
//                             // Payment was successful
//                             // Deduct the purchased quantity from the book's quantity in the database
//                             $updateSql = "UPDATE books SET book_quantity = book_quantity - ? WHERE book_title = ?";
//                             $stmt = mysqli_prepare($con, $updateSql);
//                             mysqli_stmt_bind_param($stmt, "is", $quantity_purchased, $book_title);

//                             if (mysqli_stmt_execute($stmt)) {
//                                 // Insert data into customer_details table
//                                 $sqlCustomerDetails = "INSERT INTO customer_details (payment_status, reference, name, phone, order_number, amount, payment_description, pickup_location, payment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
//                                 $stmtCustomerDetails = mysqli_prepare($con, $sqlCustomerDetails);
//                                 mysqli_stmt_bind_param($stmtCustomerDetails, "sssssssss", $paymentStatus, $reference, $name, $phone, $orderCR, $amount, $description, $location, $date);

//                                 if (mysqli_stmt_execute($stmtCustomerDetails)) {
//                                     // Insert data into Transactions table with pickup_status as incomplete
//                                     $sqlTransactions = "INSERT INTO Transactions (payment_status, name, order_number, amount, payment_description, pickup_location, payment_date, pickup_status, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
//                                     $stmtTransactions = mysqli_prepare($con, $sqlTransactions);

//                                     // Bind placeholders
//                                     $pickup_status = 'incomplete';
//                                     mysqli_stmt_bind_param($stmtTransactions, "sssssssss", $paymentStatus, $name, $orderCR, $amount, $description, $location, $date, $pickup_status, $reference);

//                                     // Assign values to the placeholders
//                                     if (mysqli_stmt_execute($stmtTransactions)) {
//                                         // Include the email sending file
//                                         require 'email-alert.php';
//                                         header("location: receipt.php");
//                                         exit();
//                                     } else {
//                                         // Show an error message if the transaction insertion fails
//                                         echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
//                                     }
//                                 } else {
//                                     // Show an error message if the transaction verification fails
//                                     echo "<script>alert('Error: Transaction verification failed. Please try again later.');</script>";
//                                 }
//                             } else {
//                                 // Redirect to an error page because the requested quantity is not available
//                                 header("location: outOfStock_error.php");
//                                 exit();
//                             }
//                         }
//                     }

//                     curl_close($ch);
//                 }
//             }
//         }
//     } else {
//         // Show an error message if the payment description doesn't match the expected pattern
//         echo "<script>alert('Error: Payment description format is incorrect.');</script>";
//     }
// } else {
//     // Show an error message if required GET parameters are missing
//     echo "<script>alert('Error: Required GET parameters are missing.');</script>";
// }
?>
