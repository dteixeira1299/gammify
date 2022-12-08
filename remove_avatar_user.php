<?php
// remove_avatar_user.php

$user_id = $_GET["user"];

include 'config.php';

$db_connect->query("UPDATE users SET avatar = NULL, updated_at=NOW() WHERE id = $user_id");
mysqli_close($db_connect);
