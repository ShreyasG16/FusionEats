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

               .btn-danger{
                 background-color:#ff6b81;
                 padding:2%;
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
                   <h1>Manage Order</h1>
                   <br/><br/>
                    <!--Display update order-->
                    <?php
                        if(isset($_SESSION['update']))
                        {
                          echo $_SESSION['update'];//Displaying session message
                          unset($_SESSION['update']);//Removing session message
                        }
                     ?>
                   <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Food</th>
                            <th>Price</th>
                            <th>Qty.</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>

                        <?php
                            //Get all the orders from database
                            $sql="SELECT * FROM tbl_order ORDER BY id DESC";//latest order

                            //Execute the query
                            $res=mysqli_query($conn,$sql);

                            //check whether the query is executed or not
                            if($res==TRUE)
                            {
                                //check whether the data is available or not
                                $count=mysqli_num_rows($res);//func to count all rows in categories
                                
                                //create serial no. variable and set default value as 1
                                $sn=1;


                                //if count is greater than zero we have categories else we don't have
                                if($count>0)
                                {
                                    //Get the all orders
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the values from individual column
                                        $id=$row['id'];
                                        $food=$row['food'];
                                        $price=$row['price'];
                                        $qty=$row['qty'];
                                        $total=$row['total'];
                                        $order_date=$row['order_date'];
                                        $status=$row['status'];
                                        $customer_name=$row['customer_name'];
                                        $customer_contact=$row['customer_contact'];
                                        $customer_email=$row['customer_email'];
                                        $customer_address=$row['customer_address'];
                                  
                                        //display all categories as soon data is fetched from database
                                        ?> 
                                            <tr>
                                              <td><?php echo $sn++; ?>.</td>
                                              <td><?php echo $food; ?></td>
                                              <td><?php echo $price; ?></td>
                                              <td><?php echo $qty; ?></td>
                                              <td><?php echo $total; ?></td>
                                              <td><?php echo $order_date; ?></td>
                                              <td>
                                                <?php
                                                     //Ordered,On DeLIVERY,Delivered,Cancelled
                                                     if($status=="Ordered")
                                                    {
                                                        echo "<label>$status</label>";
                                                    }
                                                    elseif($status=="On Delivery")
                                                    {
                                                        echo "<label style='color:#ff7f50;'>$status</label>";
                                                    }
                                                    elseif($status=="Delivered")
                                                    {
                                                        echo "<label style='color:#2ed573;'>$status</label>";
                                                    }
                                                    elseif($status=="Cancelled")
                                                    {
                                                        echo "<label style='color:#ff4757;'>$status</label>";
                                                    }
                                                ?>
                                              </td>
                                              <td><?php echo $customer_name; ?></td>
                                              <td><?php echo $customer_contact; ?></td>
                                              <td><?php echo $customer_email; ?></td>
                                              <td><?php echo $customer_address; ?></td>
                                              <td>
                                                  <!--pass id as well-->
                                                  <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>  
                                              </td>
                                          </tr>

                                        <?php
                                    }
                                  }  
                                  else
                                  {
                                    //No order is present
                                    /*
                                    ?>
                                        <option value="0">No Food Found</option>
                                    <?php
                                    */

                                    echo "<tr> <td colspan='12' class='error' style='color:red'>Orders Not Available</div>";

                                    header("location:".SITEURL.'admin/manage-food.php');
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
              <p class="text-center">© 2023 All Rights Reserverd <b>INDIAN DELIGHT</b><br><a style="text-decoration:none;" href="https://myportfolio.shreyas16.repl.co/#">Shreyas Gore</p>
            </div> 
         </div>
         <!--Footer section ends-->
    </body>

</html>