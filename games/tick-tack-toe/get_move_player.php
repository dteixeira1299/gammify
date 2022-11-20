<?php

// Include config file
require_once "../../config.php";

// Initialize the session
session_start();

$game_key = $_GET["game_key"];

$game = [];

$sql = "SELECT move_currentPlayer, move_element_id FROM ticktacktoe " .
"WHERE game_key='$game_key' ". 
"AND ticktacktoe.deleted_at IS NULL";

$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($game, $row);
    }
}
mysqli_close($db_connect);

print_r(json_encode($game));
