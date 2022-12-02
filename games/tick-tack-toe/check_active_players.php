<?php

include '../../config.php';

// Initialize the session
session_start();

$game_key = $_GET["game_key"];

$sql = "SELECT game_key FROM ticktacktoe WHERE NOW() - active_x <= 10 AND NOW() - active_o <= 10 AND game_key = '$game_key'";
$result = $db_connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "active";
    }
}
mysqli_close($db_connect);
