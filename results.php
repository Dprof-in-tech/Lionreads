<!-- // search_results.php -->
<?php
// set the session timeout to 5 minutes
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(300);

// start the session
session_start();

// regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// set the last activity time to the current time
$_SESSION['last_activity'] = time();

// check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    // session timed out, destroy the session
    session_unset();
    session_destroy();
    header("location: home.php");
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
    <link rel="stylesheet" href="../bookshop.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <title>Receipt Results | LionReads</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "adminSidepanel.php";?>

    <?php
// connect to the database
require "./db.php";
// retrieve the search query from the form submission
$search_query = $_GET['query'];

// construct the SQL query to search for products that match the search query
$sql = "SELECT * FROM customer_details WHERE order_number = '%$search_query%'";

// execute the query and retrieve the search results
$result = mysqli_query($con, $sql);
//Search results



?>

    <div class="search_resultcontainer">
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Reference</th>
      <th scope="col">Order Number</th>
      <th scope="col">Payment Status</th>
      <th scope="col">Payment Description</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $name = $row['name'];
          $phone = $row['phone'];
          $reference = $row['reference'];
          $orderNumber = $row['order_number'];
          $paymentStatus = $row['payment_status'];
          $paymentDescription = $row['payment_description'];
          echo '
    <tr>
      <th scope="row">' . $id . '</th>
      <td>' . $name . '</td>
      <td>' . $phone . '</td>
      <td>' . $reference . '</td>
      <td>' . $orderNumber . '</td>
      <td>' . $paymentStatus . '</td>
      <td>' . $paymentDescription . '</td>
      </tr>';
      }
  }
  ?>
     
  </tbody>
</table>


        <!-- include footer -->
        <div class="copyright_2">
            <h5>Copyright @ LionReads, 2023</h5>
        </div>
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

