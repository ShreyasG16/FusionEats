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

               .text-center{
                text-align:center;
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
          <h1>Add Admin</h1>
          <br/><br/>

          <?php
                //need to also display in add-admin as done in manage-admin
                if(isset($_SESSION['add']))//checking whether the session is set or not
                {
                          echo $_SESSION['add'];//Displaying session message
                          unset($_SESSION['add']);//Removing session message
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
                            <input type="password" name="password" placeholder="Your Password"> <!--password type ensure whatever u written will be hidden-->
                        </td>
                    </tr>
                    
                    <tr>
                        <!--The colspan attribute defines the number of columns a cell should span-->
                        <td colspan="2">
                            <br/>
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>
                    </tr>

               </table>

           </form>
          </div>
        </div>

        <!--Footer section starts-->
        <div class="footer">
           <div class="wrapper">
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a href="#">Shreyas Gore</a></p>
            </div> 
        </div>
         <!--Footer section ends-->
    </body>
</html>

<?php
   //process the value from form and save it in database

   //check whether submit button is clicked or not

   if(isset($_POST['submit']))
   {
      //Button Clicked
      //echo "Button Clicked";

      //1.Get the Data from form
      //echo $full_name=$_POST['full_name']; to check whether we got data in our variable or not
      $full_name=$_POST['full_name'];
      $username=$_POST['username'];
      $password=md5($_POST['password']); //Password Encryption with MDS
      
      //2. SQL Query to save the data into database
      $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
        // Id is not inserted because in our database id is auto incremented so no need.
       //to check our sql query
       //echo $sql;
        
       /* Keeping a connection to the database open requires dedicated resource on both the
        web server and the database server, and the number of open connections available
        is often very limited (in the range of 100). The connection process is usually very fast, 
        and shouldn't be a problem. By opening and dropping connections as quickly as possible, 
        it's usually no problem to scale up.
       */  
       
       //CREATE A SEPERATE FILE FOR STEP 3
       //3.Execute Query and Save Data in Database
       //$conn= mysqli_connect('localhost','root','') or die(mysqli_error());//Database Connection
       //$db_select= mysqli_select_db($conn,'food-order') or die(mysqli_error());//Selecting Database
       $res=mysqli_query($conn,$sql) or die(mysqli_error());

       //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
       if($res==TRUE)
       {
          //Data Inserted
          //echo "Data Inserted";

          //create a session variable to display message
          $_SESSION['add']="<div class='success' style='color:#2ed573'>Admin Added Successfully</div>";

          //Redirect to Manage Admin Page
          //for concatenation of string we use dot
          //SITEURL:http://localhost/food-order/
          //Concatening to SITEURL :admin/manage-admin.php
          header("location:".SITEURL.'admin/manage-admin.php');
       }
       else
       {
          //Failed to insert
          //echo "Failed to Insert Data";

          //create a session variable to display message
          $_SESSION['add']="<div class='error text-center' style='color:red'>Failed to Add Admin</div>";

          //Redirect to Add Admin Page
          //for concatenation of string we use dot
          //SITEURL:http://localhost/food-order/
          //Concatening to SITEURL :admin/add-admin.php
          header("location:".SITEURL.'admin/add-admin.php');
       }
   }
   
?>