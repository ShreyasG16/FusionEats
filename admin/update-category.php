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

             .tbl-30{
                width:30%;
                margin:2px;
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


<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
         
        <br><br>

        <?php
             
             //Check whether the id is set or not
             if(isset($_GET['id']))
             {
                        
                    //1.Get the ID and other data of selected Category
                    $id=$_GET['id'];

                    //2. Create SQL Query to get THE DETAILS
                    $sql="SELECT * FROM tbl_category WHERE ID=$id";

                    //Execute the query
                    $res=mysqli_query($conn,$sql);

                    //check whether the query is executed or not
                    if($res==TRUE)
                    {
                        //check whether the data is available or not
                        $count=mysqli_num_rows($res);//func to get all rows in database
                        
                        //check whether we have admin data or not
                        if($count==1)
                        {
                        //Get the details
                        
                           $row=mysqli_fetch_assoc($res);
                            
                           $title=$row['title'];
                           $current_image=$row['image_name'];
                           $featured=$row['featured'];
                           $active=$row['active'];
                       
                        }
                        else
                        {
                            //Redirect to Manage Category Page
                            //set message
                            $_SESSION['no-category-found']="<div class='error' style='color:red'>Category Not Found</div>";
                            header("location:".SITEURL.'admin/manage-category.php');
                        }            
                    }

             }
             else
             {
                //Redirect to Manage Category
                header("location:".SITEURL.'admin/manage-category.php');
             }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">
                
                <table class="tbl-30">
                     <tr>
                         <td>Title: </td>
                         <td>
                             <input type="text" name="title" value="<?php echo $title; ?>">
                             <!-- value shows the curr value in my database-->
                         </td>
                     </tr>
                     
                     <tr>
                         <td>Current Image: </td>
                         <td>
                              <?php 
                                    //Check whether image name is available or not
                                    if($current_image!="")
                                    {
                                        //display image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                        <?php
                                    }
                                    else{
                                        //display the the message
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
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                         <!--The colspan attribute defines the number of columns a cell should span-->
                         <td colspan="2">
                             <br/>
                    
                             <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                             <input type="hidden" name="id" value="<?php echo $id; ?>">
                             <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                         </td>
                     </tr>
 
                </table>
 
            </form>

            <?php

                //Check whether the Submit button clicked or not
                if(isset($_POST['submit']))
                {
                    //echo "Button Clicked";
                    //Get all the values from form to update
                    $id=$_POST['id'];
                    $title=$_POST['title'];
                    $current_image=$_POST['current_image'];
                    $featured=$_POST['featured'];
                    $active=$_POST['active'];
                    
                    //Updating the image if selected

                    //check selected or not
                    if(isset($_FILES['image']['name']))
                    {
                        //get image 
                        $image_name=$_FILES['image']['name'];

                        //check whether image is available or not
                        if($image_name!="")
                        {
                             //image available
                             //Upload new image

                                //Auto Rename our Image
                                //Get the extension of our image 
                                $ext=end(explode('.',$image_name));
                                //Rename the image
                                $image_name="Food_Category_".rand(000,999).'.'.$ext;

                                $source_path=$_FILES['image']['tmp_name'];

                                $destination_path="../images/category/".$image_name;

                                //now upload the image
                                $upload=move_uploaded_file($source_path,$destination_path);

                                //check whether the image is uploaded or not
                                //if not stop and redirect with error message
                                if($upload==false)
                                {
                                    //set message
                                    $_SESSION['upload']="<div class='error text-center' style='color:red'>Failed to Upload Image</div>";

                                    //Redirect to Add category Page
                            
                                    header("location:".SITEURL.'admin/manage-category.php');
                                    //stop the process
                                    die();
                                }

                             //remove current image if available
                            if($current_image!="")
                            {
                                $remove_path="../images/category/".$current_image;
                                //remove image
                                $remove=unlink($remove_path);
                    
                                //if failed to remove image then add an error message and stop process
                                if($remove==false)
                                {
                                    //set the session message
                                    $_SESSION['failed-remove']="<div class='error' style='color:red'>Failed to Delete Current Image </div>";
                                    //redirect to manage category
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    //stop process
                                    die();
                                }   
                            }
                                
                        }
                        else
                        {
                            $image_name=$current_image;
                        }
                    }
                    else
                    {
                        //admin don't want to change image
                        $image_name=$current_image;
                    }


                    //Create a sql query to update category
                    $sql2="UPDATE tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                    ";

                    //Execute Query 
                    $res2=mysqli_query($conn,$sql2);

                    //Check whether the query executed successfully or not
                    if($res2==TRUE)
                    {
                        //Query executed 
                        $_SESSION['update']="<div class='success' style='color:#2ed573'>Category Updated Successfully</div>";

                        //Redirect
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        //Failed to Update Admin

                        //create a session variable to display message
                        $_SESSION['update']="<div class='error' style='color:red'>Failed to Update Category</div>";

                        //Redirect
                        
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                }


            ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>