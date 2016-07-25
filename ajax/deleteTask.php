<?php
    $config = require "../system/config.php";
    $mysqli = mysqli_connect($config["db_host"], $config["db_user"], $config["db_password"], $config["db_name"]);
    $id = $_POST["id"];
    $time = (int) $_POST["time"];
    $idToInt = (int) $id;
    mysqli_query($mysqli, "DELETE FROM `tasks` WHERE `id`='$idToInt'");
    mysqli_query($mysqli, "UPDATE `users` SET `time` = '$time'");
    mysqli_close($mysqli);
