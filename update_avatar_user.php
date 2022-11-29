<?php
// update_avatar_user.php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$avatar = $_GET['avatar'];

include 'config.php';

$db_connect->query("UPDATE users SET avatar = '$avatar', updated_at=NOW() WHERE id = $user_id");
mysqli_close($db_connect);

$_SESSION['avatar'] = $avatar;
