<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$id =  get_param_from_query("id");

if (empty($id)) {
    http_response_code(404);
    header("Location: /pages/404.html");
}

$lot_item = get_lot_by_id($con, $id);

if (empty($lot_item)) {
    http_response_code(404);
    header("Location: /pages/404.html");
}

$page_content = include_template("lot-item.php", [
    "nav" => $nav,
    "lot_item" => $lot_item
]);

$layout_content = include_template("layout.php", [
    "page_title" => $lot_item["name"],
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

