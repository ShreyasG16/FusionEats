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
        <h1>Update Admin</h1>
         
        <br><br>

        <?php
            //1.Get the ID of selected Admin
            $id=$_GET['id'];

            //2. Create SQL Query to get THE DETAILS
            $sql="SELECT * FROM tbl_admin WHERE ID=$id";

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
                   //echo "Admin Available";
                   $row=mysqli_fetch_assoc($res);

                   $full_name=$row['full_name'];
                   $username=$row['username'];
                }
                else
                {
                    //Redirect to Manage Admin Page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }            
            }
        ?>

        <form action="" method="POST">
                
                <table class="tbl-30">
                     <tr>
                         <td>Full Name: </td>
                         <td>
                             <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                             <!-- value shows the curr value in my database-->
                         </td>
                     </tr>
                     
                     <tr>
                         <td>Username: </td>
                         <td>
                             <input type="text" name="username" value="<?php echo $username; ?>">
                         </td>
                     </tr>
                     <!-- In update no need to ask password  will give change button-->
                     <tr>
                         <!--The colspan attribute defines the number of columns a cell should span-->
                         <td colspan="2">
                             <br/>
                             <!-- Along with full name and user name we need id but no need to diplay-->
                             <input type="hidden" name="id" value="<?php echo $id; ?>">
                             <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                         </td>
                     </tr>
 
                </table>
 
            </form>

    </div>
</div>

<?php

   //Check whether the Submit button clicked or not
   if(isset($_POST['submit']))
   {
      //echo "Button Clicked";
      //Get all the values from form to update
      $id=$_POST['id'];
      $full_name=$_POST['full_name'];
      $username=$_POST['username'];
      
      //Create a sql query to update admin
      $sql="UPDATE tbl_admin SET
      full_name='$full_name',
      username='$username'
      WHERE id=$id;
      ";

      //Execute Query 
       $res=mysqli_query($conn,$sql);

       //Check whether the query executed successfully or not
       if($res==TRUE)
       {
          //Query executed and admin updated
          $_SESSION['update']="Admin Updated Successfully";

          //Redirect to Manage Admin Page
          header("location:".SITEURL.'admin/manage-admin.php');
       }
       else
       {
          //Failed to Update Admin

          //create a session variable to display message
          $_SESSION['update']="Failed to Delete Admin.";

          //Redirect to manage ADMIN Page
         
          header("location:".SITEURL.'admin/manage-admin.php');
       }
   }


?>



<?php include('partials/footer.php'); ?>