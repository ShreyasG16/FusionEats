<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php   
        if(isset($_SESSION['order']))//checking whether the session is set or not
        {
                        echo $_SESSION['order'];//Displaying session message
                        unset($_SESSION['order']);//Removing session message
        }
    ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
             <!-- Get all category from database-->

             <?php
                  //Create SQL Query to Display Categories from database
                  $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

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
                                $image_name=$row['image_name'];
                                //to write html
                                ?> 
                                    <!--along with clicking on image also pass id so that ,filtering can be done from database using id-->
                                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id ?>">
                                    <div class="box-3 float-container">
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
                                                     <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                                 <?php
                                              }
                                        ?>

                                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                    </div>
                                    </a>

                                <?php
                         }
                      }
                      else
                      {
                          //Categories not available
                          echo "<div class='error' style='color:red'>Category Not Found</div>";
                      }            
                  }


      ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
           
            <?php
                  //Create SQL Query to Display Categories from database
                  $sql2="SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                  //Execute the query
                  $res2=mysqli_query($conn,$sql2);

                  //check whether the query is executed or not
                  if($res2==TRUE)
                  {
                      //check whether the category is available or not
                      $count2=mysqli_num_rows($res2);//func to get all rows in database
                      
                      //check whether we have admin data or not
                      if($count2>0)
                      {
                      //Get the details
                      
                         while($row=mysqli_fetch_assoc($res2))
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
                                        <!-- pass id as well to know which food user wants -->
                                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                    </div>
                                </div>
                                 
                             <?php
                         }

                        }
                        else
                        {
                            //Food not available
                            echo "<div class='error' style='color:red'>Image Not Available</div>";
                        }
                        
                  }

            ?>

            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
