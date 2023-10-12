<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    // set the session timeout to 5 minutes
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

// start the session
session_start();

// regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// set the last activity time to the current time
$_SESSION['last_activity'] = time();

// check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    // session timed out, destroy the session
    session_unset();
    session_destroy();
    header("location: bookshop.php");
}

// update the last activity time
$_SESSION['last_activity'] = time();

    $session_id = session_id();
    $customPrefix = "LR"; // Your desired text prefix
    $customNumber = rand(9, 99); // Your desired custom number
    $order_number = $customPrefix . uniqid($customNumber, false);

     // Output: LR62c47178a1f55.12512953
   
    
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    // Check if the "Remove" button has been clicked
    if(isset($_POST['remove_item'])) {
        // Get the product ID to remove from the cart
        $remove_book = $_POST['remove_item'];
    
        // Loop through the items in the cart to find the item with the matching product ID
        foreach($_SESSION['cart'] as $key => $item) {
            // Check if the item has the matching product ID
            if($item['book_id'] == $remove_book) {
                // Remove the item from the cart by unsetting it from the $_SESSION['cart'] array
                unset($_SESSION['cart'][$key]);  
                header('Location: cart.php');
                exit();       
            }
             
        }   
        
    }


    
   
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <link rel="stylesheet" href="checkout.css">
    <title>Shopping Cart</title>
</head>
<body>
    <!-- include sidepanel -->
    <?php include "sidepanel.php"; ?> 

    <!-- cart begins -->
    <div class="cart_container">
        <h1>Shopping Cart</h1>
        <?php if (count($cart) > 0): ?>
        <table class="cart_table">
            <thead>
                <tr>
                    <th>Book </th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total = 0;
                    $total_charges = 0;
                    $charges = 250;
                    $amount = 0;
                    $total_quantity= 0;
                    foreach ($cart as $item):
                        $book_name = $item['book_id'];
                        $quantity = $item['quantity'];
                        $price = $item['price'];
                        $book_no = $item['id'];
                        // replace with the actual price from the database
                        $amount +=  $price * $quantity;
                        $total_charges += $charges * $quantity;
                        $total = $amount + $total_charges;
                        $total_quantity += $quantity;   
                ?>
                    <tr>
                        <td id="book_names" class="book_names" ><?php echo $book_name; ?>, <?php echo $quantity; ?> Copies</td>
                        <td>N<?php echo $price; ?></td>
                        <input type="hidden" name="book_charges" value="<?php echo $charges;?>">
                      
                        <td>
                            <form method='post'><input type='hidden' name='remove_item' value='<?php echo $book_name;?>'>
                                <button type='submit' class='delete_btn'><i class="fa-solid fa-trash-can" style="color: black;" ></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php 
                $discount = 0;
                  if ($total_quantity >= 4){
                    $discount += 0.15 * 250 *$total_quantity;
                    $total_charges -= $discount;
                    $total = $amount += $total_charges;
                  }
                ?>
                <tr>
                    <td colspan="2" style="text-align: right;"> charges: <?php echo $total_charges;?>.. Discount: <?php echo $discount;?>.. Total:</td>
                    <td>N<?php echo $total; ?></td>                    
                </tr>
                </tbody>
        </table>
        <button class="checkout_button" id="checkout_button" >Checkout</button>
        <?php else: ?>
        <p>Your cart is empty.</p>
        <?php endif; ?>
        <p><a href="bookshop.php">Continue shopping, click here..</a></p>

        
    </div>
    
    <!-- Checkout Modal -->
<div id="checkoutModal" class="modal">
  <div class="modal-content">
    <span id="close_checkout" class="close">&times;</span>
    <h2>Checkout</h2>
    <form id="paymentForm" method="post" action= "process_payment.php" >
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email-address" name="email_address" required />
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input type="tel" id="amount" value="<?php echo $total;?>" disabled/>
    <input type="hidden" name="amount_paid" value="<?php echo $total;?>">
  </div>
  <div class="form-group">
    <label for="name"> Name</label>
    <input type="text" id="customer_name" name="name"/>
    <input type="hidden" name="order_number" value="<?php echo $order_number;?>">
  </div>
  <div class="form-group">
    <label for="phone_number">Phone Number</label>
    <input type="text" id="phone_number" name="phone_number" />
    <input type="hidden" name="session_id" value="<?php echo $session_id;?>">
    <input type="hidden" id="books" name="books_paid_for" value="<?php echo $book_name . $quantity;?>" >
  </div>
  <div class="form-group">
  <label for="location">Choose your Pickup Location</label>
        <select id="location" name="location">
            <option value="engine-chitis">Engine Chitis</option>
            <option value="sub">S.U.B</option>
            <option value="stadium">Stadium</option>
        </select>
  </div>
  <div class="form-group">
      <h3>
        By clicking on Pay, you agree to our terms and conditions for pickup as stated <a href="pickup-policy.php">here</a>.
      </h3>
  </div>
  <div class="form-submit">
    <button type="submit" class="buy-btn" name="pay_for_books"> Pay </button>
  </div>
</form>
  </div>
</div>

<!-- 
<script src="https://js.paystack.co/v1/inline.js"></script>  -->
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
      // Get all the book name elements
      const bookNameElements = document.querySelectorAll('.book_names');

      // Initialize an empty array to store the book names and quantities
      const bookValues = [];

      // Loop through the book name elements and extract the book name and quantity
      bookNameElements.forEach(element => {
        const bookName = element.textContent.split(',')[0].trim();
        const quantity = element.textContent.split(',')[1].trim().split(' ')[0];
        bookValues.push(`${bookName} (${quantity})`);
      });

      // Join the array elements into a string using a separator of your choice
      const concatenatedInputs = bookValues.join(', ');

      document.getElementById("checkout_button").addEventListener("click", function () {
        // Get the modal
        let modal = document.querySelector(".modal");
        // When the user clicks the button, open the modal
        let closeModal = document.getElementById("close_checkout");

        // When the user clicks on span (x), close the modal
        closeModal.addEventListener('click', function () {
            document.querySelector(".modal").style.display = "none";
        });

        let bookValues = [];
        <?php foreach ($_SESSION['cart'] as $item): ?>
            let bookname_<?php echo $item['id']; ?> = "<?php echo $item['book_id']; ?>";
            let quantity_<?php echo $item['id']; ?> = "<?php echo $item['quantity']; ?>";
            bookValues.push({ bookname: bookname_<?php echo $item['id']; ?>, quantity: quantity_<?php echo $item['id']; ?> });
        <?php endforeach; ?>

        let allBooksAvailable = true;

        // Initialize an array to store the names of unavailable books
        let unavailableBooks = [];

        // Loop through the book values and perform an AJAX request for each book
        bookValues.forEach(item => {
            let bookName = item.bookname;
            let quantityPurchased = item.quantity;

            // Send an AJAX request to check book availability
            fetch('check_availability.php?bookName=' + encodeURIComponent(bookName) + '&quantity=' + quantityPurchased)
                .then(response => response.json())
                .then(data => {
                    if (!data.available) {
                        // Book is not available, add it to the array of unavailable books
                        unavailableBooks.push(bookName);
                    }
                });
        });

        // After all AJAX requests have completed, check if any books are unavailable
        Promise.all(bookValues.map(item => {
            let bookName = item.bookname;
            return fetch('check_availability.php?bookName=' + encodeURIComponent(bookName) + '&quantity=' + item.quantity)
                .then(response => response.json())
                .then(data => {
                    if (!data.available) {
                        // Book is not available, add it to the array of unavailable books
                        unavailableBooks.push(bookName);
                    }
                });
        })).then(() => {
            if (unavailableBooks.length > 0) {
                // Redirect to the error page with the list of unavailable books as a parameter
                window.location.href = 'outOfStock_error.php?unavailableBooks=' + encodeURIComponent(unavailableBooks.join(','));
            } else {
                // All books are available, proceed with checkout
                 // Send the concatenatedInputs value to the PHP script via AJAX
            fetch('send_inputs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'concatenatedInputs=' + encodeURIComponent(concatenatedInputs),
            })
            .then(response => response.text())
            .then(responseText => {
                // Handle the response from the server (if needed)
                console.log(responseText);

                // Open the checkout modal
                document.querySelector(".modal").style.display = "block";
            })
            .catch(error => {
                console.error('Error sending concatenatedInputs:', error);
            });
        }
        });
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        document.querySelector(".modal").style.display = "none";
      }
    }

    </script>
</body>
</html>