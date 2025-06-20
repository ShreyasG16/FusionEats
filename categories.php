<?php 
    include('partials-front/menu.php'); 
    include('config/connection.php'); // Include the database connection
?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>
        
        <?php
              // Create SQL Query to Display Categories from the primary database
              $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

              // Execute the query using the primary connection
              $res = mysqli_query($connections['primary'], $sql);

              // Check whether the query is executed successfully
              if ($res == TRUE) {
                  // Check if categories are available
                  $count = mysqli_num_rows($res);
                  
                  if ($count > 0) {
                      // Display each category
                      while ($row = mysqli_fetch_assoc($res)) {
                          $id = $row['id'];
                          $title = $row['title'];
                          $image_name = $row['image_name'];
                          ?> 
                          <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id ?>">
                              <div class="box-3 float-container">
                                  <?php
                                      if ($image_name == "") {
                                          echo "<div class='error' style='color:red'>Image Not Available</div>";
                                      } else {
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
                  } else {
                      echo "<div class='error' style='color:red'>Category Not Found</div>";
                  }            
              }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
