<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$id = get_param_from_query("id");

if (empty($id)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$lot_item = get_lot_by_id($con, $id);

if (empty($lot_item)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$page_content = include_template("lot-item.php", [
    "nav" => $nav,
    "lot_item" => $lot_item,
    "is_auth" => $is_auth
]);

$layout_content = include_template("layout.php", [
    "page_title" => $lot_item["name"],
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

