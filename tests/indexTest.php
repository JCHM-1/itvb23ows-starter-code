<?php

use PHPUnit\Framework\TestCase;

class indexTest extends TestCase
{
    private array $board;
    private int $player;

    protected function setUp(): void
    {
       $this->board = [
           '0,0' => [[0, 'Q']],
           '1,0' => [[1, 'B']],
       ];
       $this->player = 0;
    }

    protected function tearDown(): void
    {
        $this->board = [
            '0,0' => [[0, 'Q']],
            '1,0' => [[1, 'B']],
        ];
    }

    public function testIsPositionValid()
    {
        require_once 'util.php';

        $this->assertFalse(isPositionValid('2,2', $this->board, $this->player));
        $this->assertFalse(isPositionValid('0,0', $this->board, $this->player));
        $this->assertFalse(isPositionValid('0,1', $this->board, $this->player));
        $this->assertTrue(isPositionValid('0,-1', $this->board, $this->player));
        $this->assertTrue(isPositionValid('0,0', [], $this->player));
    }

    public function testSelectMoveOptions()
    {
        require_once 'util.php';

        $expectedOption = "<option value=\"0,0\">0,0</option>";
        $notExpectedOption1 = "<option value=\"1,0\">1,0</option>";
        $notExpectedOption2 = "<option value=\"1,-1\">1,-1</option>";

        $this->assertEquals($expectedOption, (generateMoveOptions($this->board, $this->player)));
        $this->assertNotEquals($notExpectedOption1, (generateMoveOptions($this->board, $this->player)));
        $this->assertNotEquals($notExpectedOption2, (generateMoveOptions($this->board, $this->player)));
    }

    public function testSlide()
    {
        require_once 'util.php';

        $this->board = [
            '0,0' => [[0, 'Q']],
            '1,0' => [[1, 'B']],
            '0,1' => [[0, 'A']],
            '-1,0' => [[1, 'S']],
        ];
    
        $this->assertFalse(slide($this->board, '0,0', '2,2'));
        $this->assertTrue(slide($this->board, '0,0', '0,-1'));
        $this->assertFalse(slide($this->board, '0,0', '1,1'));
    }
}
