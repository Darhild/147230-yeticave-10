<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$error_code = $_REQUEST["code"] ?? "";

if ($error_code === "" || !isset($error_messages[$error_code])) {
    header("Location: /");
}

$page_content = include_template("error-page.php", [
    "nav" => $nav,
    "error" => $error_messages[$error_code]
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Ошибка",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

