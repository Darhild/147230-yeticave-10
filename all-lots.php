<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$category = get_param_from_query("category");

if (isset($category)) {
    $lots = get_lots_by_category($con, $category);

    if(!isset($lots)) {
        header("Location: error.php?code=" . ERROR_DATA_GET);
    }
}

else {
    header("Location: /");
}

$page_content = include_template("category.php", [
    "categories" => $categories,
    "lots" => $lots,
    "category" => $category,
    "nav" => $nav
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
