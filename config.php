<?php
//config.php

// ======================================================================================
/* DATABASE */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gammify');
 
/* Attempt to connect to MySQL database */
$db_connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($db_connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
