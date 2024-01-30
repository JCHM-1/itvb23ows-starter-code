<?php

$GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

function isNeighbour($a, $b)
{
    $a = explode(',', $a);
    $b = explode(',', $b);
    $isNeighbour = false;

    if (($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) ||
        ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) ||
        ($a[0] + $a[1] == $b[0] + $b[1])) {
        $isNeighbour = true;
    }

    return $isNeighbour;
}

function hasNeighbour($a, $board)
{
    foreach (array_keys($board) as $b) {
        if (isNeighbour($a, $b)) return true;
    }
}

function neighboursAreSameColor($player, $a, $board)
{
    foreach ($board as $b => $st) {
        if (!$st) continue;
        $c = $st[count($st) - 1][0];
        if ($c != $player && isNeighbour($a, $b)) return false;
    }
    return true;
}

function len($tile)
{
    return $tile ? count($tile) : 0;
}

function slide($board, $from, $to)
{
    if (!hasNeighbour($to, $board) || !isNeighbour($from, $to)) {
        return false;
    }

    $fromNeighbours = getNeighbours($from);
    $toNeighbours = getNeighbours($to);

    $commonNeighbours = array_intersect($fromNeighbours, $toNeighbours);
    $commonNeighboursWithTile = array_filter($commonNeighbours, function ($pos) use ($board) {
        return isset($board[$pos]);
    });

    return count($commonNeighboursWithTile) > 0;
}


function getNeighbours($position)
{
    $neighbours = [];
    $positionParts = explode(',', $position);
    
    foreach ($GLOBALS['OFFSETS'] as $offset) {
        $neighbours[] = ($positionParts[0] + $offset[0]) . ',' . ($positionParts[1] + $offset[1]);
    }
    return $neighbours;
}


function isPositionValid($position, $board, $player): bool
{
    if (!empty($board[$position])) {
        return false;
    }

    if (empty($board)) {
        return $position === '0,0';
    }

    if (count($board) === 1) {
        return hasNeighbour($position, $board);
    }

    return hasNeighbour($position, $board) && neighboursAreSameColor($player, $position, $board);
}

function validateQueenBeePlaced($piece, $board, $hand)
{
    return $piece != 'Q' && array_sum($hand) <= 8 && $hand['Q'];
}

function generateMoveOptions($board, $player)
{
    $options = '';
    foreach ($board as $pos => $tiles) {
        if (!empty($tiles) && end($tiles)[0] == $player) {
            $options .= "<option value=\"$pos\">$pos</option>";
        }
    }
    return $options;
}

function canGrasshopperMove($from, $to, $board)
{
    //todo

    return null;
}
