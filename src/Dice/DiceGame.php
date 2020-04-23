<?php

namespace arts19\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class DiceGame
{
    /**
     * Constructor to initiate a dice object with the right number of sides,
     *
     * @param int $sides .
     *
     */

    public function __construct(int $dices = 2, int $sides = 6)
    {
        if ($dices > 0 && $dices < 6) {
            $this->dices = $dices;
        } else {
            $this->dices = 2;
        }

        $this->allDices = [];
        for ($i = 0; $i < $this->dices; $i++) {
            $currentDice = new Dice($sides);
            array_push($this->allDices, $currentDice);
        }

        $this->player1 = 0;
        $this->player2 = 0;
        $this->rounds = 0;
        $this->currentRound = 0;
        $this->currentRoll = [];
        $this->currentPlayer = "spelaren";
    }


    /**
     * Roll all dices
     *
     * @return void
     */

    public function roll()
    {
        $this->currentRoll = [];
        for ($i = 0; $i < $this->dices; $i++) {
            $value = $this->allDices[$i]->roll();
            array_push($this->currentRoll, $value);
        }
        if (in_array(1, $this->currentRoll)) {
            $this->currentRound = 0;
            $this->quitCurrentRound();
        } else {
            $this->addToRound();
            if ($this->currentPlayer === "datorn") {
                if ($this->currentRound >= 20 ||
                    $this->player2 + $this->currentRound >= 100) {
                    $this->quitCurrentRound();
                }
            }
        }
    }


    /**
     *
     * @return array containing all the values of the current roll
     */
    public function getCurrentRoll()
    {
        return $this->currentRoll;
    }



    /**
     * Sum values in current roll.
     *
     * @return int as the total value.
     */

    public function sumCurrentRoll()
    {
        return array_sum($this->currentRoll);
    }


    /**
     * Adding current roll to current round
     *
     * @return void
     */

    public function addToRound()
    {
        $this->currentRound += $this->sumCurrentRoll();
        $this->rounds += 1;
    }


    /**
     * Sum values in current roll.
     *
     * @return int as the total value.
     */

    public function addToTotal()
    {
        if ($this->getCurrentPlayer() === "spelaren") {
            $this->player1 += $this->currentRound;
        } elseif ($this->getCurrentPlayer() === "datorn") {
            $this->player2 += $this->currentRound;
        }
        $this->currentRound = 0;
        $this->rounds = 0;
    }



    /**
     * Quitting current round.
     *
     * @return void
     */

    public function quitCurrentRound()
    {
        $this->addToTotal();
        $this->changePlayer();
    }


    /**
     * Change player
     *
     * @return void
     */

    public function changePlayer()
    {
        if ($this->currentPlayer === "spelaren") {
            $this->currentPlayer = "datorn";
        } elseif ($this->currentPlayer === "datorn") {
            $this->currentPlayer = "spelaren";
        }
    }

    /**
     * Get the current value.
     *
     * @return string as the current player
     */

    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }

    /**
     * Get the current value.
     *
     * @return string as the current player
     */

    public function getOtherPlayer()
    {
        if ($this->currentPlayer === "spelaren") {
            return "datorn";
        }
        return "spelaren";
    }


    /**
     * Get the current value.
     *
     * @return int as the score for player1
     */

    public function getScorePlayer1()
    {
        return $this->player1;
    }


    /**
     * Get the current value.
     *
     * @return int as the score for player2
     */

    public function getScorePlayer2()
    {
        return $this->player2;
    }


    /**
     * Get the current value.
     *
     * @return int as the nr of roll in a round
     */

    public function getNrOfRounds()
    {
        return $this->rounds;
    }


    /**
     * Get the current value.
     *
     * @return int as the nr of roll in a round
     */

    public function getCurrentRound()
    {
        return $this->currentRound;
    }
}
