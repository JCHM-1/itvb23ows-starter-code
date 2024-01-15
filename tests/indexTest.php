<?php

use PHPUnit\Framework\TestCase;

class indexTest extends TestCase
{
    //arrange
    //act
    //assert

    public function testIsPositionValid()
    {
        require_once 'util.php';
        $board = [
            '0,0' => [[0, 'Q']], // Example: White Queen Bee at 0,0
            '1,0' => [[1, 'B']], // Example: Black Beetle at 1,0
        ];
        $player = 0; // White player

        $this->assertFalse(isPositionValid('2,2', $board, $player));
        $this->assertFalse(isPositionValid('0,0', $board, $player));
        $this->assertFalse(isPositionValid('0,1', $board, $player));
        $this->assertTrue(isPositionValid('0,-1', $board, $player));
        $this->assertTrue(isPositionValid('0,0', [], $player));
    }



}