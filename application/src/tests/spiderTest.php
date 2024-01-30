<?php

use PHPUnit\Framework\TestCase;

class spiderTest extends TestCase
{
    public function testSpiderCanMoveExactlyThreeSteps()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']]
        ];

        $from = '0,0';
        $to = '0,3';
        $this->assertTrue(canSpiderMove($from, $to, $board));
    }

    public function testSpiderMoveIsLikeQueenBee()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']],
        ];

        $from = '0,0';
        $to = '0,1';
        $this->assertTrue(canSpiderMove($from, $to, $board));

        $to = '1,1';
        $this->assertFalse(canSpiderMove($from, $to, $board));
    }

    public function testSpiderCannotMoveToTheSamePosition()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']],
        ];

        $from = '0,0';
        $to = '0,0';
        $this->assertFalse(canSpiderMove($from, $to, $board));
    }

    public function testSpiderMovesOnlyOverAndToEmptyFields()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']],
            '0,2' => [['1', 'X']]
        ];

        $from = '0,0';
        $to = '0,3';
        $this->assertFalse(canSpiderMove($from, $to, $board));
    }

    public function testSpiderCannotMoveToAFieldAlreadyVisitedDuringMove()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'S']]
        ];

        $from = '0,0';
        $to = '1,0';
        $this->assertFalse(canSpiderMove($from, $to, $board));
    }
}
