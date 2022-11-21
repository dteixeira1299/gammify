<?php
// update_player_o.php

// Include config file
require_once "../../config.php";

// Initialize the session
session_start();

$user_id = $_SESSION["id"];
$game_key = $_GET["game_key"];

$db_connect->query("UPDATE ticktacktoe SET player_o_id = '$user_id', updated_at = NOW() WHERE game_key = '$game_key'");
mysqli_close($db_connect);
