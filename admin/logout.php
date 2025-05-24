<?php
    //Include constants.php for SITEURL
    include('../config/constants.php');

    //1.Destroy the Session
    session_destroy();//Unsets $_SESSION['user'],user variable will remain until the user itself clicked logout button
   
    //2. Redirect to Login Page  
    header("location:".SITEURL.'admin/login.php');
    
?>