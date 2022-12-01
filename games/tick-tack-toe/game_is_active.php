<?php
// game_is_active.php

$game_key = $_GET["game_key"];
$plX = $_GET["plX"];
$plO = $_GET["plO"];
$crrUser = $_GET["crrUser"];

include '../../config.php';

if($crrUser == $plX){
    $db_connect->query("UPDATE ticktacktoe SET active_x = NOW() WHERE game_key = $game_key");
    mysqli_close($db_connect);
}

if($crrUser == $plO){
    $db_connect->query("UPDATE ticktacktoe SET active_o = NOW() WHERE game_key = $game_key");
    mysqli_close($db_connect);
}

echo "ok";


