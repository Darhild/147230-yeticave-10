<?php
$is_auth = rand(0, 1);
$user_name = "Maria";
$categories = getCategories($con);

$header = include_template("header.php", [
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

$footer = include_template("footer.php", [
    "categories" => $categories
]);

$lots = getActiveLots($con);
