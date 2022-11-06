<?php

session_start();
error_reporting(E_ERROR | E_PARSE);


function registerRoom($room_key = "")
{
    $_SESSION["ROOM_KEY"] = $room_key;
    setTurn('x');
    resetBoard();
    resetWins();
}

function resetBoard()
{
    resetPlaysCount();

    for ($i = 1; $i <= 9; $i++) {
        unset($_SESSION['CELL_' . $i]);
    }
}

function resetWins()
{
    $room_key = $_SESSION['ROOM_KEY'];
    include "../../config.php";
    $db_connect->query("UPDATE ticktacktoe SET player_x_wins = 0, player_o_wins = 0 WHERE room_key = $room_key");
    mysqli_close($db_connect);
}

function playsCount()
{
    $room_key = $_SESSION['ROOM_KEY'];
    include "../../config.php";
    $sql="SELECT plays FROM ticktacktoe WHERE room_key = $room_key";
    if ($stmt = mysqli_prepare($db_connect, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_plays);

        // Set parameters
        $param_plays = $plays;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $plays);
                if (mysqli_stmt_fetch($stmt)) {
                    return $plays ? $plays : 0;
                }
            } 
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

}

function addPlaysCount()
{
    $room_key = $_SESSION['ROOM_KEY'];

    include "../../config.php";

// Prepare an insert statement
$sql = "INSERT INTO ticktacktoe (plays) VALUES (?)";

if ($stmt = mysqli_prepare($db_connect, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_plays);

    // Set parameters
    $param_plays = playsCount()++;

    // Close statement
    mysqli_stmt_close($stmt);
}






    if (!$_SESSION['PLAYS']) {
        $_SESSION['PLAYS'] = 0;
    }

    $_SESSION['PLAYS']++;
}

function resetPlaysCount()
{
    $room_key = $_SESSION['ROOM_KEY'];
    include "../../config.php";
    $db_connect->query("UPDATE ticktacktoe SET plays = 0 WHERE room_key = $room_key");
    mysqli_close($db_connect);
}

function playerName($player = 'x')
{
    return $_SESSION['PLAYER_' . strtoupper($player) . '_NAME'];
}

function roomRegistered()
{
    return $_SESSION['ROOM_KEY'];
}

function setTurn($turn = 'x')
{
    $room_key = $_SESSION['ROOM_KEY'];
    include "../../config.php";
    $db_connect->query("UPDATE ticktacktoe SET turn = $turn WHERE room_key = $room_key");
    mysqli_close($db_connect);
}

function getTurn()
{
    return $_SESSION['TURN'] ? $_SESSION['TURN'] : 'x';
}

function markWin($player = 'x')
{
    $_SESSION['PLAYER_' . strtoupper($player) . '_WINS']++;
}

function switchTurn()
{
    switch (getTurn()) {
        case 'x':
            setTurn('o');
            break;
        default:
            setTurn('x');
            break;
    }
}

function currentPlayer()
{
    return playerName(getTurn());
}

function play($cell = '')
{
    if (getCell($cell)) {
        return false;
    }

    $_SESSION['CELL_' . $cell] = getTurn();
    addPlaysCount();
    $win = playerPlayWin($cell);

    if (!$win) {
        switchTurn();
    } else {
        markWin(getTurn());
        resetBoard();
    }

    return $win;
}

function getCell($cell = '')
{
    return $_SESSION['CELL_' . $cell];
}

function playerPlayWin($cell = 1)
{
    if (playsCount() < 3) {
        return false;
    }

    $column = $cell % 3;
    if (!$column) {
        $column = 3;
    }

    $row = ceil($cell / 3);

    $player = getTurn();

    return isVerticalWin($column, $player) || isHorizontalWin($row, $player) || isDiagonalWin($player);
}

function isVerticalWin($column = 1, $turn = 'x')
{
    return getCell($column) == $turn &&
        getCell($column + 3) == $turn &&
        getCell($column + 6) == $turn;
}

function isHorizontalWin($row = 1, $turn = 'x')
{
    return getCell($row) == $turn &&
        getCell($row + 1) == $turn &&
        getCell($row + 2) == $turn;
}

function isDiagonalWin($turn = 'x')
{
    $win = getCell(1) == $turn &&
        getCell(9) == $turn;

    if (!$win) {
        $win = getCell(3) == $turn &&
            getCell(7) == $turn;
    }

    return $win && getCell(5) == $turn;
}

function score($player = 'x')
{
    $score = $_SESSION['PLAYER_' . strtoupper($player) . '_WINS'];
    return $score ? $score : 0;
}
