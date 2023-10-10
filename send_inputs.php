<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["concatenatedInputs"])) {
        // Retrieve the concatenatedInputs data from the POST request
        $concatenatedInputs = $_POST["concatenatedInputs"];
        
        // Store it in a session variable
        $_SESSION["concatenatedInputs"] = $concatenatedInputs;
        
        // Send a success response to the client
        echo "ConcatenatedInputs data received and stored in session.";
    } else {
        echo "Missing concatenatedInputs data in POST request.";
    }
}
?>
