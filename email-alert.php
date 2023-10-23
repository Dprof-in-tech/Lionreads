<?php
$reference = $_SESSION['reference'];
$name = $_SESSION['name'];
$orderCR = $_SESSION['order_number'];
$amount = $_SESSION['amount'];
$description = $_SESSION['ConcatenatedInputs'];
$location = $_SESSION['location'];
$status = $_SESSION['paymentStatus'];
$email = $_SESSION['email_address'];
$books_Paidfor = $_SESSION['books_paid_for'];

// Include the PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'lionreads.com.ng';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@lionreads.com.ng';
    $mail->Password = 'C@n$tillchange';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;  // Use the correct port for TLS

    // Sender and recipient
    $mail->setFrom('support@lionreads.com.ng', 'Lionreads');
    $mail->addAddress($email, $name);

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
            <h1>Successful Payment Notification</h1>
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
    if ($mail->send()) {
        echo '<script>alert("Email sent successfully");</script>';
        return true;
    } else {
        echo '<script>alert("Email could not be sent. Error: ' . $mail->ErrorInfo . '");</script>';
        return false;
    }
} catch (Exception $e) {
    echo '<script>alert("Email could not be sent. Exception: ' . $e->getMessage() . '");</script>';
    return false;
}
?>
