<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$calendar_css = '<link href="../css/flatpickr.min.css" rel="stylesheet">';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validate_lot($validators);

    if (empty($errors)) {
        $newLotId = insert_lot($con);
        header("Location: lot.php?id=" . $newLotId);
    }

    $page_content = include_template('add-lot.php', [
        "categories" => $categories,
        "nav" => $nav,
        "errors" => $errors
    ]);
}
else {
    $page_content = include_template("add-lot.php", [
        "categories" => $categories,
        "nav" => $nav
    ]);
}

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "calendar_css" => $calendar_css,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
