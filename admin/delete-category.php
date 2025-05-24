<?php
      //Include constants .php as , using SITEURL which is declared in constants.php file
    include('../config/constants.php');
     //check whether the id and image_name is set or not
     if(isset($_GET['id']) AND isset($_GET['image_name']))
     {
        //get the value and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //Remove the physical image file is available
        if($image_name!="")
        {
            //image is available
            $path="../images/category/".$image_name;
            //remove image
            $remove=unlink($path);

            //if failed to remove image then add an error message and stop process
            if($remove==false)
            {
                //set the session message
                $_SESSION['remove']="<div class='error text-center' style='color:red'>Failed to Delete Category Image </div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                 die();
            }   
        }

        //Delete data from database
        $sql="DELETE FROM tbl_category WHERE id=$id";
        
        //Execute the Query
        $res=mysqli_query($conn,$sql);

        //Check whether the query executed successfully or not
        if($res==true)
        {
            //Query executed Successfully and category deleted
            //echo "category Deleted";

            //create SESSION variable to display message
            $_SESSION['delete']="<div class='success' style='color:#2ed573'>Category Deleted Successfully</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {

            //Failed to delete category
            //echo "Failed to Delete category";
            $_SESSION['delete']="<div class='error' style='color:red'>Failed to Delete Category</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-category.php');
        }

     }
     else
     {
        //redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
     }




?>