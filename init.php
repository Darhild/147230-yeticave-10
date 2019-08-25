<?php
if (!file_exists("config/db.php")) {
    echo 'Database config does not exist';
    exit;
}

require_once "config/db.php";
$con = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
mysqli_set_charset($con, "utf8");

if(!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
    exit;
}

