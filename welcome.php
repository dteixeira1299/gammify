<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Gammify!</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome/all.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <div style="border: 1px solid white;width:500px;margin-left:auto;margin-right:auto;margin-top:100px;padding:10px;">
            <h2><b>Welcome User</b></h2>
            <h3><b>Name:</b><br><?= $_SESSION['username'] ?></h3>
        </div>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-12 border border-light border-1 p-3">
                [content]
            </div>
            <div class="col-sm-2 col-12 border border-light border-1 p-3">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th>Online Users</th>
                        </tr>
                    </thead>
                    <tbody id="table-online-users">



                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function getOnlineUsers() {
            document.getElementById("table-online-users").innerHTML = "";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("table-online-users").innerHTML = this.responseText;
            }
            xhttp.open("GET", "get_online_users.php");
            xhttp.send();

            setTimeout(getOnlineUsers, 10000);
        }

        getOnlineUsers();

        function updateLoginCurrentUser() {
            const xhttp = new XMLHttpRequest();
            xhttp.open("GET", "update_user_login.php");
            xhttp.send();

            setTimeout(updateLoginCurrentUser, 10000);
        }

        updateLoginCurrentUser();

    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>