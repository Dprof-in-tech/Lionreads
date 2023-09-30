
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
                    foreach ($cart as $item):
                        $book_name = $item['book_id'];
                        $quantity = $item['quantity'];
                        $price = $item['price'];
                        // replace with the actual price from the database
                        $amount +=  $price * $quantity;
                        $total_charges += $charges * $quantity;
                        $total = $amount + $total_charges;

                        
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
                <tr>
                    <td colspan="2" style="text-align: right;"> charges: <?php echo $total_charges;?>.. Total:</td>
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
    <form id="paymentForm" method="post" onsubmit="payWithPaystack()" >
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email-address" required />
    <input type="hidden" name="" value="">
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input type="tel" id="amount" name="amount_paid" value="<?php echo $total;?>" disabled/>
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
    <input type="hidden" id="books" name="books_paid_for" value="<?php echo $book_name;?>" >
  </div>
  <div class="form-group">
  <label for="location">Choose your Pickup Location</label>
        <select id="location" name="location">
            <option value="engine-chitis">Engine Chitis</option>
            <option value="gs-building">GS Building</option>
            <option value="sub">S.U.B</option>
            <option value="stadium">Stadium</option>
        </select>
  </div>
  <div class="form-submit">
    <button type="submit" class="buy-btn" onclick="payWithPaystack()" name="pay_for_books"> Pay </button>
  </div>
</form>

    <?php
    if(isset($_POST['pay_for_books'])){
  // Get the product ID and quantity from the form submission
  $email = $_POST['email_address'];
  $amount_paid = $_POST['amount_paid'];
  $name = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  $order_number = $_POST['order_number'];
  $session_id = $_POST['session_id'];
  $books_Paidfor =  $_POST['books_paid_for'];
  $location = $_POST['location'];

    // Set session variables
    $_SESSION['email_address'] = $email;
    $_SESSION['amount_paid'] = $amount_paid;
    $_SESSION['name'] = $name;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['order_number'] = $order_number;
    $_SESSION['session_id'] = $session_id;
    $_SESSION['books_paid_for'] = $books_Paidfor;
    $_SESSION['location'] = $location;
  }

    
    ?>

  </div>
</div>


<script src="https://js.paystack.co/v1/inline.js"></script> 
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
    // Get the modal
    let modal =     document.querySelector(".modal");
// When the user clicks the button, open the modal
let openModal =  document.getElementById("checkout_button");
let closeModal = document.getElementById("close_checkout");

openModal.addEventListener('click', function(){
    document.querySelector(".modal").style.display = "block";
})
// When the user clicks on <span> (x), close the modal
 closeModal.addEventListener('click', function(){
    document.querySelector(".modal").style.display = "none";
 })

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    document.querySelector(".modal").style.display = "none";
  }
}
    </script>
    <script>
        const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);
function payWithPaystack(e) {
  e.preventDefault();
  let email = document.getElementById('email-address').value;
  let books = document.getElementById('books').value;
    let amountPaid = document.getElementById('amount').value;
    let name = document.getElementById('customer_name').value;
    let phone_number = document.getElementById('phone_number').value;
    let location = document.getElementById('location').value;
    let order_number = '<?php echo $order_number;?>';
    let session_id = '<?php echo $session_id;?>';

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
// Output the concatenated string


     // Create a Paystack transaction object
     let handler = PaystackPop.setup({
      key: 'pk_live_669da5a653365e22482c52a90fdaeb32039a90ad',
      email: email,
      phone: phone_number,
      amount: amountPaid * 100,
      location: location,
      currency: 'NGN',
      metadata: {
        custom_fields: [
          {
            display_name: "Order Number",
            variable_name: "order_number",
            value: order_number
          },
          {
            display_name: "Session ID",
            variable_name: "session_id",
            value: session_id
          },
          {
            display_name: "Payment Description",
            variable_name: "payment_description",
            value: concatenatedInputs
          }
        ]
      },
      callback: function(response) {
        // The payment was successful, redirect to receipt page
        window.location.href = 'verify_payment.php?reference=' + response.reference + '&name=' + name + '&order_number=' + order_number + '&amount=' + amountPaid + '&location=' + location + '&description=' + concatenatedInputs;
      },
      onClose: function() {
        alert('Payment cancelled');
      }
    });

    // Open the Paystack payment modal
    handler.openIframe();
  }
    </script>

   
</body>
</html>

