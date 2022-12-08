<?php
// enable_user.php

$user_id = $_GET["user"];

include 'config.php';

$db_connect->query("UPDATE users SET deleted_at = NULL, updated_at=NOW() WHERE id = $user_id");
mysqli_close($db_connect);
