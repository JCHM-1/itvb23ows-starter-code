<?php

use PHPUnit\Framework\TestCase;

class antTest extends TestCase
{
    public function testAntCannotMoveToTheSamePosition()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'A']]
        ];

        $from = '0,0';
        $to = '0,0';
        $this->assertFalse(canAntMove($from, $to, $board));
    }

    public function testAntCanMoveMultipleSteps()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'Q']],
            '0,1' => [['1', 'Q']],
            '0,2' => [['0', 'B']],
            '1,1' => [['1', 'B']],
            '-1,0' => [['0', 'S']],
            '0,-1' => [['0', 'B']],
            '0,-2' => [['0', 'B']],
            '-1,3' => [['1', 'A']]
        ];

        $from = '-1,3';
        $to = '0,-3';
        $this->assertTrue(canAntMove($from, $to, $board));
    }

    public function testAntMoveIsLikeQueenBee()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'A']]
        ];

        $from = '0,0';
        $to = '0,1';
        $this->assertTrue(canAntMove($from, $to, $board));

        $to = '1,1';
        $this->assertTrue(canAntMove($from, $to, $board));
    }

    public function testAntMovesOnlyOverAndToEmptyFields()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'A']],
            '0,1' => [['1', 'S']],
            '0,3' => [['1', 'G']]
        ];

        $from = '0,0';
        $to = '0,2';
        $this->assertTrue(canAntMove($from, $to, $board));

        $to = '0,3';
        $this->assertFalse(canAntMove($from, $to, $board));
    }
}