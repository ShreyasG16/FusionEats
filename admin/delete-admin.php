<?php
    //Include constants .php as we are using conn variable which is declared in constants.php file
    include('../config/constants.php');
    //1.get the ID of Admin to be deleted
    $id=$_GET['id'];
    

    //2.Create SQL Query to delete Admin
     $sql="DELETE FROM tbl_admin WHERE id=$id";

     //Execute the Query
     $res=mysqli_query($conn,$sql);

     //Check whether the query executed successfully or not
     if($res==true)
     {
        //Query executed Successfully and admin deleted
        //echo "Admin Deleted";

        //create SESSION variable to display message
        $_SESSION['delete']="<div class='success' style='color:#2ed573'>Admin Deleted Successfully</div>";
        //Redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else{

        //Failed to delete admin
        //echo "Failed to Delete Admin";
        $_SESSION['delete']="<div class='error text-center' style='color:red'>Failed to Delete Admin.Try Again Later.</div>";
        //Redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }


    //3.Redirect to Manage Admin page with message(success/error)



?>