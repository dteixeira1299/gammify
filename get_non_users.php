<?php

include 'config.php';

// Initialize the session
session_start();

$users = [];

$sql = "SELECT id,username, last_login, created_at, updated_at, deleted_at, avatar FROM users WHERE deleted_at IS NOT NULL";
$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
}
mysqli_close($db_connect);

print_r(json_encode($users));
