<?php

include 'config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];

$users = [];

$sql = "SELECT username FROM users WHERE NOW() - last_login <= 10 AND id != $user_id";
$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
}
mysqli_close($db_connect);

print_r(json_encode($users));
