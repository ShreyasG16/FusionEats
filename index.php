<?php 
include('partials-front/menu.php'); 
include('config/connection.php'); // Include the database connections
?>

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
if(isset($_SESSION['order'])) // checking whether the session is set or not
{
    echo $_SESSION['order']; // Displaying session message
    unset($_SESSION['order']); // Removing session message
}
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>
        
        <?php
            // Create SQL Query to Display Categories from the primary database
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

            // Execute the query
            $res = mysqli_query($connections['primary'], $sql); // Updated to use $connections['primary']

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                if ($count > 0) {
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
                                        // Determine if the image is from a remote URL or local path
                                        $image_path = (strpos($image_name, 'http') === 0) ? $image_name : SITEURL . "images/category/" . $image_name;
                                        ?>
                                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Food" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                <h3 class="float-text text-white"><?php echo htmlspecialchars($title); ?></h3>
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

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        
        <?php
            // Create SQL Query to Display Food from the primary database
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

            // Execute the query
            $res2 = mysqli_query($connections['primary'], $sql2); // Updated to use $connections['primary']

            if ($res2 == TRUE) {
                $count2 = mysqli_num_rows($res2);
                if ($count2 > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if ($image_name == "") {
                                        echo "<div class='error' style='color:red'>Image Not Available</div>";
                                    } else {
                                        // Determine if the image is from a remote URL or local path
                                        $image_path = (strpos($image_name, 'http') === 0) ? $image_name : SITEURL . "images/food/" . $image_name;
                                        ?>
                                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Food" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo htmlspecialchars($title); ?></h4>
                                <p class="food-price">₹<?php echo htmlspecialchars($price); ?></p>
                                <p class="food-detail">
                                    <?php echo htmlspecialchars($description); ?>
                                </p>
                                <br>
                                <!-- Modified the link to include source parameter -->
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>&source=remote" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='error' style='color:red'>Food Not Available</div>";
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


