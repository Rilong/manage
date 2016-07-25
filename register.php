<?php
    $config = require ("system/config.php");

    date_default_timezone_set("Europe/Kiev");
    setlocale(LC_ALL, "uk_UA");

    $login = htmlspecialchars($_POST["login"]);
    $name = htmlspecialchars($_POST["name"]);
    $password = htmlspecialchars($_POST["password"]);
    $passwordRepeat = htmlspecialchars($_POST["passwordRepeat"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = "";

    if (isset($_POST["sendReg"])) {
        $mysqli = new mysqli($config["db_host"], $config["db_user"], $config["db_password"], $config["db_name"]);
        $mysqli->set_charset("utf8");
        $loginDB = $mysqli->query("SELECT * FROM `users` WHERE `login`='$login'");
        $emailDB = $mysqli->query("SELECT * FROM `users` WHERE `email`='$email'");
        if (strlen($login) == 0)
            $message = "Введіть логін!";
        elseif (!preg_match("/[a-z]/i", $login))
            $message = "Некоректний логін";
        elseif ($loginDB->num_rows != 0) {
            $message = "Логін зайнятий!";
            $loginDB->close();
        }
        elseif (strlen($login) > 20)
            $message = "Логін занадто довгий!";
        elseif (strlen($name) == 0)
            $message = "Введіть ім'я!";
        elseif(strlen($name) > 30)
            $message = "Ім'я занадто довге!";
        elseif (strlen($password) == 0)
            $message = "Введіть пароль!";
        elseif (strlen($password) < 6)
            $message = "Пароль занадто короткий!";
        elseif ($password != $passwordRepeat)
            $message = "Паролі не співпадають!";
        elseif (strlen($email) == 0)
            $message = "Введіть E-mail!";
        elseif (!preg_match("/^[a-z0-9_][a-z0-9\._-]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+$/i", $email))
            $message = "Некоректний E-mail!";
        elseif ($emailDB->num_rows != 0) {
            $message = "E-mail зайнятий!";
            $emailDB->close();
        }
        if (strlen($message) == 0) {
            $mysqli->query("INSERT INTO `users` (`login`, `name`, `password`, `email`, `regdate`, `time`) VALUES ('$login', '$name', '".md5($config["secret"].$password)."', '$email', '".time()."', '840')");
            $mysqli->close();
        }
    }

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="css/RegAndAuth.css">
    <link rel="stylesheet" href="css/fontello.css">
</head>
<body>
<header>
    <h1>Планування дня</h1>
</header>
<div id="container">
    <div id="reg">
            <h2>Реєстрація</h2>
            <div class="messages">
                <div class="messageError"></div>
                <?php if (strlen($message) != 0) {?>
                    <div class="messageErrorPHP"><?=$message?></div>
                <?php }?>
                <div class="messageSuccess"></div>
            </div>
             <form action="" name="reg" method="post">
                <div id="userForm">
                    <input type="text" name="login" placeholder="Логін" />
                    <input type="button" name="checkLogin" value="Перевірити логін"/>
                    <input type="text" name="name" placeholder="Ім'я" />
                    <input type="password" name="password" placeholder="Пароль" />
                    <input type="password" name="passwordRepeat" placeholder="Повторіть пароль" />
                    <input type="text" name="email" placeholder="E-mail" />
                    <input type="submit" name="sendReg" value="Зареєструватися" />
                </div>
            </form>
        </div>
    </div>
    <noscript>
        <div class="noScript">
            <i class="icon-error-alt"></i>
            Помилка! увімкніть будь-ласка JavaScript у своєму веб-переглядачі, робота сайту буде некоректна!
        </div>
    </noscript>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
</body>
</html>
