<?php
// Determine if you're running locally (e.g., based on environment variable)
$localEnvironment = false; // Set this to true for local development

if ($localEnvironment) {
    require_once('db_local.php'); // Load local configuration
} else {
    require_once('db.php'); // Load production configuration
}

// Your code that uses the database connection goes here
