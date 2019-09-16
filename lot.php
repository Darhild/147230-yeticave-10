<?php
require_once "init.php";
require_once "helpers.php";
require_once "functions.php";
require_once "data.php";

$id = return_int_from_query("id", $_GET);

if (empty($id)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$lot = get_lot_by_id($con, $id);
$lot_bids = get_lot_bids($con, $lot["id"]);

if (empty($lot)) {
    http_response_code(404);
    header("Location: error.php?code=" . ERROR_404);
}

$is_bid_allowed = $is_auth
    && (int) $user_id !== (int) $lot["last_bid_user_id"]
    && (int) $user_id !== (int) $lot["seller_id"]
    && !is_lot_expired($lot);


$page_data = [
    "categories" => $categories,
    "nav" => $nav,
    "lot_item" => $lot,
    "is_auth" => $is_auth,
    "lot_bids" => $lot_bids,
    "is_bid_allowed" => $is_bid_allowed
];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $is_bid_allowed) {
    require_once "make_bid.php";    

    $page_data["errors"] = $errors;
}

$page_content = include_template("lot-item.php", $page_data);

$layout_content = include_template("layout.php", [
    "page_title" => $lot["name"],
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content
]);

print($layout_content);

