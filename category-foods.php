<?php include('partials-front/menu.php'); ?>

    <?php
        //Check whether id is passed or not
        if(isset($_GET['category_id']))
        {
            //category id is set get id
            $category_id=$_GET['category_id'];

            //get category title based on category id
            $sql ="SELECT title FROM tbl_category WHERE id=$category_id";

            //Execute the query
            $res=mysqli_query($conn,$sql);

            //get value from database
            $row=mysqli_fetch_assoc($res);
                
            //get the title
            $category_title=$row['title'];

            //display it on food search below
        }
        else
        {
            //redirect to home page
            header('location:'.SITEURL);
        }      
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
        <div class="container">
            
            <h2 style="color:black">Food on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

             <?php
                  //Create SQL Query to Display food from database
                  $sql2="SELECT * FROM tbl_food WHERE category_id=$category_id";

                  //Execute the query
                  $res2=mysqli_query($conn,$sql2);

            
                    //check whether the category is available or not
                      $count2=mysqli_num_rows($res);//func to get all rows in database
                      
                      //check whether food is available or not
                      if($count2>0)
                      {
                      //Get the details
                      
                         while($row2=mysqli_fetch_assoc($res2))
                         {
                              //Food is available  
                                $id =$row2['id'];
                                $title=$row2['title'];
                                $price=$row2['price'];
                                $description=$row2['description'];
                                $image_name=$row2['image_name'];
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

                                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary" class="btn btn-primary">Order Now</a>
                                    </div>

                                    </div>
                                <?php
                         }
                      }
                      else
                      {
                          //Categories not available
                          echo "<div class='error' style='color:red'>Food Not Available</div>";
                      }            

             ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>