<?php
// start session
ini_set('session.gc_maxlifetime', 100);
ini_set('session.cookie_lifetime', 100);
session_start();
// check if the session has expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 100)) {
// destroy the session and redirect to the login page
session_unset();     // unset $_SESSION variable for the run-time 
session_destroy();   // destroy session data in storage
header("Location: home.php");
exit();
}

// update the LAST_ACTIVITY timestamp
$_SESSION['LAST_ACTIVITY'] = time();



// retrieve session variables
$payment_status = $_SESSION['payment_status'];
$reference = $_SESSION['reference'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$order_number = $_SESSION['order_number'];
$books_Paidfor = $_SESSION['books_paid_for'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="receipt.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt | LionReadz</title>
</head>
<body>
    <div id="receipt">
    <div class="top_bar">
        <span>
            <img src="./img/LionReads-logo.png" alt="" height="30" width="30" >
            <h3>LionReadz</h3>
        </span>
    </div>
    <?php
    require 'db.php';

    // Sanitize the input

    $sql = "SELECT * FROM customer_details WHERE reference = '$reference'";

    // execute the query and retrieve the product information
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $order_amount = htmlspecialchars($row['amount']);
        $order_description = htmlspecialchars($row['payment_description']);
        $sender_phone = htmlspecialchars($row['phone']);
        $payment_info = htmlspecialchars($row['payment_status']);
    } else {
        echo "Error: " . mysqli_error($con);
    }
?>

    <div class="transaction">
        <h4>N<?php echo $order_amount;?>.00</h4>
        <h5><?php echo $payment_info;?></h5>
    </div>
    <div class="transaction_details">
        <h3>Transaction Info:</h3>
    <div class="details">
            <h4>Sender ID: </h4>
            <span>
            <h3><?php echo $name;?></h3>
            <h3><?php echo $sender_phone;?></h3>
            </span>
        </div>
        <div class="details">
            <h4>Transaction ID: </h4>
            <h3><?php echo $reference;?></h3>
        </div>
        <div class="details">
            <h4>Order ID: </h4>
            <h3><?php echo $order_number;?></h3>
        </div>
        <div class="details">
            <h4>Order Info: </h4>
            <h3><?php echo $order_description;?></h3>
        </div>
        
    </div>

    <div class="information">
        <h3>Please do not lose or discard this Receipt
            until your order has been successfully processed 
            and delivered..
        </h3>
        <h3>For Delivery Services, please call
            09027585480.. Delivery Charges at #200..
        </h3>
        <h3>
            Thank you from LionReadz!!
        </h3>
    </div>

    </div>
    <div class="download-buttons">
        <button  id="pdf-btn"  class="download_button" ><i class="fa-solid fa-download"></i> PDF</button>
        <button id="image-btn"  class="download_button" ><i class="fa-solid fa-download"></i> JPG</button>

    </div>
    

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
    // Get the buttons
    let pdfBtn = document.getElementById("pdf-btn");
    let imgBtn = document.getElementById("image-btn");

    // Add event listener to the PDF button
    pdfBtn.addEventListener("click", function() {
        // Use html2canvas to capture the content of the receipt element
        html2canvas(document.querySelector("#receipt")).then(canvas => {
            // Create a new PDF document
            var doc = new jsPDF();

            // Add the canvas to the PDF document
            doc.addImage(canvas.toDataURL(), 'PDF', 10, 10, 190, 277);

            // Download the PDF file
            doc.save("LionReadzreceipt.pdf");
        });
    });

    // Add event listener to the image button
    imgBtn.addEventListener("click", function() {
  // Use html2canvas to capture the content of the receipt element
  html2canvas(document.querySelector("#receipt")).then(canvas => {
    // Create a new canvas element with a white background
    const newCanvas = document.createElement('canvas');
    const context = newCanvas.getContext('2d');
    newCanvas.width = canvas.width;
    newCanvas.height = canvas.height;
    context.fillStyle = '#fff';
    context.fillRect(0, 0, canvas.width, canvas.height);

    // Draw the original canvas onto the new canvas
    context.drawImage(canvas, 0, 0);

    // Download the image file
    const link = document.createElement('a');
    link.download = 'LionReadzreceipt.jpeg';
    link.href = newCanvas.toDataURL('image/jpeg', 1.0);
    link.click();
  });
});

    // imgBtn.addEventListener("click", function() {
    //     // Use html2canvas to capture the content of the receipt element
    //     html2canvas(document.querySelector("#receipt")).then(canvas => {
    //         // Download the image file
    //         var link = document.createElement('a');
    //         link.download = 'LionReadzreceipt.jpeg';
    //         link.href = canvas.toDataURL('image/jpeg', 1.0);

    //         link.click();
    //     });
    // });
</script>

</body>
</html>

