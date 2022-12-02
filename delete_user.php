<?php

//start session on web page
session_start();

// Include config file
require_once "config.php";

// Check if the user is logged in by Google
if(isset($_SESSION["access_token"])){
    exit;
}

$user_id = $_SESSION['id'];

$db_connect->query("UPDATE users SET deleted_at = NOW() WHERE id = '$user_id'");
mysqli_close($db_connect);