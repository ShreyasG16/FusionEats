<?php include('../config/connection.php'); ?>
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
                   <h1>Manage Food</h1>
                   <br/><br/>
                    <!-- To display message after submitting add food form-->
                   <?php
                          if(isset($_SESSION['add']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['add'];//Displaying session message
                                    unset($_SESSION['add']);//Removing session message
                          }

                          if(isset($_SESSION['delete']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['delete'];//Displaying session message
                                    unset($_SESSION['delete']);//Removing session message
                          }

                          if(isset($_SESSION['upload']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['upload'];//Displaying session message
                                    unset($_SESSION['upload']);//Removing session message
                          }

                          if(isset($_SESSION['unauthorize']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['unauthorize'];//Displaying session message
                                    unset($_SESSION['unauthorize']);//Removing session message
                          }

                          if(isset($_SESSION['update']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['update'];//Displaying session message
                                    unset($_SESSION['update']);//Removing session message
                          }

                          if(isset($_SESSION['remove-failed']))//checking whether the session is set or not
                          {
                                    echo $_SESSION['remove-failed'];//Displaying session message
                                    unset($_SESSION['remove-failed']);//Removing session message
                          }

                    ?>
                   <br/><br/>
                    <!--Button to Add food-->
                    <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
                    <br/><br/><br/>
                    

                   <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Price ₹</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                             
                            //1.Create SQL to get all food from database
                            $sql="SELECT * FROM tbl_food";

                            //Execute the query
                            $res=mysqli_query($conn1,$sql);

                            //check whether the query is executed or not
                            if($res==TRUE)
                            {
                                //check whether the data is available or not
                                $count=mysqli_num_rows($res);//func to count all rows in categories
                                
                                //create serial no. variable and set default value as 1
                                $sn=1;


                                //if count is greater than zero we have categories else we don't have
                                if($count>0)
                                {
                                    //Get the all food
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the values from individual column
                                        $id=$row['id'];
                                        $title=$row['title'];
                                        $price=$row['price'];
                                        $image_name=$row['image_name'];
                                        $featured=$row['featured'];
                                        $active=$row['active'];
                                  
                                        //display all categories as soon data is fetched from database
                                        ?> 
                                            <tr>
                                              <td><?php echo $sn++; ?></td>
                                              <td><?php echo $title; ?></td>
                                              <td><?php echo $price; ?></td>
                                              <td>
                                                <?php
                                                 //Check whether we have image or not
                                                  if($image_name=="")
                                                  {
                                                       //don't have image
                                                       echo "<div class='error' style='color:red'>Image Not Available</div>";
                                                  } 
                                                  else
                                                  {
                                                    //Check if image_name is a URL or local file
                                                    if (filter_var($image_name, FILTER_VALIDATE_URL)) {
                                                        // If it's a URL, display the image from the URL
                                                        echo "<img src='".$image_name."' width='100px'>";
                                                    } else {
                                                        // Otherwise, it's a local image, so display it from the local directory
                                                        echo "<img src='".SITEURL."images/food/".$image_name."' width='100px'>";
                                                    }
                                                  }
                                                ?>
                                              </td>
                                              <td><?php echo $featured; ?></td>
                                              <td><?php echo $active; ?></td>
                                              <td>
                                                  <!--need not pass image ,get all details from database itself-->
                                                  <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                                  <!--pass id and image name to delete that food detail -->
                                                  <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                              </td>
                                            </tr>
                                        <?php
                                    }
                                  }  
                                  else
                                  {
                                    //No food is present
                                    /*
                                    ?>
                                        <option value="0">No Food Found</option>
                                    <?php
                                    */

                                    echo "<tr> <td colspan='2' class='error' style='color:red'>Failed to Add Food</div>";

                                    header("location:".SITEURL.'admin/manage-food.php');
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
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</p>
            </div> 
         </div>
         <!--Footer section ends-->
    </body>

</html>
