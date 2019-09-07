<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

if (!$is_auth) {
    header("Location: error.php?code=" . ERROR_USER_NOT_AUTH);
}

$user_bids = get_user_bids($con, $user_id);

if (!isset($user_bids)) {
    header("Location: error.php?code=" . ERROR_DATA_GET);
}

$page_content = include_template("user-bids.php", [
    "categories" => $categories,
    "nav" => $nav,
    "user_bids" => $user_bids
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
