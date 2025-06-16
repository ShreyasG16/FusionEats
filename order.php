<?php
include('partials-front/menu.php'); 
include('config/connection.php'); // Ensure the connection file is included

// Initialize variables
$title = '';
$price = '';
$image_name = '';

if (isset($_GET['food_id'])) {
    // Get the Food ID
    $food_id = $_GET['food_id'];
    $found = false;

    // First, try fetching from the primary database
    $sql_primary = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res_primary = mysqli_query($connections['primary'], $sql_primary);

    if ($res_primary && mysqli_num_rows($res_primary) == 1) {
        $row = mysqli_fetch_assoc($res_primary);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
        $found = true;
    }

    // If not found, fetch from the remote database
    if (!$found) {
        $sql_remote = "SELECT * FROM tbl_food WHERE id=$food_id";
        $res_remote = mysqli_query($connections['remote'], $sql_remote);

        if ($res_remote && mysqli_num_rows($res_remote) == 1) {
            $row = mysqli_fetch_assoc($res_remote);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
            $found = true;
        }
    }

    // Redirect if food is not found in both databases
    if (!$found) {
        header('location:' . SITEURL);
        exit();
    }
} else {
    // Redirect to homepage if no food_id
    header('location:' . SITEURL);
    exit();
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search" style="background-image:url('https://img.freepik.com/free-photo/abstract-dark-blurred-background-smooth-gradient-texture-color-shiny-bright-website-pattern-banner-header-sidebar-graphic-art-image_1258-82961.jpg?size=626&ext=jpg'); background-size: cover;">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>
        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php 
                        if (empty($image_name)) {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            if (filter_var($image_name, FILTER_VALIDATE_URL)) {
                                echo "<img src='$image_name' alt='$title' class='img-responsive img-curve'>";
                            } else {
                                echo "<img src='" . SITEURL . "images/food/$image_name' alt='$title' class='img-responsive img-curve'>";
                            }
                        }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price">₹<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. John Doe" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@gmail.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php
            // Order submission logic
            if (isset($_POST['submit'])) {
                // Retrieve order details
                $food = mysqli_real_escape_string($connections['primary'], $_POST['food']);
                $price = mysqli_real_escape_string($connections['primary'], $_POST['price']);
                $qty = mysqli_real_escape_string($connections['primary'], $_POST['qty']);
                $total = $price * $qty;
                $order_date = date("Y-m-d h:i:sa");
                $status = "Ordered";
                $customer_name = mysqli_real_escape_string($connections['primary'], $_POST['full-name']);
                $customer_contact = mysqli_real_escape_string($connections['primary'], $_POST['contact']);
                $customer_email = mysqli_real_escape_string($connections['primary'], $_POST['email']);
                $customer_address = mysqli_real_escape_string($connections['primary'], $_POST['address']);

                // Insert order into primary database
                $sql_order = "INSERT INTO tbl_order SET 
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'";

                $res_order = mysqli_query($connections['primary'], $sql_order);

                if ($res_order) {
                    $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully</div>";
                    header('location:' . SITEURL);
                } else {
                    $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food</div>";
                    header('location:' . SITEURL);
                }
            }
        ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->