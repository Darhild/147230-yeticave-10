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

$lot_validators = [
    "lot-name" => function ($data) {
        return validate_filled($data, "lot-name");
    },
    "category" => function ($data) use ($cats_ids) {
        return validate_category($data, "category", $cats_ids);
    },
    "message" => function ($data) {
        return validate_filled($data, "message");
    },
    "lot-rate" => function ($data) {
        if (!validate_filled($data, "lot-rate")) {
            return is_num_positive_int($data, "lot-rate");
        }
        return validate_filled($data, "lot-rate");
    },
    "lot-step" => function ($data) {
        if (!validate_filled($data, "lot-step")) {
            return is_num_positive_int($data, "lot-step");
        }
        return validate_filled($data, "lot-step");
    },
    "lot-date" => function ($data) {
        if (!validate_filled($data, "lot-date")) {
            return validate_date($data, "lot-date");
        }
        return validate_filled($data, "lot-date");
    }    
];

$user_validators = [
    "name" => function ($data) {
        return validate_filled($data, "name");
    },
    "password" => function ($data) {
        return validate_filled($data, "password");
    },
    "email" => function ($data) {
        if (!validate_filled($data, "email")) {
            return validate_email($data, "email");
        }
        return validate_filled($data, "email");
    }
]
