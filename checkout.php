<?php
    // set the session timeout to 5 minutes
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
    header("location: index.php?route=bookshop");
}

// update the last activity time
$_SESSION['last_activity'] = time();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="checkout.css">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <title>Checkout your Cart | lionreads.com</title>
    <style>
        #message-container {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 999;
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
    <!-- include sidepanel -->
    <?php include "sidepanel.php";?>
    <div id="message-container" style="display: none;">
        <div id="message"><?php echo $message;?></div>
    </div>

    <section>
        <main class="main-content-container">
             <!-- Checkout begins -->
            <div class="book_container">
                    <!-- // product_detail.php -->
                    <?php
                    // connect to the database
                    include "config.php";

                    // retrieve the product ID from the URL query parameter
                    $book_id = $_GET['id'];
                    

                    // construct the SQL query to retrieve the product information based on the product ID
                    $sql = "SELECT * FROM books WHERE id = $book_id";

                    // execute the query and retrieve the product information
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $book_title = $row['book_title'];
                    $book_image = $row['book_image'];
                    $book_price = $row['book_price'];
                    $book_no = $row['id'];
                ?>

                    <div class="book_picture">
                        <!-- display the product information in the HTML markup for the product detail page -->
                    <img src="<?php echo "./img/$book_image"; ?>" alt="<?php echo $row['book_title']; ?>">
                    </div>
                
                    <div class="book_text">
                        <div class="b-left">
                            <h2><?php echo $row['book_title']; ?></h2>
                            <h5><?php echo $row['book_author']; ?></h5>
                        </div>
                        <div class="b-right">
                            <form  method="post">
                                <h3>N<?php echo $book_price; ?></h3> 
                                
                                <input type="hidden" name="book_charges" value="300" >
                                <input type="hidden" name="book_no" value="<?php echo $book_no;?>">
                                <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                                <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                                <div class="quantity">
                                    <h5>Quantity</h5>
                                    <span>
                                    <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                                    <input type="text" name="quantity" value="1" id="quantity_input">
                                    <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="buttons">
                            <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                            <a href="index.php?route=cart" class="view_cart"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                        </div>
                    </form>
                </div>

                <div class="bestseller-books">
                    <header>
                        <h2>
                            Bestsellers.....
                        </h2>
                    </header>
                    <div class="bestseller-book-container">
                        <div class="bestseller-book">
                            <img src="img/introduction-to-entrepreneurship.jpg" alt="" loading="lazy">
                        </div>
                        <div class="bestseller-book">
                            <img src="img/computer-science.jpg" alt="" loading="lazy">
                        </div>
                    </div>
                </div>
        </main>
    </section>
   
    <section>
        <div class="search_container">
                <!-- search_form.php -->
                <form method="GET" action="search_results.php">
                    <input type="text" name="query" placeholder="Search for more books..." class="search">
                    <input type="submit" name="submit" value="Search"/>
                </form>
            </div>
    </section>

    <!-- include footer -->
    <?php include "footer.php";?>

    <script>        
        /* Set the width of the sidebar to 250px (show it) */
    function openNav() {
 document.getElementById("mySidepanel").style.width = "40%";
    }
    /* Set the width of the sidebar to 0 (hide it) */
    function closeNav() {
       document.getElementById("mySidepanel").style.width = "0";
    }

    // Function to close side panel if clicked outside
    window.addEventListener('click', function(event) {
    const sidePanel = document.getElementById('mySidepanel');
    const openButton = document.querySelector('.openbtn');

    // Close the side panel if the click is outside the panel and not on the open button
    if (event.target !== sidePanel && event.target !== openButton && !sidePanel.contains(event.target)) {
        closeNav();
    }
    });

    let input = document.getElementById('quantity_input');
    let plusBtn = document.getElementById("plus_btn");
    let minusBtn = document.getElementById("minus_btn");

    plusBtn.addEventListener('click', function(e){
        e.preventDefault();
        if(input.value < 0){
            return
        }else{
            input.value++;
        }
    })

    minusBtn.addEventListener('click', function(e){
        e.preventDefault();
        if(input.value > 0){
            input.value--;
        }else{
            return
        }
    })



</script>
<?php
    $message = "Book added successfully";
    if(isset($_POST['add_to_cart'])){
        // Get the product ID and quantity from the form submission
        $book_id = $_POST['book_id'];
        $quantity = $_POST['quantity'];
        $book_price = $_POST['book_price'];
        $book_charges = $_POST['book_charges'];
        $book_no =$_POST['book_no'];

        // Check if the product is already in the cart
        if(isset($_SESSION['cart'][$book_id])){
            // If the product is already in the cart, increment the quantity
            $_SESSION['cart'][$book_id]['quantity'] += $quantity;
        }else{
            // If the product is not yet in the cart, add it
            $_SESSION['cart'][$book_id] = array(
                'quantity' => $quantity,
                'book_id' => $book_id,
                'price' => $book_price,
                'charges' => $book_charges,
                'id' => $book_no
                
            );
        }

        // Book successfully added to cart, trigger an alert
        echo '<script>
        function showMessage(message) {
            const messageContainer = document.getElementById("message-container");
            const messageElement = document.getElementById("message");
            messageElement.textContent = message;

            messageContainer.style.display = "block";

            setTimeout(function() {
                messageContainer.style.display = "none";
            }, 3000); // Hide the message after 3 seconds
        }

        // Call this function to display the message
        showMessage("' . $message . '");
        </script>';

        // Redirect to a different page after adding the book to the cart
        header("Location: index.php?route=checkout");
        exit;
    }
?>
</body>
</html>