<?php
session_start();
// Retrieve the list of out of stock books from the query parameter
$out_of_stock_books_str = isset($_GET['unavailableBooks']) ? $_GET['unavailableBooks'] : '';
$out_of_stock_books = explode(',', $out_of_stock_books_str);

// Remove duplicate values from the array
$out_of_stock_books = array_unique($out_of_stock_books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <title>Out of Stock | Lionreads your mobile bookstore..</title>
    <style>
        body {
            font-family: 'JetBrains Mono', sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 50px;
        }

        .error-message {
            background-color: #ff6347; /* Tomato Red */
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-link {
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-136R1N2W7G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-136R1N2W7G');
</script>
<body>
    <div class="error-message">
        <h1>Out of Stock</h1>
        <p>The following books are out of stock:</p>
        <ul>
            <?php foreach ($out_of_stock_books as $book): ?>
                <li><?php echo $book; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Please remove these books from your cart to continue shopping as they are not available in your needed quantity.. Kindly check the available quantity for this book....</p>
        <p>You can <a href="index.php?route=cart">return to the cart</a> to remove these books or you can <a href="index.php?route=bookshop">head on to the bookshop</a> to see more of our products.</p>
    </div>
</body>
</html>
