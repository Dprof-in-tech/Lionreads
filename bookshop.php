<?php
        // set the session timeout to 5 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);

// start the session
session_start();

// regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// set the last activity time to the current time
$_SESSION['last_activity'] = time();

// check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    // session timed out, destroy the session
    session_unset();
    session_destroy();
    header("location: home.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to LionReads.com.ng, your trusted academic companion for the University of Nigeria (UNN). Explore our seamless platform to find and effortlessly purchase required textbooks. Boost your academic journey with LionReads, your UNN mobile bookshop. Stay updated with news, memes, and valuable insights.">
    <link rel="stylesheet" href="bookshop.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <title>LionReads Bookshop | Get your Books quick and Easy</title>
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
<body>
    <!-- Include Navbar -->
    <?php include 'sidepanel.php'; ?>
    <!-- Navbar ends. -->

    <!-- welcome section -->
    <div class="welcome_text">
        <h3>Get more done with books available in the Bookshop</h3>
    </div>
    <!-- welcome ends. -->

    <div id="message-container" style="display: none;">
        <div id="message"><?php echo $message;?></div>
    </div>
    <!-- Bestseller section begins -->
    <div class="bestseller_container">
        <h3>Bestsellers</h3>
        <div class="search_container">
            <!-- search_form.php -->
            <form method="GET" action="search_results.php" class="search-form">
                <input type="search" name="query" placeholder="Search books..." class="search">
                <button type="submit" class="search_button" >Search</button>
            </form>
        </div>

        <!-- // search_results.php -->
        <!-- books begin -->
        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 7";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>
        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    
                    
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div>
            

        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 3";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>

        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    
                    
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div>

        
        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 4";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>

        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div>

        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 5";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>

        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div> 

        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 9";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>
        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    
                    
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div>
            

        <?php
                    include "config.php";
                     $sql = "SELECT * FROM books where id = 11";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $book_title = $row['book_title'];
                        $book_author = $row['book_author'];
                        $book_price = $row['book_price'];
                        $book_image = $row['book_image'];
                  }
                }
                ?>

        <div class="book_container">
            <div class="book_picture">
            <img src="./img/<?php echo $book_image;?>" alt="Design of Everyday things.">
            </div>
           
            <div class="book_text">
                <div class="b-left">
                    <h2><?php echo $book_title;?></h2>
                    <h5><?php echo $book_author;?></h5>
                </div>
                
                <div class="b-right">
                    <form  method="post">
                    <h3>N<?php echo $book_price; ?></h3> 
                    
                    
                    <input type="hidden" name="book_id" value="<?php echo $book_title;?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_price;?>">
                    <div class="quantity">
                        <h5>Quantity</h5>
                        <span>
                        <button class="minus-btn" type="button" name="button" id="minus_btn">-</button>
                        <input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">
                        <button class="plus-btn" type="button" name="button" id="plus_btn">+</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="buy_button" name="add_to_cart" >Add 2 Cart</button>
                <a href="cart.php" class="view_cart" ><i class="fa-solid fa-cart-shopping"></i> Cart</a>
            </div>
            </form>
        </div>


    </div>

    <!-- welcome section -->
    <!-- <div class="welcome_text">
        <h3>90% of Students who use lionreads report
            receiving higher grades
        </h3>
    </div> -->
    <!-- welcome ends. -->

    <!-- PDF section begins -->

    <div class="pdf_container">
            <div class="pdf_picture">
                <img src="./img/book4.jpg" alt="Design of Everyday things.">
            </div>
           
            <div class="pdf_text">
                <h4>Download books, 
                    pdf & more for free
                </h4>

                <h5>
                    Stay on top of it with homework help, 
                    exam prep & writing support with wide
                    range of books made available. 
                </h5>
            </div>
            <div class="download_button">
                <a href="">Download Now</a>
            </div>
        </div>

        <!-- Include footer -->
        <?php include "footer.php"; ?>




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

    <script>
        // JavaScript code to handle quantity input and buttons
        let plusBtns = document.querySelectorAll(".plus-btn");
        let minusBtns = document.querySelectorAll(".minus-btn");
        let quantityInputs = document.querySelectorAll(".quantity input");

        plusBtns.forEach((plusBtn, index) => {
            plusBtn.addEventListener('click', function(e){
                e.preventDefault();
                let inputValue = parseInt(quantityInputs[index].value);
                if (!isNaN(inputValue)) {
                    quantityInputs[index].value = inputValue + 1;
                }
            });
        });

        minusBtns.forEach((minusBtn, index) => {
            minusBtn.addEventListener('click', function(e){
                e.preventDefault();
                let inputValue = parseInt(quantityInputs[index].value);
                if (!isNaN(inputValue) && inputValue > 0) {
                    quantityInputs[index].value = inputValue - 1;
                }
            });
        });
    </script>

    <?php
        
$message = "Book added successfully";
// update the last activity time
$_SESSION['last_activity'] = time();

        if(isset($_POST['add_to_cart'])){
            // Get the product ID and quantity from the form submission
            $book_id = $_POST['book_id'];
            $quantity = $_POST['quantity'];
            $book_price = $_POST['book_price'];
    
            // Check if the product is already in the cart
            if(isset($_SESSION['cart'][$book_id])){
                // If the product is already in the cart, increment the quantity
                $_SESSION['cart'][$book_id]['quantity'] += $quantity;
            }else{
                // If the product is not yet in the cart, add it
                $_SESSION['cart'][$book_id] = array(
                    'quantity' => $quantity,
                    'book_id' => $book_id,
                    'price' => $book_price
                    
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

        }
    ?>
</body>
</html>