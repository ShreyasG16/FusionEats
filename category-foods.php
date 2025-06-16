<?php 
    include('partials-front/menu.php'); 
    include('config/connection.php'); // Include database connection
?>

<?php
    // Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        // Category id is set, get id
        $category_id = $_GET['category_id'];

        // Get category title based on category id
        $sql = "SELECT title FROM tbl_category WHERE id = $category_id";

        // Execute the query
        $res = mysqli_query($connections['primary'], $sql);

        if($res) {
            // Check if the category exists
            $row = mysqli_fetch_assoc($res);
            $category_title = $row['title'];
        } else {
            // If category does not exist, redirect to home page
            header('location:'.SITEURL);
            exit();
        }
    }
    else
    {
        // Redirect to home page if category ID is not set
        header('location:'.SITEURL);
        exit();
    }      
?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
    <div class="container">
        <h2 style="color:black">Food on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<!-- FOOD MENU Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
            // Create SQL Query to Display food from database
            $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id AND active = 'Yes'";

            // Execute the query
            $res2 = mysqli_query($connections['primary'], $sql2);

            // Check if query execution was successful
            if ($res2) {
                $count2 = mysqli_num_rows($res2);
                
                // Check whether food is available or not
                if($count2 > 0) {
                    // Display all foods
                    while($row2 = mysqli_fetch_assoc($res2)) {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?> 
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    // Check whether image is available or not
                                    if(empty($image_name)) {
                                        // Display message if image is not available
                                        echo "<div class='error' style='color:red'>Image Not Available</div>";
                                    } else {
                                        // Display image if available
                                        echo "<img src='" . SITEURL . "images/food/$image_name' alt='$title' class='img-responsive img-curve'>";
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
                    // Display message if no food items are available for the category
                    echo "<div class='error' style='color:red'>Food Not Available</div>";
                }            
            } else {
                // Display error message if query fails
                echo "<div class='error' style='color:red'>Failed to retrieve foods</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- FOOD MENU Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
