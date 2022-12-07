<?php

$realm = 'Restricted area';

//user => password
$users = array('admin' => 'admin');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Digest realm="' . $realm .
    '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');

  die('Restricted area');
}


// analyze the PHP_AUTH_DIGEST variable
if (
  !($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
  !isset($users[$data['username']])
)
  die('Wrong Credentials!');


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
$valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);

if ($data['response'] != $valid_response)
  die('Wrong Credentials!');

// ok, valid username & password
// echo 'You are logged in as: ' . $data['username'];


// function to parse the http auth header
function http_digest_parse($txt)
{
  // protect against missing data
  $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
  $data = array();
  $keys = implode('|', array_keys($needed_parts));

  preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

  foreach ($matches as $m) {
    $data[$m[1]] = $m[3] ? $m[3] : $m[4];
    unset($needed_parts[$m[1]]);
  }

  return $needed_parts ? false : $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gammify Admin Center</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/app.css">
  <!-- fontawesome -->
  <link rel="stylesheet" href="../assets/fontawesome/all.min.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gammify Admin Center</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Howdy, <?= $data['username'] ?>!
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="../login.php"><i class="fa-solid fa-right-from-bracket"></i> Leave Admin Center</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container-fluid admin">
    <div class="row">
      <div class="col-sm-12 col-12">
        <h3>Active Players:</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Players:</th>
              <th>Last Login:</th>
              <th>Created at:</th>
              <th>Updated at:</th>
            </tr>
          </thead>
          <tbody id="table-users">
          </tbody>
        </table>

        <h3>Deleted Players:</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Players:</th>
              <th>Last Login:</th>
              <th>Created at:</th>
              <th>Updated at:</th>
            </tr>
          </thead>
          <tbody id="table-non-users">
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <script>
    function getUsers() {
      var e = document.getElementById("table-users");
      e.innerHTML = "";

      var xmlhttp = new XMLHttpRequest();
      var url = "../../get_users.php";

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
              avatar.style.backgroundImage = myArr[i].avatar == "" || myArr[i].avatar == null ? "url(../assets/images/default_avatar.png)" : "url(../../users/" + myArr[i].username + "/avatar/" + myArr[i].avatar + ')'
              avatar.style.backgroundSize = "cover"
              avatar.style.backgroundPosition = "center"

              var name = document.createElement("span");
              name.innerHTML = myArr[i].username;
              name.className = "ms-5"
              avatar.appendChild(name)
              td.appendChild(avatar)
              tr.appendChild(td)

              var td2 = document.createElement("td");
              var last_login = document.createElement("span");
              last_login.innerHTML = myArr[i].last_login;
              td2.appendChild(last_login)
              tr.appendChild(td2)

              var td3 = document.createElement("td");
              var created_at = document.createElement("span");
              created_at.innerHTML = myArr[i].created_at;
              td3.appendChild(created_at)
              tr.appendChild(td3)

              var td4 = document.createElement("td");
              var updated_at = document.createElement("span");
              updated_at.innerHTML = myArr[i].updated_at;
              td4.appendChild(updated_at)
              tr.appendChild(td4)

              e.appendChild(tr);

            }
          } else {
            var tr = document.createElement("tr");
            var td = document.createElement("td");
            td.innerHTML = 'No users!';
            tr.appendChild(td);
            e.appendChild(tr);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();

      setTimeout(getUsers, 10000);
    }


    getUsers();


    function getNonUsers() {
      var e = document.getElementById("table-non-users");
      e.innerHTML = "";

      var xmlhttp = new XMLHttpRequest();
      var url = "../../get_non_users.php";

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
              avatar.style.backgroundImage = myArr[i].avatar == "" || myArr[i].avatar == null ? "url(../assets/images/default_avatar.png)" : "url(../../users/" + myArr[i].username + "/avatar/" + myArr[i].avatar + ')'
              avatar.style.backgroundSize = "cover"
              avatar.style.backgroundPosition = "center"

              var name = document.createElement("span");
              name.innerHTML = myArr[i].username;
              name.className = "ms-5"
              avatar.appendChild(name)
              td.appendChild(avatar)
              tr.appendChild(td)

              var td2 = document.createElement("td");
              var last_login = document.createElement("span");
              last_login.innerHTML = myArr[i].last_login;
              td2.appendChild(last_login)
              tr.appendChild(td2)

              var td3 = document.createElement("td");
              var created_at = document.createElement("span");
              created_at.innerHTML = myArr[i].created_at;
              td3.appendChild(created_at)
              tr.appendChild(td3)

              var td4 = document.createElement("td");
              var updated_at = document.createElement("span");
              updated_at.innerHTML = myArr[i].updated_at;
              td4.appendChild(updated_at)
              tr.appendChild(td4)

              e.appendChild(tr);

            }
          } else {
            var span = document.createElement("span");
            span.style.textAlign="center"
            span.innerHTML = 'No players are deleted!';
            e.appendChild(span);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();

      setTimeout(getNonUsers, 10000);
    }


    getNonUsers();
  </script>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/jquery-3.6.1.min.js"></script>
</body>

</html>