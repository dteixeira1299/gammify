<?php
session_start();
echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

echo password_hash(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 32),PASSWORD_DEFAULT);