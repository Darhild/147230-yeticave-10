<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$page_data = [
    "categories" => $categories,
    "nav" => $nav,
    "pagination_block" => ""
];

$search = $_GET["search"] ?? "";

if ($search) {
    $page_data["search"] = trim($search);
    $lots = search_active_lots($con, $search);
    $page_data["lots"] = $lots;
    $page_items = 9;

    require_once "pagination-data.php";

    if ($pages_count > 1) {
        $page_data["lots"] = search_active_lots($con, $search, $cur_page, $page_items);       
        $pagination_data["link"] = "/search.php?search=${search}&page=";
        $page_data["pagination_block"] = include_template("pagination_block.php", $pagination_data);
    }
}

$page_content = include_template("search-page.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Поиск по активным лотам",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);


