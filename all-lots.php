<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$category_id = return_int_from_query("category", $_GET);

if (!empty($category_id)) {
    $category_name = get_category_by_id($con, $category_id)["name"];
    $lots = get_active_lots_by_category($con, $category_id);
    $page_items = 9;

    require_once "pagination-data.php";

    if ($pages_count > 1) {
        $lots = get_active_lots_by_category($con, $category_id, $page_items, $offset);
        $pagination_data["link"] = "/all-lots.php/?category={$category_id}&page=";
        $pagination_block = include_template("pagination_block.php", $pagination_data);
    }

    $page_content = include_template("category.php", [
        "categories" => $categories,
        "lots" => $lots,
        "category_id" => $category_id,
        "category_name" => $category_name,
        "nav" => $nav,
        "pagination_block" => $pagination_block
    ]);

    $layout_content = include_template("layout.php", [
        "page_title" => "Интернет-аукцион горнолыжного снаряжения | {$category_name}",
        "header" => $header,
        "footer" => $footer,
        "content" => $page_content
    ]);

    print($layout_content);
}
else {
    header("Location: /");
}


