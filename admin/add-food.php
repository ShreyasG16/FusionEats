<?php ob_start(); ?>
<?php include('../config/connection.php'); ?>
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
          <h1>Add Food</h1>
          <br/><br/>
          <?php
                //to displayed uploaded or not using session variable
                if(isset($_SESSION['upload']))//checking whether the session is set or not
                {
                          echo $_SESSION['upload'];//Displaying session message
                          unset($_SESSION['upload']);//Removing session message
                }
          ?>
            <!-- Add Category form starts-->
           <form action="" method="POST" enctype="multipart/form-data">
            <!--enctype allows to upload file in form-->
                
               <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of Food"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">
                                
                                <?php
                                    //create php code to display categories from Database
                                    //1.Create SQL to get all active categories from database
                                    $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                                    //Execute the query
                                    $res=mysqli_query($conn1,$sql);

                                    //check whether the query is executed or not
                                    if($res==TRUE)
                                    {
                                        //check whether the data is available or not
                                        $count=mysqli_num_rows($res);//func to count all rows in categories
                                        
                                        //if count is greater than zero we have categories else we don't have
                                        if($count>0)
                                        {
                                            //Get the all categories
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                //get details of categories
                                                $id=$row['id'];
                                                $title=$row['title'];
                                         
                                                //display all categories as soon data is fetched from database
                                                ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            //No category is present
                                            ?>
                                               <option value="0">No Category Found</option>
                                            <?php
                                        }            
                                    }

                                ?>
                             </select>
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
                        <td colspan="2"><!-- 2 coz 1st displaying title and other for input field-->
                            <br/>
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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

                        //1.Get the Data from form and add food in database
                        
                        $title=$_POST['title'];
                        $description=$_POST['description'];
                        $price=$_POST['price'];
                        $category=$_POST['category'];
                         
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
                       
                        if(isset($_FILES['image']['name']))//this check whether clicked choose file button or not
                        {
                           //if the image selected has name and value then only we will upload ex-[name] => destiny-5.jpg [type] => image/jpeg [tmp_name] => C:\xampp\tmp\phpDB7D.tmp [error] => 0 [size] => 89143 ) when print_r was executed
                            //Upload the image
                            //to upload image,need image name,source path and destination path
                            $image_name=$_FILES['image']['name'];
                            
                            //Upload the image only if image is selected
                            if($image_name!="")//even after choose file user may cancle and not upload so check again
                            {

                
                                //Auto Rename our Image
                                //Get the extension of our image 
                                //some PHP versions don't accept that you are passing a function directly to the another function.You must assign the function value to a variable and pass it to the strtolower function.See below:
                                $text = explode('.', $image_name);
                                $ext = end($text);
                                //Rename the image
                                $image_name="Food-Name-".rand(0000,9999).".".$ext;

                                $src=$_FILES['image']['tmp_name'];

                                $dst="../images/food/".$image_name;

                                //now upload the image
                                $upload=move_uploaded_file($src,$dst);

                                //check whether the image is uploaded or not
                                //if not stop and redirect with error message
                                if($upload==false)
                                {
                                    //set message
                                    $_SESSION['upload']="<div class='error' style='color:red'>Failed to Upload Image</div>";

                                    //Redirect to Add category Page
                            
                                    header('location:'.SITEURL.'admin/add-food.php');
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
                   
                        //2. SQL Query to save or Add Food
                        //for numerical value ''is not given
                        $sql2="INSERT INTO tbl_food SET
                                title='$title',
                                description='$description',
                                price=$price,
                                image_name='$image_name',
                                category_id=$category,
                                featured='$featured',
                                active='$active'
                                ";
                        
                        //3.Execute Query and Save Data in Database
                        
                        $res2 = mysqli_query($conn1,$sql2);

                        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
                        if($res2==TRUE)
                        {
                            //Data Inserted
                            
                            $_SESSION['add']="<div class='success' style='color:#2ed573'>Food Added Successfully</div>";

                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                        else
                        {
                            //Failed to insert
                            //echo "Failed to Insert Data";

                            //create a session variable to display message
                            $_SESSION['add']= "<div class='error' style='color:red'>Failed to Add Food</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
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
<?php ob_flush(); ?>

