<?php

namespace arts19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceGameTest extends TestCase
{
    /**
     * Getting the current player
     */
    public function testCurrentPlayer()
    {
        $diceGame = new DiceGame();
        $this->assertTrue($diceGame->getCurrentPlayer() === "spelaren");

        $diceGame->changePlayer();
        $this->assertTrue($diceGame->getCurrentPlayer() === "datorn");
        $diceGame->changePlayer();
        $this->assertTrue($diceGame->getCurrentPlayer() === "spelaren");
    }


    /**
     * Getting the other player
     */
    public function testOtherPlayer()
    {
        $diceGame = new DiceGame(3);
        $this->assertTrue($diceGame->getOtherPlayer() === "datorn");

        $diceGame->changePlayer();
        $this->assertTrue($diceGame->getOtherPlayer() === "spelaren");
    }


    /**
     * Getting initial scores
     */
    public function testInitialScrores()
    {
        $diceGame = new DiceGame(4);
        $this->assertTrue($diceGame->getScorePlayer1() === 0);
        $this->assertTrue($diceGame->getScorePlayer2() === 0);
    }


    /**
     * Testing nr of rounds
     */
    public function testNrOfRounds()
    {
        $diceGame = new DiceGame(1);
        $this->assertTrue($diceGame->getNrOfRounds() === 0);
        $diceGame->roll();
        if ($diceGame->getCurrentRound() > 0) {
            $this->assertTrue($diceGame->getNrOfRounds() === 1);
        }
    }


    /**
     * Testing failed rolls (containing 1)
     */
    public function testFailedRoll()
    {
        $diceGame = new DiceGame(5, 2);
        $diceGame->roll();
        if ($diceGame->getCurrentRound() === 0) {
            $this->assertTrue($diceGame->getNrOfRounds() === 0);
        }
    }


    /**
     * Test computer quitting round
     */
    public function testComputerQuit()
    {
        $diceGame = new DiceGame(1, 999999999999999999);
        $diceGame->changePlayer();
        $diceGame->roll();
        $this->assertTrue($diceGame->getCurrentRound() === 0);
    }


    /**
     * Testing current roll
     */
    public function testCurrentRoll()
    {
        $diceGame = new DiceGame(2);
        $this->assertTrue($diceGame->getCurrentRoll() === []);
    }


    /**
     * Testing current roll
     */
    public function testQuitCurrentRound()
    {
        $diceGame = new DiceGame(8);
        $player1 = $diceGame->getCurrentPlayer();
        $diceGame->quitCurrentRound();
        $player2 = $diceGame->getCurrentPlayer();
        $this->assertTrue($player1 !== $player2);
        $diceGame->quitCurrentRound();
        $player3 = $diceGame->getCurrentPlayer();
        $this->assertTrue($player1 === $player3);
    }


    /**
     * Sum current roll
     */
    public function testSumCurrentRoll()
    {
        $diceGame = new DiceGame(2);
        $this->assertTrue($diceGame->sumCurrentRoll() === 0);
    }
}
