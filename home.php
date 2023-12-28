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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
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
        <section>
            <nav>
                <div class="nav-left">
                    <img src="img/lionreads-logo-1.png" alt="" class="slide-in">
                </div>
                <div class="nav-right">
                    <span class="page-navigation">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="index.php?route=bookshop">Bookshop</a></li>
                            <li><a href="#footer">About</a></li>
                            <li><a href="index.php?route=contact">Contact</a></li>
                        </ul>
                    </span>
                    <span class="buy-button">
                        <a href="index.php?route=bookshop">Buy a Book</a>
                    </span>
                </div>
            </nav>
        </section>

        <section id="hero">
            <div class="hero-container">
                <div class="hero-text">
                    <h2>
                        Expand your mind, reading a book.
                    </h2>
                    <p>
                        reading a book is a good way to increase your mental capacity and 
                        we are here to help you with your book purchases while in the den.
                    </p>
                </div>
                
                <div class="hero-image">
                    <img src="img/book-vector-2.png" alt="" loading="lazy">
                    <img src="img/book-vector.png" alt="" loading="lazy">
                </div>
            </div>
        </section>

        <section id="featured-books">
            <div class="featured-books">
                <h2>Bestsellers</h2>
                <div class="featured-books-container">
                    <div class="featured-book">
                        <img src="img/introduction-to-entrepreneurship.jpg" alt="" loading="lazy">
                        <span class="featured-book-details">
                            <h3>NGN 1300</h3>
                        </span>
                    </div>
                    <div class="featured-book">
                        <img src="img/GSP-101-CA.jpg" alt="" loading="lazy">
                        <span class="featured-book-details">
                            <h3>NGN 700</h3>
                        </span>
                    </div>
                    <div class="featured-book">
                        <img src="img/the broken promise.jpeg" alt="" loading="lazy">
                        <span class="featured-book-details">
                            <h3>NGN 3200</h3>
                        </span>
                    </div>
                    <div class="featured-book">
                        <img src="img/computer-science.jpg" alt="" loading="lazy">
                        <span class="featured-book-details">
                            <h3>NGN 4500</h3>
                        </span>
                    </div>

                    <div class="featured-book">
                        <img src="img/introduction-to-entrepreneurship.jpg" alt="" loading="lazy">
                        <span class="featured-book-details">
                            <h3>NGN 3500</h3>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        
        <section id="free-books">
            <div class="free-books">
                <h2>Free Books</h2>
                <div class="free-books-container">
                    <div class="free-book-left">
                        <img src="img/book-vector-3.png" alt="" class="slide-in" loading="lazy">
                    </div>
                    <div class="free-book-right">
                        <p>
                            Here we have some free books handpicked to help you become a better student
                            and improve your grades. Ranging from study guides to CA Fillers and Past questions, hit the 
                            download button now..
                        </p>
                        <a href="index.php?route=bookshop">Download Now</a>
                    </div> 
                </div>
            </div>
        </section>

        <section id="newsletter">
            <div class="newsletter-container">
                <div class="newsletter">
                    <p>
                        Subscribe to our newsletter to get updates on new books, 
                        promotions and other offers.
                    </p>
                    <form action="" class="subscribe-newsletter">
                        <input type="email" placeholder="Enter your email address">
                        <input type="submit" value="Subscribe">
                    </form>
                </div>
            </div>
        </section>
        <section id="footer">
            <footer class="footer">
                <div class="footer-left">
                    <img src="img/lionreads-logo-1.png" alt="" loading="lazy">
                    <p>
                        Lionreads Bookstore is a subsidiary of Lionreads Inc. 
                        We are a bookstore that sells books of all kinds and 
                        we are located in the heart of the University of Nigeria, Nsukka.
                    </p>
                </div>
                <div class="footer-right">
                    <ul>
                        <li>Quick Links</li>
                        <li><a href="index.php?route=bookshop">Bookshop</a></li>
                        <li><a href="index.php?route=faqs">About</a></li>
                        <li><a href="index.php?route=contact">Contact</a></li>
                    </ul>
                    <ul>
                        <li>Quick Links</li>
                        <li><a href="index.php?route=pickup-policy">Terms & Conditions</a></li>
                        <li><a href="index.php?route=pickup-policy">Delivery Services</a></li>
                        <li><a href="index.php?route=bookshop">Pickup Locations</a></li>
                    </ul>
                    <ul>
                        <li>Category</li>
                        <li><a href="index.php?route=bookshop">Textbooks</a></li>
                        <li><a href="index.php?route=bookshop">Workbooks</a></li>
                        <li><a href="index.php?route=bookshop">Novels</a></li>
                    </ul>
                    <ul>
                        <li>Social Media</li>
                        <li><a href="#">X (Formerly twitter)</a></li>
                        <li><a href="#">Linkedin</a></li>
                        <li><a href="#">Whatsapp</a></li>
                    </ul>
                </div>
                
            </footer>
            <div class="footer-bottom">
                <p>
                    &copy; 2023 Lionreads Bookstore. All rights reserved.
                </p>
            </div>
        </section>


<script src="script.js"></script>    
</body>
</html>