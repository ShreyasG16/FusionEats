<?php 
include('../config/connection.php'); 

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
?>
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
         <!--Login Form-->
         <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            
            <?php
                if(isset($_SESSION['login']))
                {
                   echo $_SESSION['login']; // Display session message
                   unset($_SESSION['login']); // Remove session message
                }

                if(isset($_SESSION['no-login-message']))
                {
                   echo $_SESSION['no-login-message']; // Display session message
                   unset($_SESSION['no-login-message']); // Remove session message
                }
            ?>
            <br><br>
            <form action="" method="POST" class="text-center">
            Username: 
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password: 
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
            </form>
            <p class="text-center">Created By - <a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
         </div>
    </body>
</html>

<?php
   // Check whether the Submit button clicked or not
   if(isset($_POST['submit']))
   {
        // Start session if not started already
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Access the primary database connection from the $connections array
        $conn = $connections['primary']; // Use the primary database connection

        // Check if the connection is valid
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get data from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        // Debugging: Check if the username is entered properly
        // echo "Entered Username: $username<br>"; 
        
        $raw_password = $_POST['password']; // Use raw password before hashing for comparison

        // Debugging: Check the entered password
        // echo "Entered Password: $raw_password<br>";
        
        // Hash the entered password with md5
        $password = md5($raw_password);

        // Debugging: Check the hashed password
        // echo "Hashed Password: $password<br>";

        // SQL query to check whether the user exists
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        // Debugging: Print the SQL query
        // echo "SQL Query: $sql<br>";

        // Execute query
        $res = mysqli_query($conn, $sql);

        if($res && mysqli_num_rows($res) == 1) // Valid user
        {
            // Set session variables
            $_SESSION['login'] = "<div class='success' style='color:#2ed573'>Login Successful</div>";
            $_SESSION['user'] = $username;

            // Redirect to the admin dashboard
            header("location:".SITEURL.'admin/');
        }
        else
        {
            // Invalid user
            $_SESSION['login'] = "<div class='error text-center' style='color:red'>Username or Password Did Not Match</div>";
            header("location:".SITEURL.'admin/login.php');
        }
   }
?>
