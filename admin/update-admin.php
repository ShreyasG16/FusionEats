<?php
// Include database connection file
include('../config/connection.php');

// Authorization - Access Control
if(!isset($_SESSION['user'])) {
    $_SESSION['no-login-message'] = "<div class='error text-center' style='color:red'>Please Login To Access Admin Panel</div>";
    header("location:" . SITEURL . 'admin/login.php');
    exit;
}
?>
<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <style>
            .tbl-30 { width: 30%; }
            .btn-secondary { background-color: #7bed9f; padding: 2%; color: black; text-decoration: none; font-weight: bold; }
            .btn-secondary:hover { background-color: #2ed573; }
        </style>
    </head>
    <body>
        <!-- Menu section starts -->
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
        <!-- Menu section ends -->

        <div class="main-content">
            <div class="wrapper">
                <h1>Update Admin</h1>
                <br><br>

                <?php
                    // Check if the 'id' parameter exists in the URL
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];

                        // Get the admin details from the database
                        $sql = "SELECT * FROM tbl_admin WHERE id = $id";
                        $res = mysqli_query($conn1, $sql);

                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res);
                            if ($count == 1) {
                                $row = mysqli_fetch_assoc($res);
                                $full_name = $row['full_name'];
                                $username = $row['username'];
                            } else {
                                $_SESSION['no-admin-found'] = "Admin not found.";
                                header("location:" . SITEURL . 'admin/manage-admin.php');
                                exit;
                            }
                        } else {
                            $_SESSION['db-error'] = "Failed to fetch admin details.";
                            header("location:" . SITEURL . 'admin/manage-admin.php');
                            exit;
                        }
                    } else {
                        $_SESSION['no-id-error'] = "No ID provided.";
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                        exit;
                    }
                ?>

                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Full Name: </td>
                            <td>
                                <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Username: </td>
                            <td>
                                <input type="text" name="username" value="<?php echo $username; ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <?php
            // Handle form submission to update admin details
            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];

                // SQL query to update the admin details
                $sql = "UPDATE tbl_admin SET
                        full_name = '$full_name',
                        username = '$username'
                        WHERE id = $id";

                $res = mysqli_query($conn1, $sql);

                if ($res == TRUE) {
                    $_SESSION['update'] = "Admin Updated Successfully";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                    exit;
                } else {
                    $_SESSION['update'] = "Failed to Update Admin";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                    exit;
                }
            }
        ?>

    </body>
</html>
