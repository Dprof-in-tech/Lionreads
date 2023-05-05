<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="faqs.css">
    <title>Frequently Asked Questions | LionReadz.com</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "sidepanel.php";?>
    <!-- navbar ends. -->

    <!-- Faqs begins -->
    <div class="faqs_container">
        <h1>Frequently Asked Questions</h1>

        <h5>
            Everything you need to know about LionReadz. 
            Please chat our team for more <a href="">information.</a>
        </h5>

        <div class="faqs">
            <header>
                <h3>How to get a book on LionReadz?</h3>
            </header>
            <p>
                Lorem ipsum dolor sit amet consectetur 
                adipisicing elit. Minima possimusea cupiditate officiis 
                velit ullam
            </p>
        </div>

        <div class="faqs">
            <header>
                <h3>How to get a book on LionReadz?</h3>
            </header>
            <p>
                Lorem ipsum dolor sit amet consectetur 
                adipisicing elit. Minima possimusea cupiditate officiis 
                velit ullam
            </p>
        </div>

        <div class="faqs">
            <header>
                <h3>How to get a book on LionReadz?</h3>
            </header>
            <p>
                Lorem ipsum dolor sit amet consectetur 
                adipisicing elit. Minima possimusea cupiditate officiis 
                velit ullam
            </p>
        </div>

        <div class="more_questions">
            <header>
                <h3>
                Still got questions?
                </h3>
            </header>

            <p>
                Lorem ipsum dolor sit amet consectetur 
                adipisicing elit. Minima possimusea cupiditate officiis 
                velit ullam 
            </p>

            <input type="text" class="questions" placeholder="Send your Questions" name="questions">
            <input type="submit" value="Send message" class="submit_message">
        </div>
    </div>
    
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
</script>

    
</body>
</html>