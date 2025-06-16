<?php
// Include connection file to initialize database connections
include('../config/connection.php');

// Authorization - Access Control
if (!isset($_SESSION['user'])) {
    $_SESSION['no-login-message'] = "<div class='error text-center' style='color:red'>Please Login To Access Admin Panel</div>";
    header("location:" . SITEURL . 'admin/login.php');
}

// Use the primary connection from the $connections array
$conn = $connections['primary'];
?>

<html>
<head>
    <title>Food Order Website - Manage Order</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- Menu section -->
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

    <!-- Main content section -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Order</h1>
            <br><br>

            <!-- Display update order message -->
            <?php
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty.</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

                <?php
                // Get all the orders from the database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Check if query was executed
                if ($res == TRUE) {
                    $count = mysqli_num_rows($res);
                    $sn = 1;

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?>.</td>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>
                                <td>
                                    <?php
                                    if ($status == "Ordered") {
                                        echo "<label>$status</label>";
                                    } elseif ($status == "On Delivery") {
                                        echo "<label style='color:#ff7f50;'>$status</label>";
                                    } elseif ($status == "Delivered") {
                                        echo "<label style='color:#2ed573;'>$status</label>";
                                    } elseif ($status == "Cancelled") {
                                        echo "<label style='color:#ff4757;'>$status</label>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='12' class='error' style='color:red'>Orders Not Available</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <!-- Footer section -->
    <div class="footer">
        <div class="wrapper">
            <p class="text-center">© 2023 All Rights Reserved <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
        </div>
    </div>
</body>
</html>
