<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

$games = [
  'tick-tack-toe',
];

if (isset($_GET['game'])) {
  if (in_array($_GET['game'], $games)) {
    $game = $_GET['game'];
  }
}

include '../config.php';
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
            <a class="nav-link <?php if ($game == "tick-tack-toe") {
                                  echo "active";
                                } ?>" href="?game=tick-tack-toe">Tick-Tack-Toe</a>
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
              <img src="<?= $_SESSION['avatar'] == "" ? 'assets/images/default_avatar.png' : '../users/' . $_SESSION["username"] . '/avatar/' . $_SESSION["avatar"]; ?>" class="rounded-circle" height='25' width='25'> Howdy, <?= $_SESSION['username'] ?>!
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="account_settings.php"><i class="fa-solid fa-gear"></i> Account Settings</a></li>
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


  <div class="container ">
    <div class="row full-height">
      <div class="col-sm-9 col-12 border border-light border-1 pt-sm-2 pt-1 pb-sm-2 pb-1">
        <embed class="w-100 h-100" type="text/html" src="<?php if (isset($_GET['game'])) {
                                                            echo "../games/" . $game;
                                                          } ?>">
      </div>
      <div class="col-sm-3 col-12 border border-light border-1 pt-sm-2 pt-1 pb-sm-2 pb-1">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Other players:</th>
            </tr>
          </thead>
          <tbody id="table-online-users">
          </tbody>
        </table>
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Tick-Tack-Toe rooms:</th>
            </tr>
          </thead>
          <tbody id="table-ticktacktoe-rooms">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.body.style.backgroundImage = "url('../users/<?= $_SESSION["username"] ?>/bg/<?= $_SESSION["bg"] ?>')"
    document.body.style.backgroundRepeat="no-repeat"
    document.body.style.backgroundSize="cover"

    getTickTackToeRooms()

    function getTickTackToeRooms() {
      var e = document.getElementById("table-ticktacktoe-rooms");
      e.innerHTML = "";

      var xmlhttp = new XMLHttpRequest();
      var url = "../get_tick_tack_toe_rooms.php";

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myArr = JSON.parse(this.responseText);
          var i;
          if (myArr.length != 0) {
            for (i = 0; i < myArr.length; i++) {
              var tr = document.createElement("tr");
              var td = document.createElement("td");
              var name = document.createElement("span");
              name.innerHTML = '<i class="fa-solid fa-circle text-success"></i> ' + myArr[i].game_key;
              td.appendChild(name)
              tr.appendChild(td)
              e.appendChild(tr);

            }
          } else {
            var tr = document.createElement("tr");
            var td = document.createElement("td");
            td.innerHTML = 'No rooms available!';
            tr.appendChild(td);
            e.appendChild(tr);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();

      setTimeout(getTickTackToeRooms, 10000);
    }

    function getOnlineUsers() {
      var e = document.getElementById("table-online-users");
      e.innerHTML = "";

      var xmlhttp = new XMLHttpRequest();
      var url = "../get_online_users.php";

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myArr = JSON.parse(this.responseText);
          var i;
          if (myArr.length != 0) {
            for (i = 0; i < myArr.length; i++) {
              var tr = document.createElement("tr");
              var td = document.createElement("td");
              var avatar = document.createElement("div");
              avatar.style.width = "40px"
              avatar.style.height = "40px"
              avatar.style.border = "3px rgb(48, 69, 96) solid"
              avatar.style.borderRadius = "20px"
              avatar.style.position = "relative"
              avatar.style.backgroundImage = myArr[i].avatar == "" || myArr[i].avatar == null ? "url(assets/images/default_avatar.png)" : "url(../users/" + myArr[i].username + "/avatar/" + myArr[i].avatar + ')'
              avatar.style.backgroundSize = "cover"
              avatar.style.backgroundPosition = "center"
              var status = document.createElement("span");
              status.style.width = "15px"
              status.style.height = "15px"
              status.style.border = "2px solid rgb(48, 69, 96)"
              status.style.borderRadius = "50%"
              status.style.position = "absolute"
              status.style.left = "-10px"
              status.style.bottom = "-10px"
              status.style.transform = "translate(40%, -40%)"
              status.style.backgroundColor = "rgb(48, 249, 75)"
              avatar.appendChild(status)
              var name = document.createElement("span");
              name.innerHTML = myArr[i].username;
              name.className = "ms-5"
              avatar.appendChild(name)
              td.appendChild(avatar)
              tr.appendChild(td)
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
      xhttp.open("GET", "../update_user_login.php");
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