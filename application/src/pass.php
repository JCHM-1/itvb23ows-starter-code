<?php

session_start();

include_once 'util.php';

$db = include_once 'database.php';
$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];
$state = getState();

if (canPlayerPass($player, $board, $hand)) {
    $stmt = $db->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
    $stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], $state);
    $stmt->execute();
    $_SESSION['last_move'] = $db->insert_id;
    $_SESSION['player'] = 1 - $_SESSION['player'];

    if (!headers_sent()) {
        header('Location: index.php');
        exit;
    } else {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
} else {
    $_SESSION['error'] = 'Cannot pass, there are valid moves available.';
    if (!headers_sent()) {
        header('Location: index.php');
        exit;
    } else {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}
