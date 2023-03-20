<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Game Tictactoe | Gabut</title>
	<style type="text/css">
		
		* {
			margin: 0;
			padding: 0;
		}

		body {
			font-family: Arial;
			background-color: #f0f5fb;
		} 

		header {
			font-size: 1.3em;
			font-weight: bold;
			color: black;
			background-color: #4fa4fa;
			height: 60px;
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 0;
			margin-bottom: 50px;
			box-sizing: border-box;
			box-shadow: 0vh 0vh 0.5vh black;
		}

		p {
			position: relative;
			bottom: 5vh;
			font-size: 20px;
			font-weight: bold;
			text-align: center;
			margin-right: auto;
			margin-left: auto;
			display: block;
			color: black;
		}

		h5 {
			font-weight: bold;
			text-align: center;
			margin-right: auto;
			margin-left: auto;
			display: block;
			color: black;
		}

		a, a:hover a:visited {
			color: #ff0000;
		}

		#content {
			padding: 5px;
			font-size: 4em;
			width: 300px;
			height: 310px;
			margin-right: auto;
			margin-left: auto;
			color: #0008ff;
			background-color: #fafafa;
			text-align: center;
			border-radius: 0.5vh;
			box-shadow: 0vh 0vh 0.5vh black;
			vertical-align: center;
		}

		#content td {
			border-collapse: collapse;
			border-left: 2px solid #262627;
			border-bottom: 2px solid #262627;
		}

		#content td:first-child {
			border-left: none;
		}

		#content tr:last-child  td {
			border-bottom: none;
		}

		#content td {
			cursor: pointer;
			height: 95px;
			width: 95px;
		}

		#content td:hover {
			background-color: #fafa44;
		}

		#restart {
			font-weight: bold;
			display: block;
			padding: 20px;
			margin-left: auto;
			margin-right: auto;
			border-radius: 1vh;
			border: none;
			font-size: 1em;
			width: 200px;
			box-shadow: 0vh 0vh 0.3vh black;
			background-color: #fafafa;
			cursor: pointer;
		}

		#restart:hover {
			background-color: #4fa4fa;
		}
	</style>
</head>
<body>

	<header>
		 GAME TICTACTOE
	</header>
	<br>

	<p id="message"></p>
	<br>

	<table id="content" cellspacing="0">
		<tr>
			<td id="00" onclick="clickedCell(this)"></td>
			<td id="01" onclick="clickedCell(this)"></td>
			<td id="02" onclick="clickedCell(this)"></td>
		</tr>
		<tr>
			<td id="10" onclick="clickedCell(this)"></td>
			<td id="11" onclick="clickedCell(this)"></td>
			<td id="12" onclick="clickedCell(this)"></td>
		</tr>
		<tr>
			<td id="20" onclick="clickedCell(this)"></td>
			<td id="21" onclick="clickedCell(this)"></td>
			<td id="22" onclick="clickedCell(this)"></td>
		</tr>
	</table>
	<br>
	<br>

	<input type="button" value="Restart Game" id="restart" onclick="restartBttn(this)">
	<br>

	<footer>
		<h5>
			Di buat dengan ❤️ oleh Romli Suhanda		
		</h5>
	</footer>
	<script type="text/javascript">
		
		var board = [
			[0, 0, 0],
			[0, 0, 0],
			[0, 0, 0],
		];

		var HUMAN = -1;
		var COMP = +1;

		function evalute(state) {
			var score = 0;

			if (gameOver(state, COMP)) {
				score = +1;
			}
			else if (gameOver(state, HUMAN)) {
				score = -1;
			} else {
				score = 0;
			}

			return score;
		}

		function gameOver(state, player) {
			var win_state = [
				[state[0][0], state[0][1], state[0][2]],
				[state[1][0], state[1][1], state[1][2]],
				[state[2][0], state[2][1], state[2][2]],
				[state[0][0], state[1][0], state[2][0]],
				[state[0][1], state[1][1], state[2][1]],
				[state[0][2], state[1][2], state[2][2]],
				[state[0][0], state[1][1], state[2][2]],
				[state[2][0], state[1][1], state[0][2]],
			];

			for (var i = 0; i < 8; i++) {
				var line = win_state[i];
				var filled = 0;
				for (var j = 0; j < 3; j++) {
					if (line[j] == player)
						filled++;
				}
				if (filled == 3)
					return true;
			}
			return false;
		}

		function gameOverAll(state) {
			return gameOver(state, HUMAN) || gameOver(state, COMP);
		}

		function emptyCells(state) {
			var cells = [];
			for (var x = 0; x < 3; x++) {
				for (var y = 0; y < 3; y++) {
					if (state[x][y] == 0)
						cells.push([x, y]);
				}
			}

			return cells;
		}

		function validMove(x, y) {
			var empties = emptyCells(board);
			try {
				if (board[x][y] == 0) {
					return true;
				}
				else {
					return false;
				}
			} catch (e) {
				return false;
			}
		}

		function setMove(x, y, player) {
			if (validMove(x, y)) {
				board[x][y] = player;
				return true;
			}
			else {
				return false;
			}
		}

		function minimax(state, depth, player) {
			var best;

			if (player == COMP) {
				best = [-1, -1, -1000];
			}
			else {
				best = [-1, -1, +1000];
			}

			if (depth == 0 || gameOverAll(state)) {
				var score = evalute(state);
				return [-1, -1, score];
			}

			emptyCells(state).forEach(function (cell) {
				var x = cell[0];
				var y = cell[1];
				state[x][y] = player;
				var score = minimax(state, depth - 1, -player);
				state[x][y] = 0;
				score[0] = x;
				score[1] = y;

				if (player == COMP) {
					if (score[2] > best[2])
						best = score;
				}
				else {
					if (score[2] < best[2])
						best = score;
				}
			});

			return best;
		}

		function aiTurn() {
			var x, y;
			var move;
			var cell;

			if (emptyCells(board).length == 9) {
				x = parseInt(Math.random() * 3);
				y = parseInt(Math.random() * 3);
			}
			else {
				move = minimax(board, emptyCells(board).length, COMP);
				x = move[0];
				y = move[1];
			}

			if (setMove(x, y, COMP)) {
				cell = document.getElementById(String(x) + String(y));
				cell.innerHTML = "O";
			}
		}

		function clickedCell(cell) {
			var button = document.getElementById("restart");
			button.disabled = true;
			var conditionToContinue = gameOverAll(board) == false && emptyCells(board).length > 0;

			if (conditionToContinue == true) {
				var x = cell.id.split("")[0];
				var y = cell.id.split("")[1];
				var move = setMove(x, y, HUMAN);
				if (move == true) {
					cell.innerHTML = "X";
					if (conditionToContinue)
						aiTurn();
				}
			}
			if (gameOver(board, COMP)) {
				var lines;
				var cell;
				var msg;

				if (board[0][0] == 1 && board[0][1] == 1 && board[0][2] == 1)
					lines = [[0, 0], [0, 1], [0, 2]];
				else if (board[1][0] == 1 && board[1][1] == 1 && board[1][2] == 1)
					lines = [[1, 0], [1, 1], [1, 2]];
				else if (board[2][0] == 1 && board[2][1] == 1 && board[2][2] == 1)
					lines = [[2, 0], [2, 1], [2, 2]];
				else if (board[0][0] == 1 && board[1][0] == 1 && board[2][0] == 1)
					lines = [[0, 0], [1, 0], [2, 0]];
				else if (board[0][1] == 1 && board[1][1] == 1 && board[2][1] == 1)
					lines = [[0, 1], [1, 1], [2, 1]];
				else if (board[0][2] == 1 && board[1][2] == 1 && board[2][2] == 1)
					lines = [[0, 2], [1, 2], [2, 2]];
				else if (board[0][0] == 1 && board[1][1] == 1 && board[2][2] == 1)
					lines = [[0, 0], [1, 1], [2, 2]];
				else if (board[2][0] == 1 && board[1][1] == 1 && board[0][2] == 1)
					lines = [[2, 0], [1, 1], [0, 2]];

				for (var i = 0; i < lines.length; i++) {
					cell = document.getElementById(String(lines[i][0]) + String(lines[i][1]));
					cell.style.color = "red";
				}

				msg = document.getElementById("message");
				msg.innerHTML = "Kamu Kalah!";
			}
			if (emptyCells(board).length == 0 && !gameOverAll(board)) {
				var msg = document.getElementById("message");
				msg.innerHTML = "Hasil Seri!";
			}
			if (gameOverAll(board) == true || emptyCells(board).length == 0) {
				button.value = "Restart";
				button.disabled = false;
			}
		}

		function restartBttn(button) {
			if (button.value == "Komputer Duluan!") {
				aiTurn();
				button.disabled = true;
			}
			else if (button.value == "Restart") {
				var htmlBoard;
				var msg;

				for (var x = 0; x < 3; x++) {
					for (var y = 0; y < 3; y++) {
						board[x][y] = 0;
						htmlBoard = document.getElementById(String(x) + String(y));
						htmlBoard.style.color = "#444";
						htmlBoard.innerHTML = "";
					}
				}
				button.value = "Komputer Duluan!";
				msg = document.getElementById("message");
				msg.innerHTML = "";
			}
		}

	</script>
</body>
</html>