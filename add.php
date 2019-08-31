<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$calendar_css = '<link href="../css/flatpickr.min.css" rel="stylesheet">';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ["lot-name", "category", "message", "lot-rate", "lot-step", "lot-date"];
    $cats_ids = array_column($categories, "id");
    $errors = [];

    $rules = [
        "lot-name" => function() {
            return validateFilled("lot-name");
        },
        "category" => function() use ($cats_ids) {
            return validateCategory("category", $cats_ids);
        },
        "message" => function() {
            return validateFilled("message");
        },
        "lot-rate" => function() {
            if (!validateFilled("lot-rate")) {
                return isNumPositiveInt("lot-rate");
            }

            return validateFilled("lot-rate");
        },
        "lot-step" => function() {
            if (!validateFilled("lot-step")) {
                return isNumPositiveInt("lot-step");
            }

            return validateFilled("lot-step");
        },
        "lot-date" => function() {
            if (!validateFilled("lot-date")) {
                return validateDate("lot-date");
            }

            return validateFilled("lot-date");
        }
    ];

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    };

    if (!empty($_FILES["lot-img"]["name"])) {
        $errors["lot-img"] = validateImageFormat($_FILES["lot-img"]);
    }
    else {
        $errors["lot-img"] = "Загрузите изображение лота";
    }

    $errors = array_filter($errors);

    if (empty($errors)) {
        $newLotId = insertLot($con);
        header("Location: lot.php?id=" . $newLotId);
    }
    else {
        $page_content = include_template('add-lot.php', [
            "categories" => $categories,
            "nav" => $nav,
            "errors" => $errors
        ]);
    }
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
