<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

$games = [
  'tic-tac-toe',
];

if (isset($_GET['game']) & in_array(isset($_GET['game']), $games)) {
  $game = $_GET['game'];
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
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gammify</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="?game=tic-tac-toe">Tic Tac Toe</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Game 2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Game 3</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(2).jpg" class="rounded-circle img-fluid" height='25' width='25'> Howdy, <?= $_SESSION['username'] ?>!
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear"></i> Account Settings</a></li>
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


  <div class="container-fluid">
    <div class="row vh-100">
      <div class="col-sm-10 col-12 border border-light border-1 pt-sm-2 pt-1 pb-sm-2 pb-1">
        <embed class="border w-100 h-100 bg-primary" type="text/html" src="<?php if(isset($_GET['game'])){echo "games/".$game;} ?>">
      </div>
      <div class="col-sm-2 col-12 border border-light border-1 pt-sm-2 pt-1 pb-sm-2 pb-1">
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

  <script>
    function getOnlineUsers() {
      var e = document.getElementById("table-online-users");
      e.innerHTML = "";

      var xmlhttp = new XMLHttpRequest();
      var url = "get_online_users.php";

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myArr = JSON.parse(this.responseText);
          var i;
          if (myArr.length != 0) {
            for (i = 0; i < myArr.length; i++) {
              var tr = document.createElement("tr");
              var td = document.createElement("td");
              td.innerHTML = '<i class="fa-solid fa-circle text-success"></i> ' + myArr[i].username;
              tr.appendChild(td);
              e.appendChild(tr);
            }
          } else {
            var tr = document.createElement("tr");
            var td = document.createElement("td");
            td.innerHTML = 'No players available!';
            tr.appendChild(td);
            e.appendChild(tr);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();

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