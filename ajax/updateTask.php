<?php
    $config = require "../system/config.php";
    $mysqli = new mysqli($config["db_host"],$config["db_user"], $config["db_password"], $config["db_name"]);
    $mysqli->set_charset("utf8");
    $id = (int) $_POST["id"];
    $time = (int) $_POST["time"];
    $name = $_POST["name"];
    $duration = $_POST["duration"];
    $result_set = $mysqli->query("SELECT `id` FROM `users` WHERE `login` = '".$_COOKIE["userLogin"]."'");
    $userid = $result_set->fetch_assoc();

    $mysqli->query("UPDATE `users` SET `time` = '$time' WHERE `login` = '".$_COOKIE["userLogin"]."'");
    $mysqli->query("UPDATE `tasks` SET `duration` = '$duration' WHERE `id` = '$id'");
    $mysqli->query("UPDATE `tasks` SET `name` = '$name' WHERE `id` = '$id'");
    $result_set->close();
    $mysqli->close();
    echo __FILE__;