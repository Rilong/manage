<?php
    if(isset($_COOKIE["userLogin"]) && isset($_COOKIE["userPassword"])) {
        header("Location: index.php");
        exit();
    }
    $config = require ("system/config.php");
    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);
    $message = "";

    if(isset($_POST["sendAuth"])) {
        $mysqli = new mysqli($config["db_host"], $config["db_user"], $config["db_password"], $config["db_name"]);
        $result_set = $mysqli->query("SELECT * FROM `users` WHERE `login`='$login'");
        $user = $result_set->fetch_assoc();

        if (strlen($login) == 0)
            $message = "Введіть логін!";
        elseif (strlen($password) == 0)
            $message = "Введіть пароль!";
        elseif (md5($config["secret"].$password) != $user["password"])
            $message = "Такого користувача не існує!";
        elseif ($result_set->num_rows == 0)
            $message = "Такого користувача не існує!";

        $loginDB = $user["login"];
        $passwordDB = $user["password"];

        $mysqli->close();
        if (strlen($message) == 0) {
            setcookie("userLogin", $loginDB, time() + 60 * 60 * 24 * 30);
            setcookie("userPassword", $passwordDB, time() + 60 * 60 * 24 * 30);
            header("Location: index.php");
            exit;
        }
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизація</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="css/RegAndAuth.css">
</head>
<body>
<header>
    <h1>Планування дня</h1>
</header>
<div id="container">
    <div id="auth">
        <h2>Авторизація</h2>
        <div class="messages">
            <div class="messageError"></div>
            <?php if (strlen($message) != 0) {?>
                <div class="messageErrorPHP"><?=$message?></div>
            <?php }?>
        </div>
        <form action="" name="auth" method="post">
           <div id="userForm">
               <input type="text" name="login" placeholder="Логін" />
               <input type="password" name="password" placeholder="Пароль" />
               <a href="register.php" class="linkBtn">Регистрація</a>
               <input type="submit" name="sendAuth" value="Увійти" />
           </div>
        </form>
    </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
    <noscript>
        <div class="noScript">
            <i class="icon-error-alt"></i>
            Помилка! увімкніть будь-ласка JavaScript у своєму веб-переглядачі, робота сайту буде некоректна!
        </div>
    </noscript>
</body>
</html>
