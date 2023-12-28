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
    header("location: index.php?route=bookshop");
}

// update the last activity time
$_SESSION['last_activity'] = time();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bookshop.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/Lionreads-logo-1.png" type="image/x-icon">
    <title>Search Results | lionreads</title>
</head>
<body>
    <!-- include navbar -->
    <?php include "sidepanel.php";?>

    <?php
// connect to the database
include "config.php";
// retrieve the search query from the form submission
$search_query = $_GET['query'];

// construct the SQL query to search for products that match the search query
$sql = "SELECT * FROM books WHERE book_title LIKE '%$search_query%'";

// execute the query and retrieve the search results
$result = mysqli_query($con, $sql);
//Search results



?>

    <div class="search_resultcontainer">
        <?php 
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                  // display the product name and a link to the product detail page
                  echo "<li><a href='index.php?route=checkout?id=" . $row['id'] . "'>" . $row['book_title'] . ' - Quantity Available: ' . $row['book_quantity'] . "</a></li>";
                }
                echo "</ul>";
              } else {
                // display a message if no products were found
                echo "No books found.";
              }
        ?>

        <!-- include footer -->
        <div class="copyright_2">
            <h5>Copyright @ LionReads, 2023</h5>
        </div>
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

