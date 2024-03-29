<?php
require_once "vendor/autoload.php";
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";
require_once "getwinner.php";

$lots = get_active_lots($con);

$page_content = include_template("main.php", [
    "categories" => $categories,
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

