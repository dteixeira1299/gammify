<?php

require_once "functions.php";

include "../../config.php";

// Prepare an insert statement
$sql = "INSERT INTO ticktacktoe (player_x_id, player_o_id, room_key) VALUES (?, ?, ?)";

if ($stmt = mysqli_prepare($db_connect, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sss", $param_player_x_id, $param_player_o_id,$param_room_key);

    // Set parameters
    $param_player_x_id = $_SESSION['id'];
    $param_player_o_id = trim($_POST['player-o']);
    $param_room_key = password_hash(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 32), PASSWORD_DEFAULT); // Creates a hash

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {

        registerRoom($_SESSION['id'], trim($_POST['player-o']),$param_room_key);

        if (roomRegistered()) {
            header("location: play.php");
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
