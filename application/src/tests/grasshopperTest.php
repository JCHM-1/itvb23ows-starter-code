<?php

use PHPUnit\Framework\TestCase;

class grasshopperTest extends TestCase
{
    public function testGrasshopperCannotMoveToTheSamePosition()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'G']],
            
        ];

        $from = '0,0';
        $to = '0,0';
        $this->assertFalse(canGrasshopperMove($from, $to, $board));
    }

    public function testGrasshopperCanJumpOverAtLeastOneTile()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'G']],
            '0,1' => [['1', 'X']]
        ];

        $from = '0,0';
        $to = '0,2';
        $this->assertTrue(canGrasshopperMove($from, $to, $board));
    }

    public function testGrasshopperCannotJumpToAnOccupiedField()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'G']],
            '0,1' => [['1', 'X']],
            '0,2' => [['1', 'Y']]
        ];

        $from = '0,0';
        $to = '0,2';
        $this->assertFalse(canGrasshopperMove($from, $to, $board));
    }

    public function testGrasshopperCannotJumpOverEmptyFields()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'G']],
            '0,1' => [],
            '0,2' => [['1', 'X']],
            '0,3' => []
        ];

        $from = '0,0';
        $to = '0,3';
        $this->assertFalse(canGrasshopperMove($from, $to, $board));
    }

    public function testGrasshopperMovesInAStraightLine()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'G']],
            '0,1' => [['1', 'X']],
            '1,1' => [['1', 'Y']]
        ];

        $from = '0,0';
        $to = '1,1';
        $this->assertFalse(canGrasshopperMove($from, $to, $board));

        $to = '0,2';
        $this->assertTrue(canGrasshopperMove($from, $to, $board));
    }


}