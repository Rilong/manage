<?php
    if (!isset($_COOKIE["userLogin"]) && !isset($_COOKIE["userPassword"])) {
        header("Location: auth.php");
        exit();
    }
    $config = require("system/config.php");
    $mysqli = new mysqli($config["db_host"],$config["db_user"], $config["db_password"], $config["db_name"]);
    $result_set = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$_COOKIE["userLogin"]."'");
    $user = $result_set->fetch_assoc();
    $result_set->close();
    $mysqli->close();

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Планування дня</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/remodal.css">
    <link rel="stylesheet" href="css/remodal-default-theme.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="login">Ваш логін: <?=$_COOKIE["userLogin"]?></div>
        <a href="/logout.php" class="logout"><i class="icon-logout"></i></a>
        <h1>Планування дня</h1>
    </header>
    <div id="container">
        <div id="AddTasks">
            <h2>Додавання завдання</h2>
            <div id="plan">
                <div class="times">
                    <h3 class="label">плануємо З</h3>
                    <div id="with" data-remodal-target="modal"><?=$user["with"]?></div>
                    <h3 class="label">плануємо ДО</h3>
                    <div id="to" data-remodal-target="modal"><?=$user["to"]?></div>
                </div>
                <div class="clear"></div>
                <div id="forms">
                    <input type="text" id="TaskName" placeholder="Назва завдання">
                    <input type="text" id="duration" placeholder="Тривалість">
                    <input type="button" id="addTaskSend" value="Додати завдання"/>
                </div>
                <div id="availableMinutesBlock">
                    <h3 class="labelAvailableMinutes">доступно хвилин</h3>
                    <div id="availableMinutes"><?=$user["time"]?></div>
                </div>
            </div>
        </div>
        <div id="listTasks">
            <div class="noTasks">Завантаження...</div>
        </div>
    </div>
    <!--===================================Remodal set time=====================================-->
    <div class="remodal" data-remodal-id="modal">
        <h1>Встановлення часу</h1>
        <div class="hours-block">
            <h3>Години</h3>
            <div class="hours">
                <ul class="hours-list">
                    <li>00</li>
                    <li>01</li>
                    <li>02</li>
                    <li>03</li>
                    <li>04</li>
                    <li>05</li>
                    <li>06</li>
                    <li>07</li>
                    <li>08</li>
                    <li>09</li>
                    <li>10</li>
                    <li>11</li>
                    <li>12</li>
                    <li>13</li>
                    <li>14</li>
                    <li>15</li>
                    <li>16</li>
                    <li>17</li>
                    <li>18</li>
                    <li>19</li>
                    <li>20</li>
                    <li>21</li>
                    <li>22</li>
                    <li>23</li>
                </ul>
            </div>
        </div>

        <div class="minutes-block">
            <h3>Хвилини</h3>
            <div class="minutes">
                <ul class="minutes-list">
                    <li>00</li>
                    <li>05</li>
                    <li>10</li>
                    <li>15</li>
                    <li>20</li>
                    <li>25</li>
                    <li>30</li>
                    <li>35</li>
                    <li>40</li>
                    <li>45</li>
                    <li>50</li>
                    <li>55</li>
                </ul>
            </div>
        </div>
        <br>
        <button data-remodal-action="cancel" class="remodal-cancel">Скасувати</button>
        <button data-remodal-action="confirm" class="remodal-confirm">Підтвердити</button>
    </div>
    <!--  remodal edit  -->
    <div class="remodal" data-remodal-id="modal-edit">
        <h1>Редагування завдання</h1>
        <div class="formEdit">
            <input type="text" class="TaskNameEdit" placeholder="Назва завдання">
            <input type="text" class="durationEdit" placeholder="Тривалість">
        </div>
        <button data-remodal-action="cancel" class="cancel-edit">Скасувати</button>
        <button data-remodal-action="confirm" class="confirm-edit">Підтвердити</button>
    </div>
    <!--===================================Remodal=====================================-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/remodal.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>