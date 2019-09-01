<?php
$is_auth = rand(0, 1);
$user_name = "Maria";
$categories = get_categories($con);
$cats_ids = array_column($categories, "id");

$header = include_template("header.php", [
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

$nav = include_template("nav.php", [
    "categories" => $categories
]);

$footer = include_template("footer.php", [
    "categories" => $categories
]);

$lots = get_active_lots($con);

$validators = [
    "lot-name" => function() {
        return validate_filled("lot-name");
    },
    "category" => function() use ($cats_ids) {
        return validate_category("category", $cats_ids);
    },
    "message" => function() {
        return validate_filled("message");
    },
    "lot-rate" => function() {
        if (!validate_filled("lot-rate")) {
            return is_num_positive_int("lot-rate");
        }

        return validate_filled("lot-rate");
    },
    "lot-step" => function() {
        if (!validate_filled("lot-step")) {
            return is_num_positive_int("lot-step");
        }

        return validate_filled("lot-step");
    },
    "lot-date" => function() {
        if (!validate_filled("lot-date")) {
            return validate_date("lot-date");
        }

        return validate_filled("lot-date");
    },
    "name" => function() {
        return validate_filled("name");
    },
    "email" => function() {
        if (!validate_filled("email")) {
            return validate_email("email");
        }

        return validate_filled("email");
    },
    "password" => function() {
        return validate_filled("password");
    }
];
