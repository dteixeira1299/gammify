<?php

include 'config.php';

// Initialize the session
session_start();

$rooms = [];

$sql = "SELECT game_key FROM ticktacktoe WHERE deleted_at IS NULL AND ticktacktoe.player_o_id IS NULL";
$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($rooms, $row);
    }
}
mysqli_close($db_connect);

print_r(json_encode($rooms));
