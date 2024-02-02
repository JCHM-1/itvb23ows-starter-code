<?php

include_once 'play.php';
include_once 'pass.php';
include_once 'move.php';



function getMoveFromHiveAI($move_number)
{
    $player = $_SESSION['player'];
    $board = $_SESSION['board'];
    $hand = $_SESSION['hand'][$player];

    $baseUrl = "http://localhost:5000/";

    $data = [
        "move_number" => $move_number,
        "hand" => $hand,
        "board" => $board,
    ];

    $options = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json\r\n",
            "content" => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);

    $result = file_get_contents($baseUrl, false, $context);

    $responseData = json_decode($result, true);

    if ($responseData['action'] === 'move') {
        $from = $responseData[1];
        $to = $responseData[2];
        include 'move.php';
        // handleMoveAction($from, $to);
    } elseif ($responseData['action'] === 'play') {
        $from = $responseData[1];
        $to = $responseData[2];
        include 'play.php';
        // handlePlayAction($from, $to); // Call the function in play.php with parameters
    } elseif ($responseData['action'] === 'pass') {
        include 'pass.php';
        // handlePassAction(); // Call the function in pass.php
    } else {
        // Handle other cases or errors
        echo "Unknown action received from HiveAI";
    }
}
