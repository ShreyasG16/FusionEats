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
             
             .tr{
                padding:2px;
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
          <h1>Add Category</h1>
          <br/><br/>

          <?php
                if(isset($_SESSION['add']))//checking whether the session is set or not
                {
                          echo $_SESSION['add'];//Displaying session message
                          unset($_SESSION['add']);//Removing session message
                }

                if(isset($_SESSION['upload']))//checking whether the session is set or not
                {
                          echo $_SESSION['upload'];//Displaying session message
                          unset($_SESSION['upload']);//Removing session message
                }

           ?>
           <br/><br/>
            <!-- Add Category form starts-->
           <form action="" method="POST" enctype="multipart/form-data">
               <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    
                    <tr>
                        <!--The colspan attribute defines the number of columns a cell should span-->
                        <td colspan="2">
                            <br/>
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>

               </table>

           </form>
           <!-- Add category form ends-->
            <?php
                    //process the value from form and save it in database

                    //check whether submit button is clicked or not

                if(isset($_POST['submit']))
                {
                        //Button Clicked
                        //echo "Button Clicked";

                        //1.Get the Data from form
                        
                        $title=$_POST['title'];
                         
                        //for radio input we need to check whether the button is selected or not
                        if(isset($_POST['featured']))
                        {
                            //if selected get the value from from
                            $featured=$_POST['featured'];
                        }
                        else{
                            //set default value
                            $featured="No";
                        }

                        if(isset($_POST['active']))
                        {
                            //if selected get the value from from
                            $active=$_POST['active'];
                        }
                        else{
                            //set default value
                            $active="No";
                        }

                        //Check whether the image is selected or not and set the value for image accordingly
                        //print_r($_FILES['image']);

                        //die();//break the code here as we just want to see details in array i.e image location
                        if(isset($_FILES['image']['name']))
                        {
                           //if the image selected has name and value then only we will upload ex-[name] => destiny-5.jpg [type] => image/jpeg [tmp_name] => C:\xampp\tmp\phpDB7D.tmp [error] => 0 [size] => 89143 ) when print_r was executed
                            //Upload the image
                            //to upload image,need image name,source path and destination path
                            $image_name=$_FILES['image']['name'];
                            
                            //Upload the image only if image is selected
                            if($image_name!="")
                            {

                
                                //Auto Rename our Image
                                //Get the extension of our image 
                                $ext=end(explode('.',$image_name));
                                //Rename the image
                                $image_name="Food_Category_".rand(000,999).'.'.$ext;

                                $source_path=$_FILES['image']['tmp_name'];

                                $destination_path="../images/category/".$image_name;

                                //now upload the image
                                $upload=move_uploaded_file($source_path,$destination_path);

                                //check whether the image is uploaded or not
                                //if not stop and redirect with error message
                                if($upload==false)
                                {
                                    //set message
                                    $_SESSION['upload']="<div class='error text-center' style='color:red'>Failed to Upload Image</div>";

                                    //Redirect to Add category Page
                            
                                    header("location:".SITEURL.'admin/add-category.php');
                                    //stop the process
                                    die();
                                }
                            }
                            
                        }
                        else
                        {
                               //don't upload and set image_name as blank
                               $image_name="";
                        }
                   
                        //2. SQL Query to save the data into database
                        $sql="INSERT INTO tbl_category SET
                                title='$title',
                                image_name='$image_name',
                                featured='$featured',
                                active='$active'
                                ";
                        
                        //3.Execute Query and Save Data in Database
                        
                        $res=mysqli_query($conn,$sql);

                        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
                        if($res==TRUE)
                        {
                            //Data Inserted
                            //echo "Data Inserted";

                            //create a session variable to display message
                            $_SESSION['add']="<div class='success' style='color:#2ed573'>Category Added Successfully</div>";

                            header("location:".SITEURL.'admin/manage-category.php');
                        }
                        else
                        {
                            //Failed to insert
                            //echo "Failed to Insert Data";

                            //create a session variable to display message
                            $_SESSION['add']="<div class='error text-center' style='color:red'>Failed to Add Category</div>";

                            header("location:".SITEURL.'admin/add-category.php');
                        }
                    
                    }
                    
            ?>
           
          </div>
        </div>

        <!--Footer section starts-->
        <div class="footer">
           <div class="wrapper">
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</a></p>
            </div> 
        </div>
         <!--Footer section ends-->
    </body>
</html>

