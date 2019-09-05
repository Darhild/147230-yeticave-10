<?php
session_start();

if (!file_exists("config/db.php")) {
    echo 'Database config does not exist';
    exit;
}

require_once "config/db.php";
$con = mysqli_connect($database_host, $database_user, $database_password, $database_name);

if(!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
    exit;
}

mysqli_set_charset($con, "utf8");

