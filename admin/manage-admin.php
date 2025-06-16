<?php 
include('../config/connection.php'); // Include connections.php to get database connections
?>

<?php
//Authorization - Access Control
//Check whether the user is logged in or not
if(!isset($_SESSION['user'])) //if user session is not set
{
    // User is not logged in
    $_SESSION['no-login-message'] = "<div class='error text-center' style='color:red'>Please Login To Acess Admin Pannel</div>";
    // Redirect to login page with message
    header("location:".SITEURL.'admin/login.php');
    exit(); // Prevent further script execution
}

// Use primary database connection
$conn = $connections['primary']; 
?>
<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <style>
            .tbl-full {
                width: 100%;
            }
            table tr th {
                border-bottom: 1px solid black;
                padding: 1%;
                text-align: left;
            }
            table tr td {
                padding: 1%;
            }
            .btn-primary {
                background-color: #1e90ff;
                padding: 1%;
                color: white;
                text-decoration: none;
                font-weight: bold;
            }
            .btn-primary:hover {
                background-color: #3742fa;
            }
            .btn-secondary {
                background-color: #7bed9f;
                padding: 1%;
                color: black;
                text-decoration: none;
                font-weight: bold;
            }
            .btn-secondary:hover {
                background-color: #2ed573;
            }
            .btn-danger {
                background-color: #ff6b81;
                padding: 1%;
                color: white;
                text-decoration: none;
                font-weight: bold;
            }
            .btn-danger:hover {
                background-color: #ff4757;
            }
        </style>
    </head>
    <body>
        <!--Menu section starts-->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <!--Menu section ends-->

        <!--Main section starts-->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br/>

                <?php
                if(isset($_SESSION['add'])) {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete'])) {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['user-not-found'])) {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['pwd-not-match'])) {
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }

                if(isset($_SESSION['change-pwd'])) {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }
                ?>
                <br><br><br>

                <!--Button to Add Admin-->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br/><br/><br/>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    // Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";

                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Check whether the query is executed or not
                    if ($res == TRUE) {
                        // Count rows to check whether we have data in database or not
                        $count = mysqli_num_rows($res); // Function to get all rows in database
                        $sn = 1; // Create a variable for serial numbers in the table

                        // Check number of rows
                        if ($count > 0) {
                            // We have data in the database
                            while ($rows = mysqli_fetch_assoc($res)) {
                                // Using while loop to get all data from the database
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                // Display the values in the table
                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='error'>No Admins Found</td></tr>";
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
        <!--Main section ends-->

        <!--Footer section starts-->
        <div class="footer">
            <div class="wrapper">
                <p class="text-center">© 2023 All Rights Reserved <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
            </div> 
        </div>
        <!--Footer section ends-->
    </body>
</html>
