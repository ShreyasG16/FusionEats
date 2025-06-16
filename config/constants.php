<?php
// Start Session
session_start();

// Create Constants to Store Non-Repeating Values
define('SITEURL', 'http://localhost/food-order-iia/');

// Primary Database (existing one)
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food_order1');

// Additional Database 1
define('DB2_HOST', '192.168.42.245');
define('DB2_USERNAME', 'shreyas');
define('DB2_PASSWORD', 'root');
define('DB2_NAME', 'food_order2');

/*
// Additional Database 2
define('DB3_HOST', '192.168.42.246');
define('DB3_USERNAME', 'shreyas');
define('DB3_PASSWORD', 'root');
define('DB3_NAME', 'food_order2');
*/
?>
