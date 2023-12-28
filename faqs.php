<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Welcome to LionReads.com.ng, your trusted academic companion for the University of Nigeria (UNN). Do you have questions on how and why we operate, visit our website now to explore our seamless platform to find and effortlessly purchase required textbooks. Boost your academic journey with LionReads, your UNN mobile bookshop. Stay updated with news, memes, and valuable insights.">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="faqs.css">
    <title>Frequently Asked Questions | LionReads.com</title>
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
    <!-- include navbar -->
    <?php include "sidepanel.php";?>
    <!-- navbar ends. -->

   <section>
        <main>
             <!-- Faqs begins -->
            <div class="faqs_container">
                <h1>Frequently Asked Questions</h1>

                <h5>
                    Everything you need to know about LionReads. 
                    Please chat our team for more <a href="">information.</a>
                </h5>

                <div class="faqs">
                    <header>
                        <h3>How to get a book on LionReads?</h3>
                    </header>
                    <details>
                        <summary>See more..</summary>
                        <p>
                            STEP 1: <br>
                            simply access the sidepanel by clicking the icon on the top left corner of your screen, navigate to the bookshop and search for the book you want to purchase.
                        </p>

                        <p>
                            Next you click on it and select the quantity you want using the plus or minus buttons. Then you click on add cart to add this book to your cart and either continue to search for more books or to checkout your cart and pay.
                        </p>
                    </details>
                </div>

                <div class="faqs">
                    <header>
                        <h3>Can i pay with bank transfer?</h3>
                    </header>
                    <details>
                        <summary>See more..</summary>
                        <p>
                            Yes you can, also we have made provisions for payments with atm cards or direct bank transfers. Do make sure to download your receipt as pdf or a picture on successful payment.
                        </p>
                    </details>
                </div>

                <div class="faqs">
                    <header>
                        <h3>How to checkout my cart?</h3>
                    </header>
                    <details>
                        <summary>See more..</summary>
                        <p>
                            Kindly click on the cart button or the cart icon at the top right of your screen to access your cart, click on pay after verifying the total amount to be paid and make your payments.
                        </p>
                    </details>
                </div>

                <div class="more_questions">
                    <header>
                        <h3>
                        Still got questions?
                        </h3>
                    </header>

                    <details>
                        <summary>See more..</summary>
                        <p>
                            Do you still have a question for us or you have a technical issue to give us feedback on, kindly send us a message through the below form or dop a message on our official support community on Whatsapp.
                        </p>
                    </details>
                    <br>

                    <form method="post">
                        <input type="text" class="questions" placeholder="Send your Questions" name="questions">
                        <input type="submit" value="Send message" name="submit" class="submit_message">
                    </form>
                </div>
            </div>
        </main>
   </section>
    
    <!-- include footer -->
    <?php include "footer.php";?>



<script>        
        /* Set the width of the sidebar to 250px (show it) */
    function openNav() {
        document.getElementById("mySidepanel").style.width = "75%";
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
</script>

    
</body>
</html>