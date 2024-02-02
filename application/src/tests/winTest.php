<?php

use PHPUnit\Framework\TestCase;

class winTest extends TestCase
{
    public function testPlayerWinsBySurroundingOpponentQueen()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['1', 'Q']],
            '1,0' => [['0', 'A']],
            '1,-1' => [['0', 'B']],
            '0,-1' => [['0', 'S']],
            '-1,0' => [['0', 'G']],
            '-1,1' => [['0', 'A']],
            '0,1' => [['0', 'B']],
            '1,1' => [['0', 'S']],
        ];

        $result = checkForWin($board);
        $this->assertEquals($result, 0, "Player 0 should win by surrounding opponent's queen");
    }

    public function testGameEndsInDrawWhenBothQueensAreSurroundedSimultaneously()
    {
        require_once 'util.php';
        
        $board = [
            '0,0' => [['0', 'Q']],
            '1,0' => [['1', 'A']],
            '1,-1' => [['1', 'B']],
            '0,-1' => [['1', 'S']],
            '-1,0' => [['1', 'G']],
            '-1,1' => [['1', 'A']],
            '0,1' => [['1', 'B']],
            '3,3' => [['1', 'Q']],
            '4,3' => [['0', 'A']],
            '4,2' => [['0', 'B']],
            '3,2' => [['0', 'S']],
            '2,3' => [['0', 'G']],
            '2,4' => [['0', 'A']],
            '3,4' => [['0', 'B']],
        ];

        $result = checkForWin($board);
        $this->assertEquals($result, 'draw', "Game should end in a draw when both queens are surrounded simultaneously");
    }
}