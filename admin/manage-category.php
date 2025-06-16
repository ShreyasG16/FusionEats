<?php
    // Include connection.php to handle the database connection
    include('../config/connection.php'); // Include the connection file

    // Authorization - Access Control
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user'])) {
        // User is not logged in
        $_SESSION['no-login-message'] = "<div class='error text-center' style='color:red'>Please Login To Access Admin Panel</div>";
        // Redirect to login page with message
        header("location:" . SITEURL . 'admin/login.php');
    }
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
                padding: 2%;
                color: white;
                text-decoration: none;
                font-weight: bold;
            }
            .btn-primary:hover {
                background-color: #3742fa;
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
            .btn-danger {
                background-color: #ff6b81;
                padding: 2%;
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
                   <h1>Manage Category</h1>
                   <br/><br/>
                    <!-- To display message after submitting add category form-->
                    <?php
                      if(isset($_SESSION['add'])) {
                          echo $_SESSION['add']; 
                          unset($_SESSION['add']);
                      }

                      if(isset($_SESSION['remove'])) {
                          echo $_SESSION['remove'];
                          unset($_SESSION['remove']);
                      }

                      if(isset($_SESSION['delete'])) {
                          echo $_SESSION['delete'];
                          unset($_SESSION['delete']);
                      }

                      if(isset($_SESSION['no-category-found'])) {
                          echo $_SESSION['no-category-found'];
                          unset($_SESSION['no-category-found']);
                      }

                      if(isset($_SESSION['update'])) {
                          echo $_SESSION['update'];
                          unset($_SESSION['update']);
                      }

                      if(isset($_SESSION['upload'])) {
                          echo $_SESSION['upload'];
                          unset($_SESSION['upload']);
                      }

                      if(isset($_SESSION['failed-remove'])) {
                          echo $_SESSION['failed-remove'];
                          unset($_SESSION['failed-remove']);
                      }
                    ?>
                    <br><br>
                    <!--Button to Add Category-->
                    <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                    <br/><br/><br/>

                   <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>

                        <?php
                            // Query to get all categories from the primary database (food_order1)
                            $sql = "SELECT * FROM tbl_category";

                            // Execute query using the primary connection
                            $res = mysqli_query($connections['primary'], $sql);

                            // Count rows
                            $count = mysqli_num_rows($res);

                            // Create serial number variable and assign value as 1
                            $sn = 1;
                            
                            // Check whether we have data in the database or not
                            if($count > 0) {
                                // There is data in the database
                                while($row = mysqli_fetch_assoc($res)) {
                                      $id = $row['id'];
                                      $title = $row['title'];
                                      $image_name = $row['image_name'];
                                      $featured = $row['featured'];
                                      $active = $row['active'];
                                  ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>
                                          <?php 
                                                // Check whether image name is available or not
                                                if($image_name != "") {
                                                   // Display image
                                                  ?>
                                                  <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                                                  <?php
                                                } else {
                                                  // Display the message
                                                   echo "<div class='error' style='color:red'>Image Not Available</div>";
                                                }
                                           ?>
                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>

                                  <?php
                                }
                            } else {
                                // No data
                                ?>
                                <tr>
                                   <td colspan="6"><div class="error">No Category Added</div></td>
                                </tr>
                              <?php
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
