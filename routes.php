<?php
$route = isset($_GET['route']) ? $_GET['route'] : '';
$routes = [
    '' => 'home.php',
    'home' => 'home.php',
    'bookshop' => 'bookshop.php',
    'cart' => 'cart.php',
    'contact' => 'contact.php',
    'checkout' => 'checkout.php',
    'receipt' => 'receipt.php',
    'search' => 'search_results.php',
    'verify' => 'verify_payment.php',
    'faqs' => 'faqs.php',
    'pickup-policy' => 'pickup-policy.php',


    //admin
    'admin' => 'admin/login.php',
    'dashboard' => 'admin/admin.php',
    'books' => 'admin/books.php',
    'add-books' => 'admin/add.php',
    'reset-password' => 'admin/changePassword.php',
    'completed-transactions' => 'admin/completed_transactions.php',
    'pending-transactions' => 'admin/pending_transactions.php',
    'register' => 'admin/register.php',
    'profile' => 'admin/profile.php',
    'edit-name' => 'admin/editName.php',
    'location-order' => 'admin/location_order.php',
    'logout' => 'admin/logout.php',
    'results' => 'admin/results.php',
    'transactions' => 'admin/transactions.php',
    'update-bookprice' => 'admin/update_bookprice.php',
    'update-bookquantity' => 'admin/update_bookquantity.php',
    'verify-receipt' => 'admin/verify_receipt.php',

   
    'admin-login' => 'admin/login.php',   
    'admin-register' => 'admin/register.php',

];

if (array_key_exists($route, $routes)) {
    require $routes[$route];
} else {
    http_response_code(404);
    include '404.php';
}
