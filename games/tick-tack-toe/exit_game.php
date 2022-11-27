<?php
// send_move_player.php

// Include config file
require_once "../../config.php";

$game_key = $_GET['game_key'];

$db_connect->query("UPDATE ticktacktoe SET deleted_at = NOW() WHERE game_key = '$game_key'");
mysqli_close($db_connect);
