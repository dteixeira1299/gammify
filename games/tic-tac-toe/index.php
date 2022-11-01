<?php
require_once "./templates/header.php";
?>

<form method="post" action="register-players.php">
    <div class="welcome">
        <h1>Start playing Tic Tac Toe!</h1>
        <h2>Please fill in your names</h2>

        <div class="player-name">
            <label for="player-x">First player (X)</label>
            <input type="text" id="player-x" name="player-x" value="<?= $_SESSION['username'] ?>" readonly required />
        </div>

        <div class="player-name">
            <label for="player-o">Second player (O)</label>
            <input type="text" id="player-o" name="player-o" required />
            <!-- <select id="player-o" name="player-o" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select> -->
        </div>

        <button type="submit">Start</button>
    </div>
</form>

<?php
require_once "./templates/footer.php";
