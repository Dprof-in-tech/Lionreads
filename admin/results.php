<!-- // search_results.php -->
<?php

// set the session timeout to 30 minutes
ini_set('session.gc_maxlifetime', 2300);
session_set_cookie_params(2300);

// start the session
session_start();



// regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// set the last activity time to the current time
$_SESSION['last_activity'] = time();

// check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 2300)) {
    // session timed out, destroy the session
    session_unset();
    session_destroy();
    header("location: index.php");
}

// update the last activity time
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../img/Lionreads-logo-1.png" type="image/x-icon">
    <title>Receipt Results | LionReads</title>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .confirm-button {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }
    </style>

</head>
<body>
    <!-- include navbar -->
    <?php include 'adminSidepanel.php'; ?>
    <!-- Navbar ends. -->

    <?php
    // connect to the database
    include "../config.php";
    // retrieve the search query from the form submission
    $search_query = $_GET['order_number'];

    // construct the SQL query to search for products that match the search query
    $sql = "SELECT * FROM Transactions WHERE (order_number LIKE '%$search_query%' OR reference LIKE '%$search_query%') AND pickup_status = 'incomplete'";

    // execute the query and retrieve the search results
    $result = mysqli_query($con, $sql);
    //Search results

    // Check if the form is submitted (when Confirm! button is clicked)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve the order number from the submitted form
        $orderNumber = $_POST['orderNumber'];

        // Define the SQL query to update the pickup_status
        $sql = "UPDATE Transactions SET pickup_status = 'completed' WHERE order_number = '$orderNumber'";

        // Execute the query
        if ($con->query($sql) === TRUE) {
            // Success message as a JavaScript alert
            echo '<script>alert("Pickup status updated successfully");</script>';
             header("location: completed_transactions.php");
        } else {
            // Error message as a JavaScript alert
            echo '<script>alert("Error updating pickup status: ' . $con->error . '");</script>';
        }
    }
    ?>

    <div class="search_resultcontainer">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Amount paid</th>
                    <th>Payment Date</th>
                    <th>Order Number</th>
                    <th>Pickup Location</th>
                    <th>Payment Status</th>
                    <th>Payment Description</th>
                    <th>Pickup_status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $amount = $row['amount'];
                        $date = $row['payment_date'];
                        $orderNumber = $row['order_number'];
                        $paymentStatus = $row['payment_status'];
                        $paymentDescription = $row['payment_description'];
                        $pickup_location = $row['pickup_location'];
                        $pickup_status = $row['pickup_status'];
                        echo '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $name . '</td>
                            <td>' . $amount . '</td>
                            <td>' . $date . '</td>
                            <td>' . $orderNumber . '</td>
                            <td>' . $pickup_location . '</td>
                            <td>' . $paymentStatus . '</td>
                            <td>' . $paymentDescription . '</td>
                            <td>' . $pickup_status . '</td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="orderNumber" value="' . $orderNumber . '">
                                    <button type="submit">Confirm!</button>
                                </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="10">No results found/ Payment completed.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        /* Set the width of the sidebar to 250px (show it) */
        function openNav() {
            document.getElementById("mySidepanel").style.width = "75%";
        }
        /* Set the width of the sidebar to 0 (hide it) */
        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
</body>
</html>
