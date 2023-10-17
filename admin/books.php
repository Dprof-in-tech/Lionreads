<?php
// Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 2300; // 5 minutes in seconds
 session_set_cookie_params($sessionLifetime);

 // start the session
 session_start();
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
  
  
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
    <title>Books Library | LionReads</title>
</head>
<body>
    <a href="admin.php"><h1 class="btn btn-primary mt-3 ">Dashboard</h1></a>
    <a href="transactions.php"><h1 class="btn btn-primary mt-3 ">Sales</h1></a>
    <a href="truncate1.php? truncate-table=' . $id . '"><h1 class="btn btn-danger btn-primary mt-3">Truncate</h1></a>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Image</th>
      <th scope="col">Author</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>

  <?php
  include "../config.php";
  $sql = "SELECT * FROM books";
  $result = mysqli_query($con, $sql);
  $rowcount = mysqli_num_rows($result);
  if ($rowcount > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $name = $row['book_title'];
          $image = $row['book_image'];
          $author = $row['book_author'];
          $price = $row['book_price'];
          echo '
    <tr>
      <th scope="row">' . $id . '</th>
      <td>' . $name . '</td>
      <td>' . $image . '</td>
      <td>' . $author . '</td>
      <td>' . $price . '</td>
      </tr>';
      }
  }
  ?>
     
  </tbody>
</table>
</body>
</html>