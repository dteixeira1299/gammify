<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "../config.php";

$dir_avatar = "../users/" . $_SESSION['username'] . "/avatar/";
$dir_bg = "../users/" . $_SESSION['username'] . "/bg/";

// Sort in ascending order - this is default
$avatarsUser = scandir($dir_avatar);
$bgUser = scandir($dir_bg);

// Sort in descending order
// $b = scandir($dir,1);

// // Define variables and initialize with empty values
// $new_password = $confirm_password = "";
// $new_password_err = $confirm_password_err = "";

// // Processing form data when form is submitted
// if($_SERVER["REQUEST_METHOD"] == "POST"){

//     // Validate new password
//     if(empty(trim($_POST["new_password"]))){
//         $new_password_err = "Please enter the new password.";     
//     } elseif(strlen(trim($_POST["new_password"])) < 6){
//         $new_password_err = "Password must have atleast 6 characters.";
//     } else{
//         $new_password = trim($_POST["new_password"]);
//     }

//     // Validate confirm password
//     if(empty(trim($_POST["confirm_password"]))){
//         $confirm_password_err = "Please confirm the password.";
//     } else{
//         $confirm_password = trim($_POST["confirm_password"]);
//         if(empty($new_password_err) && ($new_password != $confirm_password)){
//             $confirm_password_err = "Password did not match.";
//         }
//     }

//     // Check input errors before updating the database
//     if(empty($new_password_err) && empty($confirm_password_err)){
//         // Prepare an update statement
//         $sql = "UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?";

//         if($stmt = mysqli_prepare($db_connect, $sql)){
//             // Bind variables to the prepared statement as parameters
//             mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

//             // Set parameters
//             $param_password = password_hash($new_password, PASSWORD_DEFAULT);
//             $param_id = $_SESSION["id"];

//             // Attempt to execute the prepared statement
//             if(mysqli_stmt_execute($stmt)){
//                 // Password updated successfully. Destroy the session, and redirect to login page
//                 session_destroy();
//                 header("location: login.php");
//                 exit();
//             } else{
//                 echo "Oops! Something went wrong. Please try again later.";
//             }

//             // Close statement
//             mysqli_stmt_close($stmt);
//         }
//     }

//     // Close connection
//     mysqli_close($db_connect);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gammify: Account Settings</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/account_settings.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gammify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="welcome.php">Games</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $_SESSION['avatar'] == "" ? 'assets/images/default_avatar.png' : '../users/' . $_SESSION["username"] . '/avatar/' . $_SESSION["avatar"]; ?>" class="rounded-circle" height='25' width='25'> Howdy, <?= $_SESSION['username'] ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item active" href="account_settings.php"><i class="fa-solid fa-gear"></i> Account Settings</a></li>
                            <?php
                            // Check if the user isn't logged in by Google
                            if (!isset($_SESSION["access_token"])) {
                            ?>
                                <li><a class="dropdown-item" href="reset_password.php"><i class="fa-solid fa-key"></i> Change Password</a></li>
                            <?php
                            }
                            ?>
                            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper container">
        <h2>Account Settings</h2>
        <h3>Your avatars</h3>

        <div class="text-center">
            <div class="row">

                <?php
                foreach ($avatarsUser as $key => $value) {
                    if ($key != 0 && $key != 1) {
                ?>
                        <div class="col">
                            <img src="<?= '../users/' . $_SESSION['username'] . '/avatar/' . $value ?>" id="avatarPreview" width="100" height="100" onclick="save_avatar(this.attributes[0].value);">
                        </div>

                    <?php
                    }
                }
                ?>

            </div>
            <div id="drop_file_zone" ondrop="upload_avatar(event)" ondragover="return false">
                <div id="drag_upload_file">
                    <p>Drop file here</p>
                    <p>or</p>
                    <p><input type="button" value="Select File" onclick="file_explorer_avatar();" /></p>
                    <input type="file" id="selectfile" />
                </div>
            </div>
            <div class="img-content"></div>
        </div>
        <hr>
        <h3>Your backgrounds</h3>

        <div class="text-center">
            <div class="row">

                <?php
                foreach ($bgUser as $key => $value) {
                    if ($key != 0 && $key != 1) {
                ?>
                        <div class="col">
                            <img src="<?= '../users/' . $_SESSION['username'] . '/bg/' . $value ?>" id="bgPreview" width="100" height="100" onclick="save_bg(this.attributes[0].value);">
                        </div>

                    <?php
                    }
                }
                ?>

            </div>
            <div id="drop_file_zone" ondrop="upload_bg(event)" ondragover="return false">
                <div id="drag_upload_file">
                    <p>Drop file here</p>
                    <p>or</p>
                    <p><input type="button" value="Select File" onclick="file_explorer_bg();" /></p>
                    <input type="file" id="selectfile" />
                </div>
            </div>
            <div class="img-content-2"></div>
        </div>

    </div>
    <script>
        var fileobj;

        function upload_avatar(e) {
            e.preventDefault();
            fileobj = e.dataTransfer.files[0];
            ajax_file_upload_avatar(fileobj);
        }

        function file_explorer_avatar() {
            document.getElementById('selectfile').click();
            document.getElementById('selectfile').onchange = function() {
                fileobj = document.getElementById('selectfile').files[0];
                ajax_file_upload_avatar(fileobj);
            };
        }

        function ajax_file_upload_avatar(file_obj) {
            if (file_obj != undefined) {
                var form_data = new FormData();
                form_data.append('file', file_obj);
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "ajax_user_avatar.php", true);
                xhttp.onload = function(event) {
                    oOutput = document.querySelector('.img-content');
                    if (xhttp.status == 200) {
                        oOutput.innerHTML = "<img width='250' height='250' src='" + this.responseText + "' alt='The Image' />";
                        location.reload();
                    } else {
                        oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
                    }
                }

                xhttp.send(form_data);
            }
        }

        function save_avatar(imgFile) {
            const myArray = imgFile.split("/");

            var xmlhttp = new XMLHttpRequest();
            var url = "../update_avatar_user.php?avatar=" + myArray[4];

            xmlhttp.open("GET", url);
            xmlhttp.send();
            location.reload();
        }


        function upload_bg(e) {
            e.preventDefault();
            fileobj = e.dataTransfer.files[0];
            ajax_file_upload_bg(fileobj);
        }

        function file_explorer_bg() {
            document.getElementById('selectfile').click();
            document.getElementById('selectfile').onchange = function() {
                fileobj = document.getElementById('selectfile').files[0];
                ajax_file_upload_bg(fileobj);
            };
        }

        function ajax_file_upload_bg(file_obj) {
            if (file_obj != undefined) {
                var form_data = new FormData();
                form_data.append('file', file_obj);
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "ajax_user_bg.php", true);
                xhttp.onload = function(event) {
                    oOutput = document.querySelector('.img-content-2');
                    if (xhttp.status == 200) {
                        oOutput.innerHTML = "<img width='250' height='250' src='" + this.responseText + "' alt='The Image' />";
                        location.reload();
                    } else {
                        oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
                    }
                }

                xhttp.send(form_data);
            }
        }

        function save_bg(imgFile) {
            const myArray = imgFile.split("/");

            var xmlhttp = new XMLHttpRequest();
            var url = "../update_bg_user.php?bg=" + myArray[4];

            xmlhttp.open("GET", url);
            xmlhttp.send();
            location.reload();
        }

    </script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>