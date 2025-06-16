<?php 
include('partials-front/menu.php'); 
include('config/connection.php'); // Ensure the correct path to the connection file
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
    <div class="container">
        <?php
            // Check if the connection array is set and if search input exists
            if (isset($connections['primary']) && isset($_POST['search'])) {
                $conn = $connections['primary'];
                // Get the search keyword and sanitize it to protect from SQL injection
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            } else {
                die("Database connection not available or search term not provided.");
            }
        ?>
        <h2 style="color:black">Foods on Your Search <a href="#" class="text-white">"<?php echo htmlspecialchars($search); ?>"</a></h2>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
            // Query to search for foods based on search keyword
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            // Initialize an empty array to hold results from all databases
            $food_results = [];

            // Check that each connection is set before using it
            foreach ($connections as $db_key => $conn) {
                if ($conn) {
                    $res = mysqli_query($conn, $sql);
                    if ($res && mysqli_num_rows($res) > 0) {
                        // Fetch all matching rows and add them to $food_results array
                        while ($row = mysqli_fetch_assoc($res)) {
                            $food_results[] = $row;
                        }
                    }
                } else {
                    echo "<div class='error' style='color:red'>Connection to database '{$db_key}' failed.</div>";
                }
            }

            // Check if any food items were found across all databases
            if (!empty($food_results)) {
                // Loop through each food item and display it
                foreach ($food_results as $row) {
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
                                if (strpos($image_name, 'http') === 0) {
                                    // Remote image URL, use it as is
                                    $image_path = htmlspecialchars($image_name);
                                } else {
                                    // Local image, construct the full path
                                    $image_path = SITEURL . "images/food/" . htmlspecialchars($image_name);
                                }
                                ?>
                                <img src="<?php echo $image_path; ?>" alt="Food Image" class="img-responsive img-curve">
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
                            <!-- Modified Order Now button with dynamic food ID -->
                            <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='error' style='color:red'>Food Not Found</div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->


<?php include('partials-front/footer.php'); ?>
