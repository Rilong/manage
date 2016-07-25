<?php
    $config = require_once  "../system/config.php";
    $mysqli = new mysqli($config["db_host"],$config["db_user"], $config["db_password"], $config["db_name"]);

    $login = $_POST["login"];

    $result_set = $mysqli->query("SELECT * FROM `users` WHERE `login` = '$login'");
    if ($result_set->num_rows == 0) {
        echo "yas";
    }else echo "no";
    $result_set->close();
    $mysqli->close();
    
    

