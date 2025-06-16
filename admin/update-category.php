<?php 
    include('../config/constants.php');
    include('../config/connection.php');  // Include the connection.php file
?>

<?php
    // Authorization - Access Control
    // Check whether the user is logged in or not

    if(!isset($_SESSION['user'])) { // If user session is not set
        // User is not logged in
        $_SESSION['no-login-message'] = "<div class='error text-center' style='color:red'>Please Login To Access Admin Panel</div>";
        // Redirect to login page with message
        header("location:" . SITEURL . 'admin/login.php');
    }

?>
<html>
    <head>
        <title>Food Order Website - Update Category</title>
        <link rel="stylesheet" href="../css/admin.css">
        <style>
            .tbl-30 {
                width: 30%;
                margin: 2px;
            }

            .btn-secondary {
                background-color: #7bed9f;
                padding: 2%;
                color: black;
                text-decoration: none;
                font-weight: bold;
            }

            .btn-secondary:hover {
                background-color: #2ed573;
            }
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
                <h1>Update Category</h1>

                <br><br>

                <?php
                    // Check whether the ID is set or not
                    if(isset($_GET['id'])) {
                        // 1. Get the ID and other data of the selected Category
                        $id = $_GET['id'];

                        // 2. Create SQL Query to get the DETAILS
                        $sql = "SELECT * FROM tbl_category WHERE ID=$id";

                        // Execute the query using the correct connection
                        $res = mysqli_query($conn1, $sql);  // Use $conn1 for primary DB connection

                        // Check whether the query is executed or not
                        if ($res == TRUE) {
                            // Check whether the data is available or not
                            $count = mysqli_num_rows($res); // Function to get all rows in the database

                            // Check whether we have admin data or not
                            if ($count == 1) {
                                // Get the details
                                $row = mysqli_fetch_assoc($res);
                                $title = $row['title'];
                                $current_image = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                            } else {
                                // Redirect to Manage Category Page
                                // Set message
                                $_SESSION['no-category-found'] = "<div class='error' style='color:red'>Category Not Found</div>";
                                header("location:" . SITEURL . 'admin/manage-category.php');
                            }
                        }
                    } else {
                        // Redirect to Manage Category
                        header("location:" . SITEURL . 'admin/manage-category.php');
                    }
                ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Current Image: </td>
                            <td>
                                <?php
                                    // Check whether image name is available or not
                                    if ($current_image != "") {
                                        // Display image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                        <?php
                                    } else {
                                        // Display the message
                                        echo "<div class='error' style='color:red'>Image Not Available</div>";
                                    }
                                 ?>
                            </td>
                        </tr>

                        <tr>
                            <td>New Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes
                                <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                                <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <br />
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>

                <?php
                    // Check whether the Submit button is clicked or not
                    if (isset($_POST['submit'])) {
                        // Get all the values from the form to update
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $current_image = $_POST['current_image'];
                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        // Updating the image if selected
                        if (isset($_FILES['image']['name'])) {
                            // Get image
                            $image_name = $_FILES['image']['name'];

                            if ($image_name != "") {
                                // Image available, upload new image

                                // Auto Rename our Image
                                // Get the extension of our image
                                $ext = end(explode('.', $image_name));
                                // Rename the image
                                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                                $source_path = $_FILES['image']['tmp_name'];
                                $destination_path = "../images/category/" . $image_name;

                                // Now upload the image
                                $upload = move_uploaded_file($source_path, $destination_path);

                                if ($upload == false) {
                                    $_SESSION['upload'] = "<div class='error text-center' style='color:red'>Failed to Upload Image</div>";
                                    header("location:" . SITEURL . 'admin/manage-category.php');
                                    die();
                                }

                                // Remove current image if available
                                if ($current_image != "") {
                                    $remove_path = "../images/category/" . $current_image;
                                    // Remove image
                                    $remove = unlink($remove_path);

                                    if ($remove == false) {
                                        $_SESSION['failed-remove'] = "<div class='error' style='color:red'>Failed to Delete Current Image </div>";
                                        header('location:' . SITEURL . 'admin/manage-category.php');
                                        die();
                                    }
                                }
                            } else {
                                $image_name = $current_image;
                            }
                        } else {
                            // Admin doesn't want to change the image
                            $image_name = $current_image;
                        }

                        // Create SQL query to update category
                        $sql2 = "UPDATE tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                            WHERE id = $id";

                        // Execute Query using the correct connection
                        $res2 = mysqli_query($conn1, $sql2); // Use $conn1 for primary DB connection

                        if ($res2 == TRUE) {
                            $_SESSION['update'] = "<div class='success' style='color:green'>Category Updated Successfully</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        } else {
                            $_SESSION['update'] = "<div class='error' style='color:red'>Failed to Update Category</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
