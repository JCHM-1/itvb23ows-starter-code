<?php

session_start();

include_once 'util.php';

$db = include 'database.php';

if (!isset($_POST['piece'])) {
    $_SESSION['error'] = "No pieces left";
    header('Location: index.php');
    exit;
}

$piece = $_POST['piece'];
$to = $_POST['to'];

$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];
$state = getState();

if (!$hand[$piece]) {
    $_SESSION['error'] = "Player does not have tile";
} elseif (isset($board[$to])) {
    $_SESSION['error'] = 'Board position is not empty';
} elseif (count($board) && !hasNeighBour($to, $board)) {
    $_SESSION['error'] = "board position has no neighbour";
} elseif (array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board)) {
    $_SESSION['error'] = "Board position has opposing neighbour";
} elseif (validateQueenBeePlaced($piece, $board, $hand)) {
    $_SESSION['error'] = 'Must play queen bee';
} else {
    $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
    $_SESSION['hand'][$player][$piece]--;
    $_SESSION['player'] = 1 - $_SESSION['player'];

    $winResult = checkForWin($_SESSION['board']);

    if ($winResult !== null) {
        if ($winResult === 'draw') {
            $_SESSION['game_status'] = 'draw';
            $_SESSION['error'] = "The game has been drawn ";
        } else {
            $_SESSION['game_status'] = 'win';
            $_SESSION['winner'] = $winResult;
            $_SESSION['error'] = "The game has been won by player: ";
        }
    }

    $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state)values (?, "play", ?, ?, ?, ?)');
    $stmt->bind_param('issis', $_SESSION['game_id'], $piece, $to, $_SESSION['last_move'], $state);
    $stmt->execute();
    $_SESSION['last_move'] = $db->insert_id;
}

header('Location: index.php');
