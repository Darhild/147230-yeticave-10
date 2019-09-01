<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validate_form($validators);

    if (empty($errors)) {
        insert_new_user($con);
        header("Location: pages/login.html");
    }

    $page_content = include_template('sign-form.php', [
        "categories" => $categories,
        "nav" => $nav,
        "errors" => $errors
    ]);
}
else {
    $page_content = include_template("sign-form.php", [
        "categories" => $categories,
        "nav" => $nav
    ]);
}

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
