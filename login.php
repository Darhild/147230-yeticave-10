<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$page_data = [
    "categories" => $categories,
    "nav" => $nav
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ["email", "password"];
    $user_data = filter_post_data($required_fields);
    $errors = validate_login_form($con, $user_data, $validators);

    if (empty($errors)) {
        $user = get_user_from_db($con, $user_data["email"]);
        $_SESSION = [
            "user" => $user["name"],
            "id" => $user["id"]
        ];
        header("Location: /");
    }
    else {
        $page_data["errors"] = $errors;
    }
}

$page_content = include_template("login-form.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);
