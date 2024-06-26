<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Welcome to LionReads.com.ng, your trusted academic companion for the University of Nigeria (UNN). Explore our seamless platform to find and effortlessly purchase required textbooks. Boost your academic journey with LionReads, your UNN mobile bookshop. Contact us today.">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <meta name="google-adsense-account" content="ca-pub-3266488601163483">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact.css">
    <title>Contact Us today! | lionreads.com</title>
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

    <!-- contact form starts -->
    <section>
        <main>
        <div class="contact_form">
        <h1>
            Contact Us
        </h1>

        <h3>
            We will like to hear from you
        </h3>
        <form action="recieve-messages.php" method="post" class="contact-form">
            <input type="text" name="name" placeholder="Your Name." class="name">
            <input type="email" name="email" id="email" placeholder="Email" class="email" >
            <input type="tel" name="phone" id="number" placeholder="Phone Number" class="phone_number" >
            <textarea name="message" id="message" placeholder="Message" class="message"></textarea>
            <input type="submit" value="Send Message" name="Send_message" class="send_message">
        </form>
    </div>
        </main>
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
</script>
</body>
</html>