<?php

use PHPUnit\Framework\TestCase;

class passTest extends TestCase
{
    public function testPlayerCanPassWhenNoValidMovesAvailable()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['1', 'Q']],
            '0,1' => [['1', 'B']],
            '0,2' => [['1', 'S']],
            '1,0' => [['0', 'A']],
            '1,1' => [['0', 'B']],
            '1,2' => [['0', 'S']],
            '2,0' => [['1', 'A']],
            '2,1' => [['1', 'G']],
            '2,2' => [['1', 'S']],
        ];

        $hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0
        ];

        $player = 0;

        $this->assertTrue(canPlayerPass($player, $board, $hand));
    }

    public function testPlayerCannotPassWhenValidMovesAvailable()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']]
        ];

        $hand = [
            "Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3
        ];

        $player = 1;

        $this->assertFalse(canPlayerPass($player, $board, $hand));
    }
}
