<?php
    $config = require "../system/config.php";
    $mysqli = new mysqli($config["db_host"],$config["db_user"], $config["db_password"], $config["db_name"]);
    $mysqli->set_charset("utf8");
    $TimeMinutes = (int) $_POST["TimeMinutes"];
    $Time = trim($_POST["Time"]);
    $elementId = trim($_POST["elementId"]);

    if ($elementId == "with")
        $mysqli->query("UPDATE `users` SET `time` = '$TimeMinutes', `with` = '$Time' WHERE `login`= '".$_COOKIE["userLogin"]."'");
    else
        $mysqli->query("UPDATE `users` SET `time` = '$TimeMinutes', `to` = '$Time' WHERE `login`= '".$_COOKIE["userLogin"]."'");
    $mysqli->close();