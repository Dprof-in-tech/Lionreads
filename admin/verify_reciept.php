<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/LionReads-logo.png" type="image/x-icon">
    <title>LionReads Bookshop | Get your Books quick and Easy</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: whitesmoke;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .verify-order{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .verify-order form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        label{
            align-self: flex-start;
            padding-left: 20px;
            margin-bottom: 0.2rem;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-style: italic;
        }
        .verify{
            height: 2rem;
            width: 85%;
            border-radius: 8px;
            font-size: 1rem;
            padding-left: 10px;
            font-family: serif;
            margin-bottom: 1rem;
            border: 1px thin silver;
        }
        .submit{
            width: 30%;
            height: 2rem;
            background-color: rgb(6, 68, 16);
            color: white;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: serif;
            font-style: oblique;
        }

        h2{
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            
        }
    </style>
</head>
<body>
     <!-- Include Navbar -->
     <?php include 'adminSidepanel.php'; ?>
    <!-- Navbar ends. -->

    <div class="verify-order">
        <h2>Verify Orders..</h2>
        <form action="results.php" method="GET">
            <label for="order-number">Input the Order Number...</label>
            <input type="text" name="order-number" class="verify">
            <input type="submit" value="Verify order.." class="submit">
        </form>
    </div>

     <!-- footer begins -->
     <?php include '../footer.php';?>

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