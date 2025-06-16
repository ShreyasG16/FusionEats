<?php 
    include('partials-front/menu.php'); 
    include('config/connection.php'); // Ensure database connection is included
?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<!-- FOOD MENU Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
            // Create SQL Query to Display Active Foods from the primary database
            $sql_primary = "SELECT * FROM tbl_food WHERE active='Yes'";
            $res_primary = mysqli_query($connections['primary'], $sql_primary);

            // Create SQL Query to Display Active Foods from the remote database
            $sql_remote = "SELECT * FROM tbl_food WHERE active='Yes'";
            $res_remote = mysqli_query($connections['remote'], $sql_remote);

            // Initialize an empty array to store all food items
            $food_items = [];

            // Fetch from the primary database
            if ($res_primary && mysqli_num_rows($res_primary) > 0) {
                while ($row = mysqli_fetch_assoc($res_primary)) {
                    $food_items[] = $row;
                }
            }

            // Fetch from the remote database
            if ($res_remote && mysqli_num_rows($res_remote) > 0) {
                while ($row = mysqli_fetch_assoc($res_remote)) {
                    $food_items[] = $row;
                }
            }

            // Check if any food items are available
            if (count($food_items) > 0) {
                foreach ($food_items as $row) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                                // Check if image is available as a URL or a local file
                                if (empty($image_name)) {
                                    // Display error if no image
                                    echo "<div class='error' style='color:red'>Image Not Available</div>";
                                } else {
                                    // Check if image_name is a URL or local file
                                    if (filter_var($image_name, FILTER_VALIDATE_URL)) {
                                        // Display image from URL
                                        echo "<img src='$image_name' alt='$title' class='img-responsive img-curve'>";
                                    } else {
                                        // Display image from local file path
                                        echo "<img src='" . SITEURL . "images/food/$image_name' alt='$title' class='img-responsive img-curve'>";
                                    }
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
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // Display message if no food items available
                echo "<div class='error' style='color:red'>Food Not Available</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- FOOD MENU Section Ends Here -->

<?php include('partials-front/footer.php'); ?>