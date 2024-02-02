<?php

use PHPUnit\Framework\TestCase;

class passTest extends TestCase
{
    public function testPlayerCanPassWhenNoMovesLeft()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'A']],
            '1,0' => [['1', 'B']],
            '0,1' => [['1', 'Q']],
            '-1,0' => [['1', 'B']],
            '0,-1' => [['1', 'B']],
            '1,1' => [['1', 'A']],
            '-1,-1' => [['1', 'S']],
            '-1,1' => [['1', 'S']],
            '1,-1' => [['1', 'S']]
        ];

        $hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0
        ];

        $player = 0;

        $this->assertTrue(canPlayerPass($player, $board, $hand), "Player should be able to pass when no moves are left");
    }

    public function testPlayerCannotPass()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'Q']],
            '1,0' => [['1', 'B']],
        ];

        $hand = [
            "Q" => 0,
            "B" => 2,
            "S" => 2, 
            "A" => 3, 
            "G" => 3
        ];

        $player = 0;

        $this->assertFalse(canPlayerPass($player, $board, $hand), "Player should not be able to pass when a complex move is available");
    }
}
