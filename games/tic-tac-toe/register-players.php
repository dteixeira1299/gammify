<?php

require_once "functions.php";

registerPlayers($_SESSION['username'], $_POST['player-o']);

if (playersRegistered()) {
    header("location: play.php");
}
