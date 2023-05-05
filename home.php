<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LionReadz | Your UNN mobile Bookshop</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
</head>
<body>
   <!-- Include Navbar -->
   <?php include 'sidepanel.php'; ?>

    <!-- Heading begins -->
    <div class="heading">
        <a href="index.php"><h1>LionReadz</h1></a>
    </div>
    <!-- Heading ends -->

    <div class="container">
    <!-- Welcome starts -->

    <div class="welcome">
        <div class="welcome_text">
            <span>
                <h3>Welcome to</h3>
                <h4>Another SEMESTER</h4>
            </span>
        </div>
    </div>
    <!-- welcome ends -->

    <!-- news and memes begins -->
    <div class="news">
        <h5><i class=" fa-solid fa-lightbulb" style="color: black;"></i> News & Memes</h5>
        <div class="news_slider">
            <div class="myslides fade" id="mySlides">
                <img src="./img/meme.jpg" alt=" Meme Picture">
            </div>
            
            <div class="myslides fade" id="mySlides">
                <img src="./img/book3.jpg" alt=" Meme Picture">
            </div>

            <div class="myslides fade" id="mySlides">
                <img src="./img/book4.jpg" alt=" Meme Picture">
            </div>

        </div>

    </div>

    <!-- include footer -->
    <?php include "footer.php"; ?>


</div>

    
    <script>
        
        /* Set the width of the sidebar to 250px (show it) */
function openNav() {
  document.getElementById("mySidepanel").style.width = "75%";
}
/* Set the width of the sidebar to 0 (hide it) */
 function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}

    



let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("myslides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 5000); // Change image every 2 seconds
}
    </script>
</body>
</html>