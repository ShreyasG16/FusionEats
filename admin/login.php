<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
        <style>
         
            .login{
                border:2px solid black;
                width:20%;
                margin:14% auto;
                padding:2%;
                background-color:#7bed9f;
            }

            .text-center{
                text-align:center;
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

        </style>
    </head>
    
   
    <body>
         <!--Menu section starts-->
         <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            
            <?php
                if(isset($_SESSION['login']))
                {
                   echo $_SESSION['login'];//Displaying session message
                   unset($_SESSION['login']);//Removing session message
                }

                if(isset($_SESSION['no-login-message']))
                {
                   echo $_SESSION['no-login-message'];//Displaying session message
                   unset($_SESSION['no-login-message']);//Removing session message
                }
            ?>
            <br><br>
            <!-- Login Form Starts here -->
            <form action="" method="POST" class="text-center">
            Username: 
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password: 
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" placeholder="Login" class="btn-primary"><br><br>
            </form>
             <!-- Login Form ends here -->

            <p class="text-center">Created By - <a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
         </div>
         
    </body>
</html>
<?php
   //Check whether the Submit button clicked or not
   if(isset($_POST['submit']))
   {
      //Process for Login
      //1.Get data from login form

        /*Mistake that I did below since the password is encrypted first we need to decrypt else it will not match all the time
        $password=$_POST['password'];
        $username=$_POST['username'];
        */ 

        // $username = $_POST['username'];
        // $password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);
      
      //2.Create a sql query to check whether the user with username and password exists or not
      $sql="SELECT * FROM tbl_admin WHERE
      password='$password' AND
      username='$username'
      ";

      //3.Execute Query 
       $res=mysqli_query($conn,$sql);
      
      //4.Count rows to check whether the user exists or not
      $count=mysqli_num_rows($res);

       if($count==1)
       {
          //User Available and login success
          $_SESSION['login']="<div class='success' style='color:#2ed573'>Login Successful</div>";
          $_SESSION['user']=$username; //To check whether the user is logged in or not and logout will unset it
          //Redirect to HOME Page/dashboard
          header("location:".SITEURL.'admin/');
       }
       else
       {
          //User Not Available and login failed

          //create a session variable to display message
          $_SESSION['login']="<div class='error text-center' style='color:red'>User Name or Password Did Not Matched</div>";

          //Redirect to manage ADMIN Page
         
          header("location:".SITEURL.'admin/login.php');
       }
   }
?>
         