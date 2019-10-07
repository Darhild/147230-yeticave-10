<?php
$bid_data = filter_post_data($_POST, ["cost"]);
$page_data["bid"] = $bid_data["cost"];
$errors = validate_form($bid_data, $bid_validators, $lot);

if (empty($errors)) {
    $new_bid = insert_new_bid($con, $bid_data, $user_id, $lot["id"]);

    if (!isset($new_bid)) {
        header("Location: error.php?code=" . ERROR_DATA_INSERT);
    }

    header("Refresh:0");
}