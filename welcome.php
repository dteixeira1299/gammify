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
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">
      <img src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png" height="30" alt="" loading="lazy" />
    </a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">TV Shows</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Movies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Recently Added</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">My List</a>
        </li>
      </ul>
      <!-- Left links -->

      <!-- Search form -->
      <form class="d-flex input-group w-auto">
        <input type="search" class="form-control" placeholder="Type query" aria-label="Search" />
        <button class="btn btn-outline-primary" type="button" data-mdb-ripple-color="dark" style="padding: .45rem 1.5rem .35rem;">
          Search
        </button>
      </form>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">CHILDREN</a>
        </li>
        <!-- Navbar dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navbarDropdown" role="button"
            data-mdb-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu dropdown-menu-end notifications-list p-1" aria-labelledby="navbarDropdown">
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(15).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(10).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(11).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(20).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(5).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <div class="row">
                <div class="col-md">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(15).jpg" height='63' width='auto'
                    class="d-block" alt="..." />
                </div>
                <div class="col-md">
                  <p class="h6 mb-0">New</p>
                  <p class="h6 mb-1">Movie title</p>
                  <span class="small">Today</span>
                </div>
              </div>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown"
            aria-expanded="false">
            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(2).jpg" class="rounded-circle img-fluid"
              height='25' width='25'>
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="navbarDropdown">
            <li class="my-2 d-flex align-items-center"><img
                src="https://mdbootstrap.com/img/Photos/Avatars/img%20(4).jpg" class="rounded-circle img-fluid me-1"
                height='25' width='25'><span> User 1</span></li>
            <li class="my-2 d-flex align-items-center"><img
                src="https://mdbootstrap.com/img/Photos/Avatars/img%20(6).jpg" class="rounded-circle img-fluid me-1"
                height='25' width='25'><span> User 2</span></li>
            <li class="my-2 d-flex align-items-center"><img
                src="https://mdbootstrap.com/img/Photos/Avatars/img%20(3).jpg" class="rounded-circle img-fluid me-1"
                height='25' width='25'><span> User 3</span></li>
            <li><a class="dropdown-item" href="#">Manage Profilses</a></li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item" href="#">Your Account</a></li>
            <li><a class="dropdown-item" href="#">Help</a></li>
            <li><a class="dropdown-item" href="#">Log Out</a></li>
          </ul>
        </li>
      </ul>

    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->


    <div class="text-center">
        <div style="border: 1px solid white;width:500px;margin-left:auto;margin-right:auto;margin-top:100px;padding:10px;">
            <h2><b>Welcome User</b></h2>
            <h3><b>Name:</b><br><?= $_SESSION['username'] ?></h3>
        </div>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-12 border border-light border-1 p-3 text-center">
                <h4>Choose a game and have fun! :)</h4>
                <button class="btn btn-primary">Tick-tack-toe</button>
                <div id="canvas"></div>
            </div>
            <div class="col-sm-2 col-12 border border-light border-1 p-3">
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
    <script src="assets/js/jquery-3.6.1.min.js"></script>
</body>

</html>