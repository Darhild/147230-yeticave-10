<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$category = get_param_from_query("category");
$cur_page = get_param_from_query("page");

if (isset($category)) {
    $lots = get_lots_by_category($con, $category);

    if(!isset($lots)) {
        header("Location: error.php?code=" . ERROR_DATA_GET);
    }

    $page_items = 4;
    $pages = 0;
    $items_count = count($lots);
    $pages_count = (int) ceil($items_count / $page_items);     

    if ($items_count > 0) {
        $pages = range(1, $pages_count);
    }

    if ($pages_count > 1) {
        $offset = ($cur_page - 1) * $page_items;   
        $lots = get_lots_by_category($con, $category, $page_items, $offset);
    }    
}

else {
    header("Location: /");
}

$page_content = include_template("category.php", [
    "categories" => $categories,
    "lots" => $lots,
    "category" => $category,
    "nav" => $nav,
    "pages" => $pages,
    "cur_page" => $cur_page
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
