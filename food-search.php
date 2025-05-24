<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
        <div class="container">
            <?php
                  //Get the search keyword here itself will be using to filter and also to display text Food on your search
                // $search = $_POST['search'];
                $search = mysqli_real_escape_string($conn, $_POST['search']); //protection from SQL injection
             ?>
            
            <h2 style="color:black">Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
               
               //SQL query to Get foods based on search keyword
               //$search = burger '; DROP database name;
                // "SELECT * FROM tbl_food WHERE title LIKE '%burger'%' OR description LIKE '%burger%'";
               $sql ="SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

               //Execute the query
               $res=mysqli_query($conn,$sql);

               //check whether the query is executed or not
               if($res==TRUE)
               {
                   //check whether the category is available or not
                   $count=mysqli_num_rows($res);//func to get all rows in database
                   
                   //check whether we have admin data or not
                   if($count>0)
                   {
                   //Get the details
                   
                      while($row=mysqli_fetch_assoc($res))
                      {
                           //get the values
                             
                             $id=$row['id'];
                             $title=$row['title'];
                             $price=$row['price'];
                             $description=$row['description'];
                             $image_name=$row['image_name'];
                             //to write html
                             ?> 
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                        <?php
                                              //check whether image is available or not
                                              if($image_name=="")
                                              {
                                                 //Display Message 
                                                 echo "<div class='error' style='color:red'>Image Not Available</div>";
                                              }
                                              else
                                              {
                                                 //Image available
                                                 ?>
                                                     <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                                 <?php
                                              }
                                          ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">₹<?php echo $price; ?></p>
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="#" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                             <?php
                      }
                   }
                   else
                   {
                       //Categories not available
                       echo "<div class='error' style='color:red'>Food Not Found</div>";
                   }            
               }

            ?>
        
            <div class="clearfix"></div>
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>