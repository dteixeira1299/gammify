<?php
require_once "./templates/header.php";
?>

<form method="post" action="register-players.php">
    <h1>Start playing Tick-Tack-Toe!</h1>
    <h2>Please fill in your names</h2>

    <div class="mb-3">
        <label for="player-x" class="form-label">First player (X)</label>
        <input type="text" class="w-100 p-2 ps-4 form-control" id="player-x" name="player-x" value="<?= $_SESSION['username'] ?>" readonly required />
    </div>

    <div class="mb-3">
        <label for="player-o" class="form-label">Second player (O)</label>
        <select id="player-o" class="w-100 p-2 ps-4 form-control" name="player-o" required>
        </select>
        <div class="alert alert-danger alert-no-users-player-o" id="alert-no-users-player-o" role="alert">
            No players available! Try again later! :(
        </div>
    </div>

    <button class="btn btn-primary w-100" id="start-game" type="submit">START</button>
</form>

<script>
    function getOnlineUsers() {
        var e = document.getElementById("player-o");
        e.innerHTML = "";
        e.style.display = "block";
        document.getElementById("start-game").style.display = "block"

        var xmlhttp = new XMLHttpRequest();
        var url = "../../get_online_users.php";

        var option_default = document.createElement("option");
        option_default.innerHTML = "Open this select menu";
        option_default.value = "";
        option_default.selected;
        e.appendChild(option_default);

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myArr = JSON.parse(this.responseText);
                var i;
                if (myArr.length != 0) {
                    document.getElementById("alert-no-users-player-o").style.display = "none";
                    for (i = 0; i < myArr.length; i++) {
                        var option = document.createElement("option");
                        option.innerHTML = myArr[i].username;
                        option.value = myArr[i].id;
                        e.appendChild(option);
                    }
                } else {
                    e.style.display = "none";
                    document.getElementById("alert-no-users-player-o").style.display = "block";
                    document.getElementById("start-game").style.display = "none";
                }
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();

        setTimeout(getOnlineUsers, 10000);
    }


    getOnlineUsers();
</script>

<?php
require_once "./templates/footer.php";
