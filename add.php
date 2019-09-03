<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$calendar_css = '<link href="../css/flatpickr.min.css" rel="stylesheet">';
$page_data = [
    "categories" => $categories,
    "nav" => $nav
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ["lot-name", "category", "message", "lot-rate", "lot-step", "lot-date"];
    $lots_data = filter_post_data($required_fields);
    $errors = validate_lot($lots_data, $lot_validators);

    if (empty($errors)) {
        $newLotId = insert_lot($con, $lots_data);

        header("Location: lot.php?id=" . $newLotId);
    }

    else {
        $page_data["errors"] = $errors;
    }
}

$page_content = include_template("add-lot.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "calendar_css" => $calendar_css,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
