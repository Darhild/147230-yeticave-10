<?php
require_once "helpers.php";
require_once "data.php";
require_once "functions.php";

$header = include_template("header.php", [
    "is_auth" => $is_auth, 
    "user_name" => $user_name
]);

$footer = include_template("footer.php", [
    "categories" => $categories
]);

$page_content = include_template("main.php", [
    "categories" => $categories, 
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения", 
    "header" => $header, 
    "footer" => $footer, 
    "content" => $page_content, 
    "categories" => $categories
]);

print($layout_content);

