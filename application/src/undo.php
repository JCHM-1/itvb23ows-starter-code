<?php

session_start();

include_once 'util.php';

$db = include_once 'database.php';

if (undoLastMove($db, $_SESSION)) {
    header('Location: index.php');
} else {
    $_SESSION['error'] = 'No move to undo';
    header('Location: index.php');
}
