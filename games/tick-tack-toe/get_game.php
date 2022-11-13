<?php

// Include config file
require_once "../../config.php";

// Initialize the session
session_start();

$game_key = $_GET["game_key"];

$game = [];

$sql = "SELECT ticktacktoe.*, px.username 'player_x_username', po.username 'player_o_username' FROM ticktacktoe " .
"INNER JOIN users px ".
"ON px.id = ticktacktoe.player_x_id ".
"LEFT JOIN users po ".
"ON po.id = ticktacktoe.player_o_id ".
"WHERE ticktacktoe.game_key='$game_key' ". 
"AND ticktacktoe.deleted_at IS NULL";

$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($game, $row);
    }
}
mysqli_close($db_connect);

print_r(json_encode($game));
