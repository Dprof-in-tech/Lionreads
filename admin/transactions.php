<?php
 // Set session cookie lifetime to 30 minutes (adjust as needed)
$sessionLifetime = 1800; // 5 minutes in seconds
session_set_cookie_params($sessionLifetime);
 // start the session
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
    <title>Transaction History | LionReads</title>
</head>
<body>
    <a href="admin.php"><h1 class="btn btn-primary mt-3 ">Dashboard</h1></a>
    <a href="books.php"><h1 class="btn btn-primary mt-3 ">Books</h1></a>
    <a href="truncate.php? truncate-table=' . $id . '"><h1 class="btn btn-danger btn-primary mt-3">Truncate</h1></a>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col"> Status</th>
      <th scope="col">Amount</th>
      <th scope="col">Order Number</th>
      <th scope="col">Phone</th>
      <th scope="col">Pickup Location</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>

  <?php
  include "../config.php";
  $sql = "SELECT * FROM customer_details";
  $result = mysqli_query($con, $sql);
  $rowcount = mysqli_num_rows($result);
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
      <td>' . $amount . '</td>
      <td>' . $order_number . '</td>
      <td>' . $phone . '</td>
      <td>' . $location .'</td>
      <td>' . $date . '</td>
      </tr>';
      }
  }
  ?>
     
  </tbody>
</table>
</body>
</html>