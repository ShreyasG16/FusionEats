<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            
            <?php
                  //Create SQL Query to Display Categories from database
                  $sql="SELECT * FROM tbl_category WHERE active='Yes'";

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


<?php include('partials-front/footer.php'); ?>