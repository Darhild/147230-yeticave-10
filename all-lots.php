<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$category_id = return_int_from_query("category", $_GET);

if (empty($category_id)) {
    header("Location: /");    
}

$category_name = get_category_by_id($con, $category_id)["name"];
$lots = get_active_lots_by_category($con, $category_id);

$page_data = [
    "categories" => $categories,
    "lots" => $lots,
    "category_id" => $category_id,
    "category_name" => $category_name,
    "nav" => $nav
];

$page_items = 1;

require_once "pagination-data.php";

if ($pages_count > 1) {    
    $page_data["lots"] = get_active_lots_by_category($con, $category_id, $cur_page, $page_items);
    $pagination_data["link"] = "/all-lots.php?category={$category_id}&page=";
    $page_data["pagination_block"] = include_template("pagination_block.php", $pagination_data);
}

$page_content = include_template("category.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения | {$category_name}",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);



