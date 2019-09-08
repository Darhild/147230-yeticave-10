<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$page_data = [
    "categories" => $categories,
    "nav" => $nav,
];

$search = $_GET["search"] ?? "";

if ($search) {
    $page_data["search"] = $search;
    $searched_lots = search_lots($con, $search);

    if (!isset($searched_lots)) {
        header("Location: error.php?code=" . ERROR_DATA_GET);
    }

    $page_data["searched_lots"] = $searched_lots;
}

$page_content = include_template("search-page.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Поиск по активным лотам",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);


