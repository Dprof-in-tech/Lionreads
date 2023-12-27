<?php
// Include the PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST['phone'];
    $message = $_POST["message"];

    // Configure PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;   // Enable verbose debug output (change to 2 for more detailed debugging)
        $mail->isSMTP();
        $mail->Host = 'lionreads.com.ng';  // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'support@lionreads.com.ng'; // SMTP username
        $mail->Password = 'C@n$tillchange';       // SMTP password
        $mail->SMTPSecure = 'tls';   // Enable TLS encryption; `ssl` also accepted
        $mail->Port = 587;           // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('support@lionreads.com.ng'); // Add a recipient

        // Content
        $mail->isHTML(false);
        $mail->Subject = "New Message / Complaint from $name";
        $mail->Body = "Name: $name\nPhone: $phone\nEmail: $email\n\nMessage:\n$message";

        // Send email
        if ($mail->send()) {
            echo '<script>alert("Message sent successfully");</script>';
            header("Location: {$_SERVER['PHP_SELF']}");
            exit; // Exit after the refresh
        } else {
            echo '<script>alert("Email could not be sent. Error: ' . $mail->ErrorInfo . '");</script>';
            return false;
        }
    } catch (Exception $e) {
        echo "Oops! Something went wrong and we couldn't send your message. Error: {$mail->ErrorInfo}";
    }
}
?>
