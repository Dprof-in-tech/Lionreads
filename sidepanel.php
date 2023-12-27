<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Side Panel.</title>
</head>
<body>
     <!-- Navbar begins -->
     <div class="navbar">
        <div class="n-left">
            <div id="mySidepanel" class="sidepanel">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa-solid fa-xmark"></i></a>
                <a href="index.php" alt=""><i class="fa-solid fa-light fa-house" style="color: white;"></i> Home</a>
                <a href="bookshop.php"><i class="fa-solid fa-shop" style="color: white;"></i> Bookshop</a>
                <!-- <a href="catalog.php"><i class="fa-solid fa-shop" style="color: white;"></i> Catalog</a> -->
                <a href="faqs.php"><i class="fa-solid fa-message" style="color: white;"></i>  FAQs</a>
                <a href="contact.php"><i class="fa-solid fa-comments" style="color: white;"></i> Contact</a>
                <a href="./admin/login.php"><i class="fa-solid fa-user-secret" style="color: white;"></i> Admin</a>
                <span>
                    <h5>All Rights Reserved</h5>
                    <h5>LionReads, 2023</h5>
                </span>
           </div>
                  
           <div class="openbtn" onclick="openNav()">&#9776;</div>
        </div>
        <div class="n-right">
            <!-- <a href=""><h1>Lionreads</h1></a> -->
        </div>

    </div>
    <!-- Navbar ends -->
</body>
</html>