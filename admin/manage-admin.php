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
                 padding:1%;
                 color:white;
                 text-decoration:none;
                 font-weight:bold;
               }

               .btn-primary:hover{
                 background-color:#3742fa;
               }
               
               .btn-secondary{
                 background-color:#7bed9f;
                 padding:1%;
                 color:black;
                 text-decoration:none;
                 font-weight:bold;
               }

               .btn-secondary:hover{
                 background-color:#2ed573;
               }

               .btn-danger{
                 background-color:#ff6b81;
                 padding:1%;
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
                   <h1>Manage Admin</h1>
                   <br/>

                  <?php
                       if(isset($_SESSION['add']))
                       {
                          echo $_SESSION['add'];//Displaying session message
                          unset($_SESSION['add']);//Removing session message
                       }

                       if(isset($_SESSION['delete']))
                       {
                          echo $_SESSION['delete'];//Displaying session message
                          unset($_SESSION['delete']);//Removing session message
                       }

                       if(isset($_SESSION['update']))
                       {
                          echo $_SESSION['update'];//Displaying session message
                          unset($_SESSION['update']);//Removing session message
                       }

                       if(isset($_SESSION['user-not-found']))
                       {
                          echo $_SESSION['user-not-found'];//Displaying session message
                          unset($_SESSION['user-not-found']);//Removing session message
                       }

                       if(isset($_SESSION['pwd-not-match']))
                       {
                          echo $_SESSION['pwd-not-match'];//Displaying session message
                          unset($_SESSION['pwd-not-match']);//Removing session message
                       }

                       if(isset($_SESSION['change-pwd']))
                       {
                          echo $_SESSION['change-pwd'];//Displaying session message
                          unset($_SESSION['change-pwd']);//Removing session message
                       }


                  ?>
                  <br><br><br>
                    <!--Button to Add Admin-->
                    <a href="add-admin.php" class="btn-primary">Add Admin</a>
                    <br/><br/><br/>

                   <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php
                            //Query to get all admin
                            $sql="SELECT * FROM tbl_admin";

                            //Execute the query
                            $res=mysqli_query($conn,$sql);

                            //check whether the query is executed or not
                            if($res==TRUE)
                            {
                              //count rows to check whether we have data in database or not
                              $count=mysqli_num_rows($res);//func to get all rows in database
                              
                              $sn=1;//create a variable and assign value to main sr no in table when we randomn delete

                              //check no. of rows
                              if($count>0)
                              {
                                //we have data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                  //Using while loop to get all data from database
                                  //this loop will run as long as we have data in database

                                  //get individual data
                                  $id=$rows['id'];
                                  $full_name=$rows['full_name'];
                                  $username=$rows['username'];

                                  //Display the values in our table
                                  ?> <!--broke php-->

                                  <tr>  
                                       <td><?php echo $sn++; ?></td>
                                       <td><?php echo $full_name; ?></td>
                                       <td><?php echo $username; ?></td>
                                        <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                         <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                         <!--get id to be deleted from url-->
                                          <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                  </tr>


                                  <?php
                                }
                              }
                              else{
                                //we do not have data in database
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
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
            </div> 
         </div>
         <!--Footer section ends-->
    </body>

</html>
         