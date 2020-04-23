<?php

namespace arts19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * Create dice without arguments
     */
    public function testMakeDefaultDice()
    {
        $dice = new Dice();
        $this->assertTrue($dice->sides() === 6);
    }


    /**
     * Create dice with a correct argument
     */
    public function testMakeSpecialDice()
    {
        $dice = new Dice(4);
        $this->assertTrue($dice->sides() === 4);
    }


    /**
     * Create dice with a wrong argument
     */
    public function testMakeWrongDice()
    {
        $dice = new Dice(0);
        $this->assertTrue($dice->sides() === 6);
    }


    /**
     * Roll default dice
     */
    public function testRollDefaultDice()
    {
        $dice = new Dice();
        $this->assertTrue($dice->roll() <= $dice->sides());
    }
}
