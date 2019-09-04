<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$id = get_param_from_query("id");

if (empty($id)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$lot_item = get_lot_by_id($con, $id);

if (empty($lot_item)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$page_data = [
    "categories" => $categories,
    "nav" => $nav,
    "lot_item" => $lot_item,
    "is_auth" => $is_auth
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!$is_auth) {
        header("Location: error.php?code=" . ERROR_USER_NOT_AUTH);
    }

    $bid_data = filter_post_data(["cost"]);
    $errors = validate_bid_form($bid_data, $lot_item, $bid_validators);

    if (empty($errors)) {
        $new_bid = insert_new_bid($con, $bid_data, $user_id, $lot_item["id"]);

        if (!isset($new_bid)) {
            header("Location: error.php?code=" . ERROR_DATA_INSERT);
        }

        header("Refresh:0");
    }
        $page_data["errors"] = $errors;

}

$page_content = include_template("lot-item.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => $lot_item["name"],
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

