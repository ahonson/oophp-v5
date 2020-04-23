<?php

namespace arts19\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Dice
{
    /**
     * Constructor to initiate a dice object with the right number of sides,
     *
     * @param int $sides .
     *
     */

    public function __construct(int $sides = 6)
    {
        if ($sides > 1) {
            $this->sides = $sides;
        } else {
            $this->sides = 6;
        }
        $this->currentValue = 0;
    }


    /**
     * Randomize the currnt value between 1 and number of sides.
     *
     * @return int as the current value.
     */

    public function roll()
    {
        $this->currentValue = rand(1, $this->sides);
        return $this->currentValue;
    }


    /**
     * Get number of tries left.
     *
     * @return int as number of sides.
     */

    public function sides()
    {
        return $this->sides;
    }
}
