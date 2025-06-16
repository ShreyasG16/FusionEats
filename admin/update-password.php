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

               .error{
                color:#FF0000;
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
             <h1>Update Password</h1>
         
             <br><br>

             <?php
               //to pass the id using form first ,need to get id from database
               if(isset($_GET['id']))
               {
                     $id=$_GET['id'];
               }

             ?>
              
             <form action="" method="POST">
                
                <table class="tbl-30">
                     <tr>
                         <td>Current Password: </td>
                         <td>
                             <input type="password" name="current_password" placeholder="Current Password">
                         </td>
                     </tr>
                     
                     <tr>
                         <td>New Password: </td>
                         <td>
                             <input type="password" name="new_password" placeholder="New Password">
                         </td>
                     </tr>

                     <tr>
                         <td>Confirm Password: </td>
                         <td>
                             <input type="password" name="confirm_password" placeholder="Confirm Password">
                         </td>
                     </tr>
                     
                     <tr>
                         <!--The colspan attribute defines the number of columns a cell should span-->
                         <td colspan="2">
                             <br/>
                             <!-- Along with current password,old and new ,id also need to be passed but id no need to diplay-->
                             <input type="hidden" name="id" value="<?php echo $id; ?>">
                             <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                             <br><br>
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

            //1.Get all the values from form to update
            $id=$_POST['id'];
            $current_password=md5($_POST['current_password']);
            $new_password=md5($_POST['new_password']);
            $confirm_password=md5($_POST['confirm_password']);
            
            //2. Check whether the user with correct ID and current password exists or not
            $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute Query 
            $res= mysqli_query($conn,$sql);

            //Check whether the query executed successfully or not
            if($res==true)
            {
                //Check whether data is available or not
                $count=mysqli_num_rows($res);

                if($count==1)
                {
                    //User exists and password can be changed
                   // echo "User found";
                    //check whether the new password and confirm match or not
                    
                    if($new_password==$confirm_password)
                    {
                            //Update the password
                           // echo "Password changed";
                           $sql2= "UPDATE tbl_admin SET password='$new_password' WHERE id=$id ";

                           //Execute Query 
                            $res2=mysqli_query($conn,$sql);

                            //Check whether the query executed successfully or not
                            if($res2==TRUE)
                            {
                                //Display success message
                                $_SESSION['change-pwd']="<div class='success' style='color:#2ed573'>Password Changed Successfully</div>";

                                //Redirect to Manage Admin Page
                                header("location:".SITEURL.'admin/manage-admin.php');
                            }
                            else
                            {
                                //Failure message

                                //create a session variable to display message
                                $_SESSION['change-pwd']="<div class='error' style='color:red'>Error: Password Not Changed</div>";

                                //Redirect to manage ADMIN Page
                                
                                header("location:".SITEURL.'admin/manage-admin.php');
                            }
                    }
                    else
                    {
                        //User Does not exist set message and redirect
                        $_SESSION['pwd-not-match']="<div class='error' style='color:red'>Password Not Matched</div>";

                        //Redirect to manage ADMIN Page  
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                
                }
                else
                {
                    //User Does not exist set message and redirect
                    $_SESSION['user-not-found']="<div class='error' style='color:red'>User Not Found</div>";

                    //Redirect to manage ADMIN Page  
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            
        }
    ?>
        
<?php include('partials/footer.php'); ?>
