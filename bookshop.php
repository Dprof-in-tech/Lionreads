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
    header("location: index.php");
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
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
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
        <div class="search_container">
            <!-- search_form.php -->
            <form method="GET" action="search_results.php" class="search-form">
                <input type="search" name="query" placeholder="Search books..." class="search">
                <button type="submit" class="search_button" >Search</button>
            </form>
        </div>

        <!-- // search_results.php -->
        <!-- books begin -->
        <!-- // Fetch all books from the database -->
        <?php
            include "config.php";
            $sql = "SELECT * FROM books";
            $result = mysqli_query($con, $sql);
            
            // Check if there are books in the database
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $book_title = $row['book_title'];
                    $book_author = $row['book_author'];
                    $book_price = $row['book_price'];
                    $book_image = $row['book_image'];
                    $book_no = $row['id'];

                    // Your HTML code to display each book goes here
                    echo '<div class="book_container">';
                    echo '<div class="book_picture">';
                    echo '<img src="./img/' . $book_image . '" alt="' . $book_title . '">';
                    echo '</div>';

                    echo '<div class="book_text">';
                    echo '<div class="b-left">';
                    echo '<h2>' . $book_title . '</h2>';
                    echo '<h5>' . $book_author . '</h5>';
                    echo '</div>';
                    
                    echo '<div class="b-right">';
                    echo '<form method="post">';
                    echo '<h3>N' . $book_price . '</h3>';
                    echo '<input type="hidden" name="book_no" value="' . $book_no . '">';
                    echo '<input type="hidden" name="book_id" value="' . $book_title . '">';
                    echo '<input type="hidden" name="book_price" value="' . $book_price . '">';
                    
                    echo '<div class="quantity">';
                    echo '<h5>Quantity</h5>';
                    echo '<span>';
                    echo '<button class="minus-btn" type="button" name="button" id="minus_btn">-</button>';
                    echo '<input type="text" name="quantity" value="1" id="quantity_input" class="quantity-input">';
                    echo '<button class="plus-btn" type="button" name="button" id="plus_btn">+</button>';
                    echo '</span>';
                    echo '</div>';
                    echo '</div>';
                    
                    echo '</div>';

                    echo '<div class="buttons">';
                    echo '<button type="submit" class="buy_button" name="add_to_cart">Add to Cart</button>';
                    echo '<a href="cart.php" class="view_cart"><i class="fa-solid fa-cart-shopping"></i> Cart</a>';
                    echo '</div>';
                    
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                // No books found in the database
                echo '<p>No books found.</p>';
            }
            
            // Your existing code...

            // Scroll to top and bottom buttons
            echo '<div class="scroll-buttons">
            <button id="scroll-to-top" class="scroll-button"><i class="fa-solid fa-arrow-up"></i></button>
            <button id="scroll-to-bottom" class="scroll-button"><i class="fa-solid fa-arrow-down"></i></button>            
            </div>';
        ?>

    <!-- welcome section -->
    <!-- <div class="welcome_text">
        <h3>90% of Students who use lionreads report
            receiving higher grades
        </h3>
    </div> -->
    <!-- welcome ends. -->

    <!-- PDF section begins -->

    <!-- <div class="pdf_container">
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
        </div> -->

        <!-- Include footer -->
        <?php include "footer.php"; ?>


    <script>
        const scrollToTopButton = document.getElementById('scroll-to-top');
        const scrollToBottomButton = document.getElementById('scroll-to-bottom');

        window.addEventListener('scroll', () => {
        // Display the scroll-to-top button when scrolling down
        if (window.scrollY > 100) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }

        // Display the scroll-to-bottom button when scrolling up
        if (window.scrollY < document.body.scrollHeight - window.innerHeight - 100) {
            scrollToBottomButton.style.display = 'block';
        } else {
            scrollToBottomButton.style.display = 'none';
        }
        });

        scrollToTopButton.addEventListener('click', () => {
        // Scroll to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
        });

        scrollToBottomButton.addEventListener('click', () => {
        // Scroll to the bottom of the page
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth',
        });
        });
            </script>

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
            $book_no = $_POST['book_no'];
    
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

        }
    ?>
</body>
</html>