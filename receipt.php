<?php
// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 2300; // 5 minutes in seconds
session_set_cookie_params($sessionLifetime);
 // start the session
 session_start();
 
 
// Check if the session expiration time is set
if (isset($_SESSION['expire_time'])) {
  // Check if the session has expired
  if (time() > $_SESSION['expire_time']) {
      // Redirect to logout.php
      header("Location: ./admin/logout.php");
      exit();
  }
}

// Set the new expiration time
$_SESSION['expire_time'] = time() + $sessionLifetime;




// retrieve session variables
$reference = $_SESSION['reference'];
$name = $_SESSION['name'];
$email = $_SESSION['email_address'];
$order_number = $_SESSION['order_number'];
$books_Paidfor = $_SESSION['books_paid_for'];
$location = $_SESSION['location'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="receipt.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt | LionReads</title>
</head>
<body>
    <div id="receipt">
    <div class="top_bar">
        <span>
            <img src="./img/Lionreads-logo-1.png" alt="" height="30" width="30" >
            <h3>LionReads</h3>
        </span>
    </div>
    <?php
    include "config.php";

    // Sanitize the input

    $sql = "SELECT * FROM customer_details WHERE reference = '$reference'";

    // execute the query and retrieve the product information
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $order_amount = htmlspecialchars($row['amount']);
        $order_description = htmlspecialchars($row['payment_description']);
        $sender_phone = htmlspecialchars($row['phone']);
        $orderCR = htmlspecialchars($row['order_number']);
        $payment_info = htmlspecialchars($row['payment_status']);
        $pickup_location = htmlspecialchars($row['pickup_location']);
    } else {
        echo "Error: " . mysqli_error($con);
    }
?>

    <div class="transaction">
        <h4>N<?php echo $order_amount;?></h4>
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
            <h3><?php echo $orderCR;?></h3>
        </div>
        <div class="details">
            <h4>Order Info: </h4>
            <h3><?php echo $order_description;?></h3>
        </div>

        <div class="details">
            <h4>Pickup Location: </h4>
            <h3><?php echo $location;?></h3>
        </div>
        
    </div>

    <div class="information">
        <h3> All Pickup to be done between 11AM - 1PM for Engine Chitis and 4PM - 6PM for Stadium and SUB on Tuesdays, Wednesdays & Fridays..
        </h3>
        <h3>Please do not lose or discard this Receipt
            until your order has been successfully processed 
            and delivered..
        </h3>
        <h3>For Delivery Services, please call
            09115375399.. Delivery Charges at #200..
        </h3>
        <h3>
            Thank you from LionReads!!
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

        // Download the PDF file with a callback function
        doc.save("LionReadsreceipt.pdf", function() {
            // PDF successfully downloaded, redirect to logout.php
            window.location.href = './admin/logout.php';
        });
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

        // Download the image file with a callback function
        const link = document.createElement('a');
        link.download = 'LionReadsreceipt.jpeg';
        link.href = newCanvas.toDataURL('image/jpeg', 1.0);
        link.addEventListener('click', function() {
            // Image successfully saved, redirect to logout.php
            window.location.href = './admin/logout.php';
        });
        link.click();
    });
});

</script>

</body>
</html>

