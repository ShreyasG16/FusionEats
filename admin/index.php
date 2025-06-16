<?php 
    include('../config/constants.php'); 
    include('../config/connection.php'); // Ensure this is included to access the connections array
    include('partials/menu.php'); 
?>

<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>

        <div class="col-4 text-center">

            <?php 
                // SQL Query 
                $sql = "SELECT * FROM tbl_category";
                // Execute Query using primary connection
                $res = mysqli_query($connections['primary'], $sql);
                // Count Rows
                $count = mysqli_num_rows($res);
            ?>

            <h1><?php echo $count; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">

            <?php 
                // SQL Query 
                $sql2 = "SELECT * FROM tbl_food";
                // Execute Query using primary connection
                $res2 = mysqli_query($connections['primary'], $sql2);
                // Count Rows
                $count2 = mysqli_num_rows($res2);
            ?>

            <h1><?php echo $count2; ?></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">

            <?php 
                // SQL Query 
                $sql3 = "SELECT * FROM tbl_order";
                // Execute Query using primary connection
                $res3 = mysqli_query($connections['primary'], $sql3);
                // Count Rows
                $count3 = mysqli_num_rows($res3);
            ?>

            <h1><?php echo $count3; ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">

            <?php 
                // SQL Query to Get Total Revenue Generated
                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                // Execute Query using primary connection
                $res4 = mysqli_query($connections['primary'], $sql4);
                // Get the Value
                $row4 = mysqli_fetch_assoc($res4);
                // Get the Total Revenue
                $total_revenue = $row4['Total'];
            ?>

            <h1>₹<?php echo $total_revenue; ?></h1>
            <br />
            Revenue Generated
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
