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
    if (!is_array($board)) {
        return false;
    }
    
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
    if ($from === $to) {
        return false;
    }

    if (isset($board[$to])) {
        return false;
    }

    $fromPosition = array_map('intval', explode(',', $from));
    $toPosition = array_map('intval', explode(',', $to));

    $direction = [($toPosition[0] - $fromPosition[0]) <=> 0, ($toPosition[1] - $fromPosition[1]) <=> 0];

    $xMove = $fromPosition[0] !== $toPosition[0];
    $yMove = $fromPosition[1] !== $toPosition[1];
    $diagonalMove = abs($fromPosition[0] - $toPosition[0]) === abs($fromPosition[1] - $toPosition[1]);

    if ($xMove && $yMove && !$diagonalMove) {
        return false;
    }

    $currentPosition = [$fromPosition[0] + $direction[0], $fromPosition[1] + $direction[1]];
    $jumpedOverStone = false;

    while (implode(',', $currentPosition) !== $to) {
        $currentKey = implode(',', $currentPosition);

        if (!isset($board[$currentKey])) {
            return false;
        }

        $jumpedOverStone = true;

        $currentPosition = [$currentPosition[0] + $direction[0], $currentPosition[1] + $direction[1]];
    }

    return $jumpedOverStone;
}

function canAntMove($from, $to, $board)
{
    if ($from === $to) {
        return false;
    }

    if (isset($board[$to])) {
        return false;
    }

    $fromCoords = array_map('intval', explode(',', $from));
    $toCoords = array_map('intval', explode(',', $to));
    $visited = [$from => true];
    $queue = [];
    array_push($queue, $fromCoords);

    while (!empty($queue)) {
        $currentCoords = array_shift($queue);
        $currentKey = implode(',', $currentCoords);

        if ($currentKey === $to) {
            return true;
        }

        $neighbours = getNeighbours($currentKey);
        foreach ($neighbours as $neighbour) {
            if (!isset($board[$neighbour]) && !isset($visited[$neighbour])) {
                array_push($queue, array_map('intval', explode(',', $neighbour)));
                $visited[$neighbour] = true;
            }
        }
    }

    return false;
}

function canSpiderMove($from, $to, $board)
{
    if ($from === $to) {
        return false;
    }

    if (isset($board[$to])) {
        return false;
    }

    $fromCoords = array_map('intval', explode(',', $from));
    $visited = [$from => true];
    $validMoves = [$fromCoords];

    for ($i = 0; $i < 3; $i++) {
        $newValidMoves = [];

        foreach ($validMoves as $coords) {
            $neighbours = getNeighbours(implode(',', $coords));

            foreach ($neighbours as $neighbour) {
                if (!isset($board[$neighbour]) && !isset($visited[$neighbour])) {
                    $neighbourCoords = array_map('intval', explode(',', $neighbour));
                    $newValidMoves[] = $neighbourCoords;
                    $visited[$neighbour] = true;
                }
            }
        }

        $validMoves = $newValidMoves;

        if (empty($validMoves)) {
            return false;
        }
    }

    foreach ($validMoves as $coords) {
        if (implode(',', $coords) === $to) {
            return true;
        }
    }

    return false;
}

function canPlayerPass($player, $board, $hand)
{
    foreach ($hand as $piece => $count) {
        if ($count > 0) {
            foreach (getPlaceablePositions($player, $board) as $pos) {
                if (isPositionValid($pos, $board, $player)) {
                    return false;
                }
            }
        }
    }

    foreach ($board as $from => $tiles) {
        if (end($tiles)[0] == $player) {
            foreach (getMovablePositions($from, $board) as $to) {
                if (isValidMove($from, $to, $board)) {
                    return false;
                }
            }
        }
    }

    return true;
}

function getPlaceablePositions($player, $board)
{
    $placeablePositions = [];

    foreach ($board as $pos => $tiles) {
        if (end($tiles)[0] == $player) {
            $neighbours = getNeighbours($pos);

            foreach ($neighbours as $neighbour) {
                if (!isset($board[$neighbour]) && !in_array($neighbour, $placeablePositions)) {
                    $placeablePositions[] = $neighbour;
                }
            }
        }
    }

    return $placeablePositions;
}

function getMovablePositions($from, $board)
{
    $movablePositions = [];
    $neighbours = getNeighbours($from);

    foreach ($neighbours as $neighbour) {
        if (!isset($board[$neighbour])) {
            if (isValidMove($from, $neighbour, $board)) {
                $movablePositions[] = $neighbour;
            }
        }
    }

    return $movablePositions;
}

function isValidMove($from, $to, $board)
{
    $piece = end($board[$from]);

    switch ($piece[1]) {
        case 'Q': // Queen Bee
            return slide($from, $to, $board);
        case 'B': // Beetle
            return slide($from, $to, $board);
        case 'S': // Spider
            return canSpiderMove($from, $to, $board);
        case 'G': // Grasshopper
            return canGrasshopperMove($from, $to, $board);
        case 'A': // Ant
            return canAntMove($from, $to, $board);
        default:
            return false;
    }
}

function checkForWin($board)
{
    if (empty($board)) {
        return null;
    }

    $player0QueenSurrounded = true;
    $player1QueenSurrounded = true;
    $queenPositions = getQueenPositions($board);

    if (!isset($queenPositions[0]) || !isset($queenPositions[1])) {
        return null;
    }

    foreach ($queenPositions as $player => $queenPosition) {
        $neighbours = getNeighbours($queenPosition);
        if (!is_array($neighbours)) {
            continue;
        }
        foreach ($neighbours as $neighbour) {
            if (!isset($board[$neighbour])) {
                if ($player == 0) {
                    $player0QueenSurrounded = false;
                } else {
                    $player1QueenSurrounded = false;
                }
                break;
            }
        }
    }

    if ($player0QueenSurrounded && $player1QueenSurrounded) {
        return 'draw';
    } elseif ($player0QueenSurrounded) {
        return 0;
    } elseif ($player1QueenSurrounded) {
        return 1;
    }

    return null;
}

function getQueenPositions($board)
{
    $positions = [];
    foreach ($board as $position => $pieces) {
        if (is_array($pieces) && !empty($pieces)) {
            $lastPiece = end($pieces);
            if ($lastPiece[1] == 'Q') {
                $positions[$lastPiece[0]] = $position;
            }
        }
    }
    return $positions;
}
