<?php
    $config = require "../system/config.php";
    $mysqli = mysqli_connect($config["db_host"], $config["db_user"], $config["db_password"], $config["db_name"]);
    $taskName = htmlspecialchars(trim($_POST["name"]));
    $duration = (int) htmlspecialchars(trim($_POST["duration"]));
    $time = (int) $_POST["time"];
    $result_set = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '".$_COOKIE["userLogin"]."'");
    $user = mysqli_fetch_assoc($result_set);
    mysqli_query($mysqli, "INSERT INTO `tasks` (`userid`, `name`, `duration`) VALUES ('".$user["id"]."', '$taskName', '$duration')");
    mysqli_query($mysqli, "UPDATE `users` SET `time` = '$time'");
    mysqli_close($mysqli);