<?php
require_once "config/db.php";
$con = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
mysqli_set_charset($con, "utf8");



