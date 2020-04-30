<?php

namespace arts19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class HistogramTraitTest extends TestCase
{
    /**
     * Create dice without arguments
     */
    public function testGetAsText()
    {
        $game = new DiceGame();
        $array = [1, 4, 8, 4, 2, 4, 1];
        $res = $game->getAsText($array);
        $this->assertIsString($res);
        $this->assertContains("***", $res);
    }


    /**
     * Create dice with a correct argument
     */
    public function testCountItemInArray()
    {
        $game = new DiceGame();
        $array = [1, 4, 8, 4, 2, 4, 1];
        $item = 4;
        $res = $game->countItemInArray($array, $item);
        $this->assertTrue($res === 3);
    }
}
