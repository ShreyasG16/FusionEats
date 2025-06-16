<?php include('../config/connection.php'); ?>
<?php
    //Authorization - Access Control
    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message']="<div class='error text-center' style='color:red'>Please Login To Access Admin Panel</div>";
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
               .text-center{
                text-align:center;
               }
        </style>
    </head>
    <body>
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
         
         <div class="main-content">
          <div class="wrapper">
          <h1>Add Admin</h1>
          <br/><br/>
          <?php
                if(isset($_SESSION['add']))
                {
                          echo $_SESSION['add'];
                          unset($_SESSION['add']);
                }
           ?>
           <form action="" method="POST">
               <table class="tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter Your Name">
                        </td>
                    </tr>
                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" placeholder="Your Username">
                        </td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Your Password">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br/>
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>
                    </tr>
               </table>
           </form>
          </div>
        </div>
        
        <div class="footer">
           <div class="wrapper">
              <p class="text-center">© 2023 All Rights Reserved <b>INDIAN DELIGHT</b><br><a href="#">Shreyas Gore</a></p>
            </div> 
        </div>
    </body>
</html>

<?php
   if(isset($_POST['submit']))
   {
      $full_name=$_POST['full_name'];
      $username=$_POST['username'];
      $password=md5($_POST['password']); //Password Encryption with MDS
      
      // Create a connection to the database
      $conn = mysqli_connect('localhost', 'root', '', 'food_order1') or die(mysqli_error($conn));
      
      // SQL Query to save the data into the database
      $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
       
       // Execute the query
       $res=mysqli_query($conn,$sql);

       // Check if the query was successful
       if($res==TRUE)
       {
          $_SESSION['add']="<div class='success' style='color:#2ed573'>Admin Added Successfully</div>";
          header("location:".SITEURL.'admin/manage-admin.php');
       }
       else
       {
          $_SESSION['add']="<div class='error text-center' style='color:red'>Failed to Add Admin</div>";
          header("location:".SITEURL.'admin/add-admin.php');
       }
   }
?>
