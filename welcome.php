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
  <link rel="stylesheet" href="assets/css/app.css">
  <!-- fontawesome -->
  <link rel="stylesheet" href="assets/fontawesome/all.min.css">
  <style>
    body {
      font: 14px sans-serif;
      overflow-x: hidden;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #e3f2fd;">
    <div class="container-fluid">
      <a class="navbar-brand" href="">Gammify</a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link dropdown-toggle" role="button" onmouseover="dropdownToggleUserOptions();">
            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(2).jpg" class="rounded-circle img-fluid" height='25' width='25'> Howdy, <?= $_SESSION['username'] ?>!
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="list-group user-options" id="userOptions">
    <a href="" class="list-group-item list-group-item-action"><i class="fa-solid fa-gear"></i> Account Settings</a>
    <?php
    // Check if the user isn't logged in by Google
    if (!isset($_SESSION["access_token"])) {
    ?>
      <a href="reset_password.php" class="list-group-item list-group-item-action"><i class="fa-solid fa-key"></i> Change Password</a>
    <?php
    }
    ?>
    <a href="logout.php" class="list-group-item list-group-item-action"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>


  <div class="container-fluid">
    <div class="row vh-100">
      <div class="col-sm-10 col-12 border border-light border-1 text-start">
        <div class="mt-sm-5 mt-5">
          <h5>Choose a game and have fun! :)</h5>
          <a class="btn btn-primary" onclick="window.open('games/tic-tac-toe/','newwindow','width=500,height=500');">Tick-tack-toe</a>
          <div id="canvas"></div>
        </div>
      </div>
      <div class="col-sm-2 col-12 border border-light border-1">
        <div class="mt-sm-5 mt-3">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>Other players:</th>
              </tr>
            </thead>
            <tbody id="table-online-users">


            </tbody>
          </table>
        </div>
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

    function dropdownToggleUserOptions() {
      var x = document.getElementById("userOptions");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.6.1.min.js"></script>
</body>

</html>