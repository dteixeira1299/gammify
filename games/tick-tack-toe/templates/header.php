<?php

require_once "functions.php";

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: ../../login.php");
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>TicTacToe game</title>

    <link rel='stylesheet' href='style.css' type='text/css'/>
    <link rel="stylesheet" href="../../public/assets/css/bootstrap.min.css">
</head>
<body>

    <div class="wrapper">
