<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$reference = $_SESSION['reference'];
$name = $_SESSION['name'];
$orderCR = $_SESSION['order_number'];
$amount = $_SESSION['amount'];
$description = $_SESSION['description'];
$location = $_SESSION['location'];
$status = $_SESSION['payment_status']; // Define $status
$email = $_SESSION['email']; // Define $email
$books_Paidfor = $_SESSION['books_paid_for']; // Define $books_Paidfor

// Include the PHPMailer classes
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'lionreadsunn@gmail.com'; // Your SMTP username
    $mail->Password = 'c@n$ti||change'; // Your SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, 'ssl' is also accepted
    $mail->Port = 465; // TCP port to connect to

    // Sender and recipient
    $mail->setFrom('lionreadsunn@gmail.com', 'Lionreads');
    $mail->addAddress('amaechiisaac450@gmail.com', 'Isaac Onyemaechi');

    // Add BCC recipient
    $mail->addBCC('akannodebbie7@gmail.com', 'Akanno Deborah');


    // Email subject
    $mail->Subject = 'Lionreads Payment Notification';

    // HTML email content
    $htmlContent = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            /* Add your custom CSS styles here */
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f5f5f5;
                border-radius: 10px;
            }
            h1 {
                color: #333;
            }
            p {
                color: #777;
            }
            .details {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Payment Successful Notification</h1>
            <p>Hello from Lionreads,</p>
            <p>The customer, $name has made a successful payment with reference $reference. Details:</p>
            <div class='details'>
                <p><strong>Order Number:</strong> $orderCR</p>
                <p><strong>Amount:</strong> $amount</p>
                <p><strong>Description:</strong> $description</p>
                <p><strong>Location:</strong> $location</p>
            </div>
            <p>Thank you for your purchase!</p>
        </div>
    </body>
    </html>
";

    $mail->msgHTML($htmlContent);
    
    // Send the email
    $mail->send();
    return true;
} catch (Exception $e) {
    return false;
}
?>
