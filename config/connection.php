<?php

include_once 'constants.php';

// Array to store active database connections
$connections = [];

// Connecting.. to the primary database
$conn1 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$conn1) {
    die("Connection to primary database failed: " . mysqli_connect_error());
}
$connections['primary'] = $conn1;

// Connecting.. to additional database 1 (remote)
$conn2 = mysqli_connect(DB2_HOST, DB2_USERNAME, DB2_PASSWORD, DB2_NAME);
if (!$conn2) {
    die("Connection to remote database failed: " . mysqli_connect_error());
}
$connections['remote'] = $conn2;

// Optional: Add more databases if needed
/*
// Connecting.. to additional database 2
$conn3 = mysqli_connect(DB3_HOST, DB3_USERNAME, DB3_PASSWORD, DB3_NAME);
if (!$conn3) {
    die("Connection to database 2 failed: " . mysqli_connect_error());
}
$connections['db2'] = $conn3;
*/
?>
