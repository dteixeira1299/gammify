<?php

// Include config file
require_once "../../config.php";

// Initialize the session
session_start();

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomString = '';

for ($i = 0; $i < 5; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
}

// Prepare an insert statement
$sql = "INSERT INTO ticktacktoe (player_x_id, game_key) VALUES (?,?)";

if ($stmt = mysqli_prepare($db_connect, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $param_player_x_id, $param_room_key);

    // Set parameters
    $param_player_x_id = $_SESSION['id'];
    $param_room_key = $randomString;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo $randomString;
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
