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
            '0,0' => [['0', 'A']],
            '0,1' => [['1', 'X']],
            '0,2' => [],
            '0,3' => [] 
        ];

        $from = '0,0';
        $to = '0,3';
        $this->assertTrue(canAntMove($from, $to, $board));
    }

    public function testAntMoveIsLikeQueenBee()
    {
        require_once 'util.php';

        $board = [
            '0,0' => [['0', 'A']],
            '0,1' => [],
            '1,1' => []
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
            '0,1' => [['1', 'X']],
            '0,2' => [],
            '0,3' => [['1', 'Y']]
        ];

        $from = '0,0';
        $to = '0,2';
        $this->assertTrue(canAntMove($from, $to, $board));

        $to = '0,3';
        $this->assertFalse(canAntMove($from, $to, $board));
    }
}