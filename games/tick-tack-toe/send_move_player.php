<?php
// send_move_player.php

// Include config file
require_once "../../config.php";

$move_element_id = $_GET['move_element_id'];
$move_currentPlayer = $_GET['move_currentPlayer'];
$game_key = $_GET['game_key'];

$db_connect->query("UPDATE ticktacktoe SET move_element_id = '$move_element_id', move_currentPlayer='$move_currentPlayer',updated_at=NOW() WHERE game_key = '$game_key'");
mysqli_close($db_connect);
