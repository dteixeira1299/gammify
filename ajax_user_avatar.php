<?php

session_start();

$arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
  
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "false";
    return;
}
  
$filename = time().'_'.$_FILES['file']['name'];
  
move_uploaded_file($_FILES['file']['tmp_name'], 'users/'.$_SESSION['username'].'/avatar/'.$filename);
  
echo 'users/'.$_SESSION['username'].'/avatar/'.$filename;
die;