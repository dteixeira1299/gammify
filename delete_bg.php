<?php

session_start();

$file = $_GET["file"];

rmdir('users/'.$_SESSION['username'].'/bg/'.$file);