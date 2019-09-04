<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

if ($is_auth) {
    http_response_code(403);
    header("Location: /");
    exit;
}

$page_data = [
    "categories" => $categories,
    "nav" => $nav
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ["name", "email", "password", "message"];
    $user_data = filter_post_data($required_fields);
    $errors = validate_registration_form($con, $user_data, $user_validators);

    if (empty($errors)) {
        $user = insert_new_user($con, $user_data);

        if (!$user) {            
            header("Location: error.php?code=" . ERROR_USER_INSERT);            
        }

        header("Location: login.php");
    }
    else {
        $page_data["errors"] = $errors;
    }
}

$page_content = include_template("sign-form.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
