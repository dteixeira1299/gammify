sessionStorage.clear();

document.querySelector(".turn-indicator").style.display = "none"

var currentPlayer = "";

var checkedBoxes = [];

var turnCount = 0;

var gameMode = '';

var alert_no_player_o = false;

function getUserIdSessionPHP() {

    var xmlhttp = new XMLHttpRequest();
    var url = "get_user_id_session_php.php";

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            sessionStorage.setItem("LOGGED_USER_ID", this.responseText)
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();

}
getUserIdSessionPHP()


function createNewGameDB() {

    var xmlhttp = new XMLHttpRequest();
    var url = "create_new_game.php";

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            sessionStorage.setItem("GAME_KEY", this.responseText)
            getGameDB(this.responseText)
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    gameMode = "PvP";

    document.getElementById("new-game-key").textContent = "Exit Game"
    document.getElementById("new-game-key").setAttribute('onclick', 'exitGame(sessionStorage.getItem("GAME_KEY"))')

}

function exitGame(x) {
    var xmlhttp = new XMLHttpRequest();
    var url = "exit_game.php?game_key=" + x;

    xmlhttp.open("GET", url);
    xmlhttp.send();

    location.reload();

    // document.getElementById("current-key-game").textContent = ""

    // sessionStorage.removeItem("GAME_KEY")
    // sessionStorage.removeItem("PLAYER_X_ID")
    // sessionStorage.removeItem("PLAYER_O_ID")
    // sessionStorage.removeItem("PLAYER_O_ID")
    // sessionStorage.removeItem("PLAYER_X_USERNAME")
    // sessionStorage.removeItem("PLAYER_O_USERNAME")
    // currentPlayer=""
    // clearBoard();
    // alert_no_player_o = false

    // document.getElementById("new-game-key").textContent="New Game"
    // document.getElementById("new-game-key").setAttribute('onclick','createNewGameDB()')
}



function getGameDB(x) {

    var xmlhttp = new XMLHttpRequest();
    var url = "get_game.php?game_key=" + x;

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            if (myArr.length == 1) {
                document.getElementById("input-game-key").value = ""
                document.getElementById("search-game").style.display = "none"
                document.getElementById("current-key-game").textContent = "Game Key: " + myArr[0].game_key

                sessionStorage.setItem("GAME_KEY", myArr[0].game_key)
                sessionStorage.setItem("PLAYER_X_ID", myArr[0].player_x_id)
                sessionStorage.setItem("PLAYER_O_ID", myArr[0].player_o_id)
                sessionStorage.setItem("PLAYER_X_USERNAME", myArr[0].player_x_username)
                sessionStorage.setItem("PLAYER_O_USERNAME", myArr[0].player_o_username)

                if (sessionStorage.getItem("PLAYER_O_ID") == "null" && (sessionStorage.getItem("PLAYER_X_ID") != sessionStorage.getItem("LOGGED_USER_ID"))) {
                    update_player_o(sessionStorage.getItem("GAME_KEY"))
                }

                start()
            }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();

}

function update_player_o(x) {
    var xmlhttp = new XMLHttpRequest();
    var url = "update_player_o.php?game_key=" + x;

    xmlhttp.open("GET", url);
    xmlhttp.send();
}

function start() {
    if (sessionStorage.getItem("PLAYER_O_ID") == "null") {
        if (alert_no_player_o === false && (sessionStorage.getItem("PLAYER_X_ID") == sessionStorage.getItem("LOGGED_USER_ID"))) {
            alert("Please wait for second player....")
            alert_no_player_o = true
        }
        getGameDB(sessionStorage.getItem("GAME_KEY"))
    } else {
        if (sessionStorage.getItem("GAME_KEY")) {

            document.querySelector(".turn-indicator").style.display = "inline"

            document.getElementById("score-X-username").textContent = sessionStorage.getItem("PLAYER_X_USERNAME")
            document.getElementById("score-O-username").textContent = sessionStorage.getItem("PLAYER_O_USERNAME")

            currentPlayer = ["X", "O"].sort()[0]

            if (currentPlayer == "X") {
                document.querySelector('.current-player').textContent = sessionStorage.getItem("PLAYER_X_USERNAME")
            } else if (currentPlayer == "O") {
                document.querySelector('.current-player').textContent = sessionStorage.getItem("PLAYER_O_USERNAME")
            }
            showLoader();
            clearBoard();
            document.querySelector('.winner-screen').classList.remove('fade-in');
            document.querySelector('.winner-screen').classList.add('fade-out');
            setTimeout(hideLoader, 500);
            get_move_player()
            check_block_player()
            player_disconnect()

        }
    }


}

function player_disconnect() {

    var xmlhttp = new XMLHttpRequest();
    var url = "../../get_all_online_users.php";

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            var i;
            if (myArr.length != 0) {
                for (i = 0; i < myArr.length; i++) {
                    if (myArr[i].id.includes(sessionStorage.getItem("PLAYER_X_ID")) || myArr[i].id.includes(sessionStorage.getItem("PLAYER_O_ID"))) {
                        console.log("All users are connected!")
                    } else {
                        alert('xau')
                    }
                }
            }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    if (sessionStorage.getItem("GAME_KEY")) {
        setTimeout(player_disconnect, 0);
    }
}

function check_block_player() {

    if ((sessionStorage.getItem("LOGGED_USER_ID") == sessionStorage.getItem("PLAYER_X_ID")) && currentPlayer == "O") {
        document.getElementById('0-0').disabled = "disabled"
        document.getElementById('0-1').disabled = "disabled"
        document.getElementById('0-2').disabled = "disabled"
        document.getElementById('1-0').disabled = "disabled"
        document.getElementById('1-1').disabled = "disabled"
        document.getElementById('1-2').disabled = "disabled"
        document.getElementById('2-0').disabled = "disabled"
        document.getElementById('2-1').disabled = "disabled"
        document.getElementById('2-2').disabled = "disabled"
    } else if ((sessionStorage.getItem("LOGGED_USER_ID") == sessionStorage.getItem("PLAYER_O_ID")) && currentPlayer == "X") {
        document.getElementById('0-0').disabled = "disabled"
        document.getElementById('0-1').disabled = "disabled"
        document.getElementById('0-2').disabled = "disabled"
        document.getElementById('1-0').disabled = "disabled"
        document.getElementById('1-1').disabled = "disabled"
        document.getElementById('1-2').disabled = "disabled"
        document.getElementById('2-0').disabled = "disabled"
        document.getElementById('2-1').disabled = "disabled"
        document.getElementById('2-2').disabled = "disabled"
    } else if ((sessionStorage.getItem("LOGGED_USER_ID") == sessionStorage.getItem("PLAYER_X_ID")) && currentPlayer == "X") {
        if (document.getElementById('0-0').value == "") { document.getElementById('0-0').disabled = "" }
        if (document.getElementById('0-1').value == "") { document.getElementById('0-1').disabled = "" }
        if (document.getElementById('0-2').value == "") { document.getElementById('0-2').disabled = "" }
        if (document.getElementById('1-0').value == "") { document.getElementById('1-0').disabled = "" }
        if (document.getElementById('1-1').value == "") { document.getElementById('1-1').disabled = "" }
        if (document.getElementById('1-2').value == "") { document.getElementById('1-2').disabled = "" }
        if (document.getElementById('2-0').value == "") { document.getElementById('2-0').disabled = "" }
        if (document.getElementById('2-1').value == "") { document.getElementById('2-1').disabled = "" }
        if (document.getElementById('2-2').value == "") { document.getElementById('2-2').disabled = "" }
    } else if ((sessionStorage.getItem("LOGGED_USER_ID") == sessionStorage.getItem("PLAYER_O_ID")) && currentPlayer == "O") {
        if (document.getElementById('0-0').value == "") { document.getElementById('0-0').disabled = "" }
        if (document.getElementById('0-1').value == "") { document.getElementById('0-1').disabled = "" }
        if (document.getElementById('0-2').value == "") { document.getElementById('0-2').disabled = "" }
        if (document.getElementById('1-0').value == "") { document.getElementById('1-0').disabled = "" }
        if (document.getElementById('1-1').value == "") { document.getElementById('1-1').disabled = "" }
        if (document.getElementById('1-2').value == "") { document.getElementById('1-2').disabled = "" }
        if (document.getElementById('2-0').value == "") { document.getElementById('2-0').disabled = "" }
        if (document.getElementById('2-1').value == "") { document.getElementById('2-1').disabled = "" }
        if (document.getElementById('2-2').value == "") { document.getElementById('2-2').disabled = "" }
    }

    if (sessionStorage.getItem("GAME_KEY")) {
        setTimeout(check_block_player, 0);
    }

}



document.querySelectorAll('.box').forEach((value, key) => {
    value.addEventListener("click", () => {
        onCheckBox(value);
    });
});

function checkInputGameKey() {
    getGameDB(document.getElementById("input-game-key").value)
}

function onGameModeChange(mode, _el) {
    if (_el.classList.contains('mode-selected'))
        return;
    _el.classList.add('mode-selected');

    if (mode == 'PvP') {
        document.querySelector(".turn-indicator").style.display = "none"
        document.querySelector(`.mode.PvC`).classList.remove('mode-selected');
        document.getElementById("search-game").style.display = "inline"
        getUserIdSessionPHP()
        currentPlayer = ""

    }
    else if (mode == 'PvC') {
        document.querySelector(".turn-indicator").style.display = "inline"
        document.querySelector(`.mode.PvP`).classList.remove('mode-selected');
        document.getElementById("input-game-key").value = ""
        document.getElementById("search-game").style.display = "none"
        sessionStorage.clear();
        document.getElementById("current-key-game").textContent = ""
        currentPlayer = "X";
        document.querySelector('.current-player').textContent = "X";
        document.getElementById("score-X-username").textContent = "X"
        document.getElementById("score-O-username").textContent = "O"
    }
    gameMode = mode;
    clearBoard();
    document.querySelector('#score-X').textContent = 0;
    document.querySelector('#score-O').textContent = 0;
}

function send_move_player(move_element_id, move_currentPlayer, game_key) {
    var xmlhttp = new XMLHttpRequest();
    var url = "send_move_player.php?move_element_id=" + move_element_id + "&move_currentPlayer=" + move_currentPlayer + "&game_key=" + game_key;

    xmlhttp.open("GET", url);
    xmlhttp.send();
}

function get_move_player() {
    var xmlhttp = new XMLHttpRequest();
    var url = "get_move_player.php?game_key=" + sessionStorage.getItem("GAME_KEY");


    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            if (myArr.length == 1) {
                if (myArr[0].move_currentPlayer == "X" || myArr[0].move_currentPlayer == "O") {
                    sessionStorage.setItem("MOVE_CURRENT_PLAYER", myArr[0].move_currentPlayer)
                    sessionStorage.setItem("MOVE_ELEMENT_ID", myArr[0].move_element_id)
                } else {
                    sessionStorage.removeItem("MOVE_CURRENT_PLAYER")
                    sessionStorage.removeItem("MOVE_ELEMENT_ID")
                }
            }
        }
    };

    xmlhttp.open("GET", url);
    xmlhttp.send();

    if (sessionStorage.getItem("MOVE_CURRENT_PLAYER") && sessionStorage.getItem("MOVE_ELEMENT_ID")) {
        if (document.getElementById(sessionStorage.getItem("MOVE_ELEMENT_ID")).value == "") {
            currentPlayer = sessionStorage.getItem("MOVE_CURRENT_PLAYER")
            // onCheckBox(document.querySelector(`[id='${sessionStorage.getItem("MOVE_ELEMENT_ID")}']`))
            var element = document.querySelector(`[id='${sessionStorage.getItem("MOVE_ELEMENT_ID")}']`)
            checkedBoxes.push({ box: element.id, player: currentPlayer });
            element.value = currentPlayer;
            element.disabled = "disabled";
            turnCount++;
            checkWinner();
            switchPlayer();
        }
    }

    if (sessionStorage.getItem("GAME_KEY")) {
        setTimeout(get_move_player, 0);
    }
}

function onCheckBox(element) {

    checkedBoxes.push({ box: element.id, player: currentPlayer });
    checkElement(element);
    turnCount++;
    var gameStatus = checkWinner();
    switchPlayer();

    if (turnCount % 2 == 1 && gameStatus != 'game over' && gameStatus != 'game drawn' && gameMode == "PvC") {
        computerPlays();
    }
}

function checkElement(element) {
    element.value = currentPlayer;
    element.disabled = "disabled";
    if (sessionStorage.getItem("GAME_KEY") && gameMode == "PvP") {
        send_move_player(element.id, currentPlayer, sessionStorage.getItem("GAME_KEY"))
    }
}

function onUncheckBox(element, isImplicit = false) {
    checkedBoxes = checkedBoxes.filter(b => b.box != element.id);
    if (!isImplicit) {
        element.value = '';
        element.removeAttribute("disabled");
        turnCount--;
        switchPlayer();
    }
}

function switchPlayer() {
    if (gameMode == "PvP") {
        if (currentPlayer == "X") {
            currentPlayer = "O"
            document.querySelector('.current-player').textContent = sessionStorage.getItem("PLAYER_O_USERNAME")
        } else if (currentPlayer == "O") {
            currentPlayer = "X"
            document.querySelector('.current-player').textContent = sessionStorage.getItem("PLAYER_X_USERNAME")
        }

    } else if (gameMode == "PvC") {
        currentPlayer = currentPlayer == "X" ? "O" : "X";
        document.querySelector('.current-player').textContent = currentPlayer;
    }

}


function checkWinner(isCheckOnly = false) {
    if (currentPlayer == "X") {
        var xs = checkedBoxes.filter(item => {
            return item.player == "X";
        }).map(value => {
            return { x: Number(value.box.split("-")[0]), y: Number(value.box.split("-")[1]) }
        });

        return calculateScore(xs, isCheckOnly);
    }
    else if (currentPlayer == "O") {
        var os = checkedBoxes.filter(item => {
            return item.player == "O";
        }).map(value => {
            return { x: Number(value.box.split("-")[0]), y: Number(value.box.split("-")[1]) }
        });

        return calculateScore(os, isCheckOnly);
    }


}


function calculateScore(positions, isCheckOnly) {

    if (positions.filter(i => { return i.x == i.y }).length == 3) {
        if (!isCheckOnly)
            showWinner();
        return 'game over';
    }

    if (positions.filter(i => { return (i.x == 0 && i.y == 2) || (i.x == 1 && i.y == 1) || (i.x == 2 && i.y == 0) }).length == 3) {
        if (!isCheckOnly)
            showWinner();
        return 'game over';
    }

    for (var i = 0; i < 3; i++) {
        var consecutiveHorizontal = positions.filter(p => {
            return p.x == i;
        });
        if (consecutiveHorizontal.length == 3) {
            if (!isCheckOnly)
                showWinner();
            return 'game over';
        }
        var consecutiveVertical = positions.filter(p => {
            return p.y == i;
        });
        if (consecutiveVertical.length == 3) {
            if (!isCheckOnly)
                showWinner();
            return 'game over';
        }
    }
    if (positions.length == 5) {
        if (!isCheckOnly)
            showWinner(true);
        return 'game drawn';
    }
    return 'game on';
}

function clearBoard() {
    document.querySelectorAll('.box').forEach((value, index) => {
        value.value = '';
        value.removeAttribute("disabled");
        checkedBoxes = [];
        turnCount = 0;
    })
}

function showWinner(noWinner = false) {
    if (sessionStorage.getItem("GAME_KEY") && gameMode == "PvP") {
        send_move_player("NULL", "NULL", sessionStorage.getItem("GAME_KEY"))
        sessionStorage.removeItem("MOVE_CURRENT_PLAYER")
        sessionStorage.removeItem("MOVE_ELEMENT_ID")
    }

    if (noWinner) {
        document.querySelector('.winner-screen .body').innerHTML = 'Its a Draw!';
        document.querySelector('.winner-screen').classList.toggle('fade-in');
        document.querySelector('.winner-screen').classList.toggle('fade-out');
        //updateModel('draw');
        return;
    }
    else {
        if (gameMode == "PvP") {
            if (currentPlayer == "X") {
                document.querySelector('.winner-screen .body').innerHTML = 'Player ' + sessionStorage.getItem("PLAYER_X_USERNAME") + ' Won!';
                document.querySelector('.winner-screen').classList.toggle('fade-in');
                document.querySelector('.winner-screen').classList.toggle('fade-out');
                document.querySelector('#score-' + currentPlayer).textContent = Number(document.querySelector('#score-' + currentPlayer).textContent) + 1;
                return;
            } else if (currentPlayer == "O") {
                document.querySelector('.winner-screen .body').innerHTML = 'Player ' + sessionStorage.getItem("PLAYER_O_USERNAME") + ' Won!';
                document.querySelector('.winner-screen').classList.toggle('fade-in');
                document.querySelector('.winner-screen').classList.toggle('fade-out');
                document.querySelector('#score-' + currentPlayer).textContent = Number(document.querySelector('#score-' + currentPlayer).textContent) + 1;
                return;
            }

        } else if (gameMode == "PvC") {
            document.querySelector('.winner-screen .body').innerHTML = 'Player ' + currentPlayer + ' Won!';
            document.querySelector('.winner-screen').classList.toggle('fade-in');
            document.querySelector('.winner-screen').classList.toggle('fade-out');
            document.querySelector('#score-' + currentPlayer).textContent = Number(document.querySelector('#score-' + currentPlayer).textContent) + 1;
            return;
        }
    }
}


document.querySelectorAll('.okay-button').forEach((value, key) => {
    value.addEventListener('click', () => {
        newGame()
    });
})

function newGame() {
    showLoader();
    clearBoard();
    document.querySelector('.winner-screen').classList.remove('fade-in');
    document.querySelector('.winner-screen').classList.add('fade-out');
    switchPlayer()
    setTimeout(hideLoader, 500);
}

function computerPlays() {
    var nextBoxCoords;

    if (turnCount == 1) {
        nextBoxCoords = computeFirstMove();
    }
    if (!nextBoxCoords) {
        nextBoxCoords = computeFinishingMove();
    }

    if (!nextBoxCoords) {
        nextBoxCoords = computeSavingMove();
    }
    if (!nextBoxCoords)
        nextBoxCoords = predictTrappingMove();

    if (!nextBoxCoords) {
        nextBoxCoords = computeRandomMove();
    }

    var nextBox = document.querySelector(`[id='${nextBoxCoords}']`);
    onCheckBox(nextBox);
}

function computeFirstMove() {
    var playedMove = checkedBoxes.map(b => b.box)[0];
    var edgeMoves = ['0-1', '1-0', '1-2', '2-1'];
    var cornerMoves = ['0-0', '0-2', '2-0', '2-2'];
    var centerMove = ['1-1'];
    if (edgeMoves.find(m => m == playedMove))
        return edgeMoveResponse(playedMove);
    else if (cornerMoves.find(m => m == playedMove))
        return '1-1';
    else if (centerMove.find(m => m == playedMove))
        return cornerMoves[Math.floor(Math.random() * cornerMoves.length)];
}

function edgeMoveResponse(playedMove) {
    if (playedMove == '1-2')
        return '0-2';
    else if (playedMove == "0-1")
        return "0-0";
    else if (playedMove == "1-0")
        return "2-0";
    else if (playedMove == '2-1')
        return '2-0';
}

function computeSavingMove() {
    var remainingMoves = getRemainingMoves();
    switchPlayer();
    var savingMoveCoords;
    for (var move of remainingMoves) {
        checkedBoxes.push({ box: move, player: currentPlayer });
        var nextBox = document.querySelector(`[id='${move}']`)
        if (checkWinner(true) == 'game over') {
            savingMoveCoords = move;
            onUncheckBox(nextBox, true);
            break;
        }
        onUncheckBox(nextBox, true);
    }
    switchPlayer();
    if (savingMoveCoords) {
        console.log('Playing Saving Move')
        return savingMoveCoords;
    }
}

function computeFinishingMove() {
    var remainingMoves = getRemainingMoves();
    var finishingMoveCoords;
    for (var move of remainingMoves) {
        checkedBoxes.push({ box: move, player: currentPlayer });
        var nextBox = document.querySelector(`[id='${move}']`)
        if (checkWinner(true) == 'game over') {
            finishingMoveCoords = move;
            onUncheckBox(nextBox, true);
            break;
        }
        onUncheckBox(nextBox, true);
    }
    if (finishingMoveCoords) {
        console.log('Playing Finishing Move')
        return finishingMoveCoords;
    }
    else {
        return '';
    }

}

function predictTrappingMove() {
    var checkedBoxesBackup = checkedBoxes.slice();
    var remainingMoves = getRemainingMoves();
    var nextMove;
    var moveFound;
    for (var move of remainingMoves) {
        checkedBoxes.push({ box: move, player: currentPlayer })
        switchPlayer();

        //Check if the opponent needs to play a saving move

        var savingMove = computeSavingMove();
        if (savingMove) {
            checkedBoxes.push({ box: savingMove, player: currentPlayer });
            if (checkTrap() == 'no trap') {
                checkedBoxes.pop();
                switchPlayer();
                nextMove = move;
                break;
            }
            checkedBoxes.pop();
            switchPlayer();
            continue;
        }

        //If no saving move is required, check each position
        else {
            switchPlayer();
            for (var opponentMove of getRemainingMoves()) {
                switchPlayer();
                moveFound = true;

                checkedBoxes.push({ box: opponentMove, player: currentPlayer });
                if (checkTrap() == 'trapped') {
                    moveFound = false;
                    checkedBoxes.pop();
                    switchPlayer();
                    break;
                }
                checkedBoxes.pop();
                switchPlayer();
            }
        }

        checkedBoxes.pop();
        if (moveFound) {
            nextMove = move;
            break;
        }
    }
    checkedBoxes = checkedBoxesBackup;
    return nextMove;
}

function checkTrap() {

    var boxes = getRemainingMoves();
    var winningMoveCount = 0;
    for (var freeMove of boxes) {
        checkedBoxes.push({ box: freeMove, player: currentPlayer });
        var result = checkWinner(true);
        if (result == 'game over')
            winningMoveCount++
        checkedBoxes.pop();
    }
    if (winningMoveCount > 1) {
        return 'trapped';
    }
    else {
        return 'no trap';
    }
}

function computeRandomMove() {
    var remainingMoves = getRemainingMoves();
    return remainingMoves[Math.floor(Math.random() * remainingMoves.length)]
}

function getRemainingMoves() {
    var allMoves = ['0-0', '0-1', '0-2',
        '1-0', '1-1', '1-2',
        '2-0', '2-1', '2-2',]
    var playedMoves = checkedBoxes.map(b => b.box);
    return allMoves.filter(m => !playedMoves.find(move => move == m));
}



function showLoader() {
    document.querySelector('.loader-overlay').style.display = 'block';
}

function hideLoader() {
    document.querySelector('.loader-overlay').style.display = 'none';
}


