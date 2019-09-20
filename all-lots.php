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
    $pages = [0];
    $items_count = count($lots);
    $pages_count = (int) ceil($items_count / $page_items);

    if ($items_count > 0) {
        $pages = range(1, $pages_count);
    }

    if ($pages_count > 1) {
        $offset = ($cur_page - 1) * $page_items;
        $lots = get_lots_by_category($con, $category_id, $page_items, $offset);
    }

    $page_content = include_template("category.php", [
        "categories" => $categories,
        "lots" => $lots,
        "category_id" => $category_id,
        "category_name" => $category_name,
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
}
else {
    header("Location: /");
}


