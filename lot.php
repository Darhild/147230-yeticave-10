<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

if(empty($id) || empty($lot_item)) {
    http_response_code(404);
    header("Location: /pages/404.html");
}

$page_content = include_template("lot-item.php", [
    "categories" => $categories,
    "lot_item" => $lot_item
]);

$layout_content = include_template("layout.php", [
    "page_title" => $lot_item["name"],
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content,
    "categories" => $categories
]);

print($layout_content);

