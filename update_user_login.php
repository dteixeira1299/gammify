<?php
// update_user_login.php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];

include 'config.php';

$db_connect->query("UPDATE users SET last_login = NOW() WHERE id = $user_id");
mysqli_close($db_connect);
