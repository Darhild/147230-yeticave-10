<?php
require_once "helpers.php";
require_once "data.php";
require_once "functions.php";
require_once "init.php";

if(!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $sql1 = "SELECT name, symbol_code FROM category";
    $sql2 = "SELECT l.name, c.name as category,
            IFNULL ((SELECT value FROM bid as b
            WHERE b.lot_id = l.id
            ORDER BY b.value DESC LIMIT 1
            ), start_price) as price, 
            image_url,
            date_expire
            FROM lot as l
            JOIN category as c
            ON l.category_id = c.id
            WHERE date_expire > NOW()
            ORDER BY date_expire ASC";

    $result1 = mysqli_query($con, $sql1);
    $result2 = mysqli_query($con, $sql2);


    if ($result1) {
        $categories = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    }
    else {
        print("Ошибка: " . mysqli_error($con));
    }

    if ($result2) {
        $lots = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    }
    else {
        print("Ошибка: " . mysqli_error($con));
    }
}

$header = include_template("header.php", [
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

$footer = include_template("footer.php", [
    "categories" => $categories
]);

$page_content = include_template("main.php", [
    "categories" => $categories,
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "page_title" => "Интернет-аукцион горнолыжного снаряжения",
    "header" => $header,
    "footer" => $footer,
    "content" => $page_content,
    "categories" => $categories
]);

print($layout_content);

