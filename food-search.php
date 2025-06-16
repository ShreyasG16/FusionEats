<?php 
include('partials-front/menu.php'); 
include('config/connection.php');
?>

<?php
// Defining weights for each similarity method
$weights = [
    'jaro_winkler' => 0.2,
    'levenshtein' => 0.4,
    'soundex' => 0.4,
];

// Jaro-Winkler similarity 
function jaro_winkler_similarity($str1, $str2) 
{
    similar_text($str1, $str2, $percent);
    return $percent / 100;
}

// Tokenize and clean search input
function tokenize_and_clean($search_query) {
    $search_query = strtolower(preg_replace("/[^a-z0-9 ]/", "", $search_query));
    $stopwords = ['and', 'the', 'is', 'in', 'for', 'to', 'a', 'on', 'with', 'at'];
    $tokens = explode(' ', $search_query);
    $tokens = array_diff($tokens, $stopwords);
    return array_values($tokens);
}

// Calculating fused score
function calculate_weighted_score($tokens, $title, $description, $weights) {
    $total_score = 0;
    foreach ($tokens as $token) {
        $title_score = jaro_winkler_similarity($token, $title);
        $desc_score = jaro_winkler_similarity($token, $description);
        $fuzzy_score = max($title_score, $desc_score);

        $lev_title = levenshtein($token, $title);
        $lev_desc = levenshtein($token, $description);
        $lev_score = max(
            1 - ($lev_title / max(strlen($token), strlen($title), 1)),
            1 - ($lev_desc / max(strlen($token), strlen($description), 1))
        );


        $soundex_token = soundex($token);
        $soundex_title = soundex($title);
        $soundex_desc = soundex($description);
        $phonetic_score = ($soundex_token == $soundex_title || $soundex_token == $soundex_desc) ? 1 : 0;

        $total_score += $weights['jaro_winkler'] * $fuzzy_score +
                        $weights['levenshtein'] * $lev_score +
                        $weights['soundex'] * $phonetic_score;
    }
    return $total_score / count($tokens);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center" style="background-image:url('https://img.freepik.com/free-photo/red-habanero-chili-pepper-with-peppercorns-coconut-flakes-arranged-circles-yellow-background-copy-space-middle-your-recipe-other-information-about-ingredient-vegetables-concept_273609-38147.jpg?size=626&ext=jpg');">
    <div class="container">
        <?php
        if (isset($connections['primary']) && isset($_POST['search'])) {
            $conn = $connections['primary'];
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
        $sql = "SELECT * FROM tbl_food";
        $food_results = [];
        $similarity_threshold = 0.3;
        $tokens = tokenize_and_clean($search);

        foreach ($connections as $db_key => $conn) {
            if ($conn) {
                $res = mysqli_query($conn, $sql);
                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $title = $row['title'];
                        $description = $row['description'];
                        $row['score'] = calculate_weighted_score($tokens, $title, $description, $weights);
                        if ($row['score'] >= $similarity_threshold) {
                            $food_results[] = $row;
                        }
                    }
                }
            } else {
                echo "<div class='error' style='color:red'>Connection to database '{$db_key}' failed.</div>";
            }
        }

        usort($food_results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        if (!empty($food_results)) {
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
                            $image_path = (strpos($image_name, 'http') === 0)
                                ? htmlspecialchars($image_name)
                                : SITEURL . "images/food/" . htmlspecialchars($image_name);
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
