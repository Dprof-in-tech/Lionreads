<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Welcome to LionReads.com.ng, your trusted academic companion for the University of Nigeria (UNN). Explore our seamless platform to find and effortlessly purchase required textbooks. Boost your academic journey with LionReads, your UNN mobile bookshop. Stay updated with news, memes, and valuable insights.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LionReads | Your UNN mobile Bookshop</title>
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
        <a href="index.php"><h1>LionReads</h1></a>
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
                <img src="https://media.discordapp.net/attachments/1152353769145778216/1164247039459201054/IMG_20231018_175331.jpg?ex=6542848c&is=65300f8c&hm=6d479bdfab10c58de3cd23fd4b19267d9c42a551bf5d848260c96f6f6da0a511&=&width=416&height=418" alt=" Meme Picture">
            </div>
            
            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTEFbrJbryW6FaRIA6Q03MmAs-p75K-_9vxVw&usqp=CAU" alt=" Meme Picture">
            </div>

            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDLXukA7Hi6-2YcPpwTw3h1rZghKaN234s5A&usqp=CAU" alt=" Meme Picture">
            </div>
            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCkaZ_VJTcqfEaUTOSRGgbCOLOeFTx0VLM2A&usqp=CAU" alt=" Meme Picture">
            </div>
            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDL6jHyp4HCx-4tbCajJ0ID5GEgmA2s2NSdg&usqp=CAU" alt=" Meme Picture">
            </div>
            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgkoe0-WR1Yex_AUvzyHCT1zqtbbNWJD67hg&usqp=CAU" alt=" Meme Picture">
            </div>
            <div class="myslides fade" id="mySlides">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGNN-AJsltrdXMENBqS-wNnWH1mFYO9SGjJg&usqp=CAU" alt=" Meme Picture">
            </div>
        </div>
        <div class="news_text">
            <h1>MORE THAN 1M BOOKS IN DIFFERENT FIELDS!!</h1>
            <H3>
                In the Lionreads store, you will find what you're looking for through
                an impressive collection of Books and Continous assessments of Different 
                genres and Courses in the University of Nigeria, Nsukka.
            </H3>
            <a href="bookshop.php">
                <h4>
                    <i class="fa-solid fa-arrow-right"></i> Explore the Bookshop
                </h4>
            </a>
        </div>

    </div>

    <!-- Company Management Section -->
<div class="company-management">
    <div class="container">
        <h2>Meet the Team</h2>
        <div class="management-cards">
            <!-- Manager 1 -->
            <div class="management-card">
                <img src="img/esther.jpeg" alt="Manager 1">
                <h3>Esther, Amarachi</h3>
                <p>CEO</p>
                <p>Esther is the CEO of LionReads.com.ng, bringing years of experience in the industry.</p>
            </div>

            <!-- Manager 2 -->
            <div class="management-card">
                <img src="img/isaac.jpeg" alt="Manager 2">
                <h3>Isaac Onyemaechi (@prof)</h3>
                <p>CTO</p>
                <p>Isaac serves as the Chief Technical Officer, overseeing day-to-day Technical operations.</p>
            </div>

            <!-- Manager 3 -->
            <!-- <div class="management-card">
                <img src="img/isaac.jpeg" alt="Manager 3">
                <h3>David Chogo</h3>
                <p>CFO</p>
                <p>David Chogo manages our finances and ensures financial stability.</p>
            </div> -->
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