<?php
    $config = require("system/config.php");
    $mysqli = new mysqli($config["db_host"],$config["db_user"], $config["db_password"], $config["db_name"]);
    $mysqli->set_charset("utf8");
    $result_set = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$_COOKIE["userLogin"]."'");
    $user = $result_set->fetch_assoc();
    $result_set = $mysqli->query("SELECT * FROM `tasks` WHERE `userid` = {$user["id"]}");
?>
<?php if ($result_set->num_rows != 0) {?>
<ul id="list">
    <?php while (($row = $result_set->fetch_assoc()) != false) {?>
        <li class="task">
            <div class="taskName"><?=$row["name"]?></div>
            <div class="control">
                <button class="edit" data-remodal-target="modal-edit" data-task-edit="<?=$row["id"]?>"><i class="icon-pencil"></i></button>
                <button class="delete" data-task-delete="<?=$row["id"]?>"><i class="icon-cancel-circled"></i></button>
            </div>
            <div class="duration">
                <i class="icon-stopwatch"></i>
                <div class="text"><?=$row["duration"]?> хв</div>
            </div>
        </li>
    <?php }?>
</ul>
<?php } else {?>
    <div class="noTasks">У вас немає завдань!</div>
<?php }?>
