<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

if ($is_auth) {
    http_response_code(403);
    header("Location: /");
}

$page_data = [
    "categories" => $categories,
    "nav" => $nav
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ["name", "email", "password", "message"];
    $user_data = filter_post_data($_POST, $required_fields);
    $page_data["user_data"] = $user_data;
    $errors = validate_registration_form($con, $user_data, $user_validators);

    if (empty($errors)) {
        $user = insert_new_user($con, $user_data);

        if (!isset($user)) {            
            header("Location: error.php?code=" . ERROR_USER_INSERT);            
        }

        header("Location: login.php");
    }

    $page_data["errors"] = $errors;

}

$page_content = include_template("sign-form.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
