<?php
// Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 1800; // 30 minutes in seconds
session_set_cookie_params($sessionLifetime);
// Start the session
session_start();

// Check if the session expiration time is set
if (isset($_SESSION['expire_time'])) {
    // Check if the session has expired
    if (time() > $_SESSION['expire_time']) {
        // Redirect to logout.php
        header("Location: logout.php");
        exit();
    }
}

// Set the new expiration time
$_SESSION['expire_time'] = time() + $sessionLifetime;

// Check if the form has been submitted
if (isset($_GET['location'])) {
    $location = $_GET['location'];
    include "../config.php"; // Include your database connection script

    // Modify the SQL query to retrieve orders based on the selected location
    $sql = "SELECT * FROM customer_details WHERE pickup_location = '$location'";
    $result = mysqli_query($con, $sql);
    $rowcount = mysqli_num_rows($result);
} else {
    // If the form has not been submitted, initialize rowcount to 0
    $rowcount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <title>Location Order History | LionReads</title>
    <style>
        .search-bar{
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: center;
        }

        form{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
<div id="locationPage">

    <div class="search-bar">
    <form method="GET">
        <label for="location">Select Location:</label>
        <select id="location" name="location">
            <option value="engine-chitis">Engine Chitis</option>
            <option value="sub">S.U.B</option>
            <option value="stadium">Stadium</option>
        </select>
        <input type="submit" value="Search">
    </form>

    <div class="download-buttons">
        <button  id="pdf-btn"  class="download_button" ><i class="fa-solid fa-download"></i> PDF</button>
    </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Order Number</th>
                <th scope="col">Phone</th>
                <th scope="col">Pickup Location</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($rowcount > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $description = $row['payment_description'];
                    $payment = $row['payment_status'];
                    $amount = $row['amount'];
                    $order_number = $row['order_number'];
                    $phone = $row['phone'];
                    $location = $row['pickup_location'];
                    $date = $row['payment_date'];
                    echo '
                    <tr>
                        <th scope="row">' . $id . '</th>
                        <td>' . $name . '</td>
                        <td>' . $description . '</td>
                        <td>' . $payment . '</td>
                        <td>' . $order_number . '</td>
                        <td>' . $phone . '</td>
                        <td>' . $location . '</td>
                        <td>' . $date . '</td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="9">No results found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
    // Get the buttons
    let pdfBtn = document.getElementById("pdf-btn");

    // Add event listener to the PDF button
pdfBtn.addEventListener("click", function() {
    // Use html2canvas to capture the content of the receipt element
    html2canvas(document.querySelector("#locationPage")).then(canvas => {
        // Create a new PDF document
        var doc = new jsPDF();

        // Add the canvas to the PDF document
        doc.addImage(canvas.toDataURL(), 'PDF', 10, 10, 190, 277);

        // Download the PDF file with a callback function
        doc.save("Lionreads Order by Location.pdf", function() {
        });
    });
});
</script>
</body>
</html>
