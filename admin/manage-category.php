<?php include('../config/constants.php'); ?>
<?php
    //Authorization - Access Control
    //Check whether the user is logged in or not

    if(!isset($_SESSION['user']))//if user session is not set
    {
        //User is not logged in
        $_SESSION['no-login-message']="<div class='error text-center' style='color:red'>Please Login To Acess Admin Pannel</div>";
        //Redirect to login page with message
        header("location:".SITEURL.'admin/login.php');
    }

?>
<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        
        <style>
               .tbl-full{
                  width:100%;
               }

               table tr th{
                border-bottom:1px solid black;
                padding:1%;
                text-align:left;
               }

               table tr td{
                  padding:1%;
               }

               .btn-primary{
                 background-color:#1e90ff;
                 padding:2%;
                 color:white;
                 text-decoration:none;
                 font-weight:bold;
               }

               .btn-primary:hover{
                 background-color:#3742fa;
               }
               
               .btn-secondary{
                 background-color:#7bed9f;
                 padding:2%;
                 color:black;
                 text-decoration:none;
                 font-weight:bold;
               }

               .btn-secondary:hover{
                 background-color:#2ed573;
               }

               .btn-danger{
                 background-color:#ff6b81;
                 padding:2%;
                 color:white;
                 text-decoration:none;
                 font-weight:bold;
               }

               .btn-danger:hover{
                 background-color:#ff4757;
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
                      if(isset($_SESSION['add']))//checking whether the session is set or not
                      {
                          echo $_SESSION['add'];//Displaying session message
                          unset($_SESSION['add']);//Removing session message
                      }

                      if(isset($_SESSION['remove']))//checking whether the session is set or not
                      {
                          echo $_SESSION['remove'];//Displaying session message
                          unset($_SESSION['remove']);//Removing session message
                      }

                      if(isset($_SESSION['delete']))//checking whether the session is set or not
                      {
                          echo $_SESSION['delete'];//Displaying session message
                          unset($_SESSION['delete']);//Removing session message
                      }

                      if(isset($_SESSION['no-category-found']))//checking whether the session is set or not
                      {
                          echo $_SESSION['no-category-found'];//Displaying session message
                          unset($_SESSION['no-category-found']);//Removing session message
                      }

                      if(isset($_SESSION['update']))//checking whether the session is set or not
                      {
                          echo $_SESSION['update'];//Displaying session message
                          unset($_SESSION['update']);//Removing session message
                      }

                      if(isset($_SESSION['upload']))//checking whether the session is set or not
                      {
                          echo $_SESSION['upload'];//Displaying session message
                          unset($_SESSION['upload']);//Removing session message
                      }

                      if(isset($_SESSION['failed-remove']))//checking whether the session is set or not
                      {
                          echo $_SESSION['failed-remove'];//Displaying session message
                          unset($_SESSION['failed-remove']);//Removing session message
                      }

                    ?>
                    <br><br>
                    <!--Button to Add Admin-->
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

                            //Query to get all categories from database
                            $sql="SELECT * FROM tbl_category";

                            //Execute query
                            $res=mysqli_query($conn,$sql);

                            //count rows
                            $count=mysqli_num_rows($res);

                            //create serial number variable and assign value as 1
                            $sn=1;
                            
                            //check whether we have data in database or not
                            if($count>0)
                            {
                              //their is data in database
                                while($row=mysqli_fetch_assoc($res))
                                {
                                      $id=$row['id'];
                                      $title=$row['title'];
                                      $image_name=$row['image_name'];
                                      $featured=$row['featured'];
                                      $active=$row['active'];

                                  ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>
                                          <?php 
                                                //Check whether image name is available or not
                                                if($image_name!="")
                                                {
                                                   //display image
                                                  ?>
                                                  <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px" >
                                                  <?php
                                                }
                                                else{
                                                  //display the the message
                                                   echo "<div class='error' style='color:red'>Image Not Available</div>";
                                                }
                                           ?>
                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                            <!-- pass id and image name  along with url so to delete that data from data base-->
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>

                                  <?php
                                }
                            }
                            else{
                              //no data
                              //Display message inside table
                              //break php to write html
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
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</p>
            </div> 
         </div>
         <!--Footer section ends-->
    </body>

</html>