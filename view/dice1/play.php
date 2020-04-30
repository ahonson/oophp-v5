<?php

namespace Anax\View;

if ($diceGame->rounds === 1) {
    $plural = "";
} else {
    $plural = "er";
}

?>
<h1>Tärningsspelet 100</h1>
<p>Spelaren har <?= $player ?> poäng.</p>
<p>Datorn har <?= $computer ?> poäng.</p>

<?php
if ($diceGame->getScorePlayer1() > 99 || $diceGame->getScorePlayer2() > 99) {
    echo "<h2>Spelet är slut, " . $diceGame->getOtherPlayer() . " har vunnit.</h2>";
    echo "<a href='../dice1'>Spela igen.</a>";
    die();
}
?>

<h2>Det är <?= $currentPlayer ?>s tur.</h2>

<form method="post" action="process">
    <input type="submit" name="submit" value="Rulla tärningarna">
    <input type="submit" name="save" value="Avbryt spelrundan"
    <?php if ($currentPlayer === "datorn") {
        echo "disabled";
    } ?>
    >
    <input type="submit" name="reset" value="Starta ett nytt spel">
</form>

<p>I den här spelrundan har <?= $currentPlayer ?> sammanlagt <?= $currentScore ?> poäng.</p>
<p>I den här spelrundan har tärningarna kastats <?= $rounds ?> gång<?= $plural ?>.</p>

<?php if (count($diceGame->getCurrentRoll()) > 0) : ?>
    <p>De senaste kasten (gjorda av <?php
    if ($rounds > 0) {
        echo $diceGame->getCurrentPlayer();
    } elseif ($rounds === 0) {
        echo $diceGame->getOtherPlayer();
    }
    ?>) är:</p>
    <ul>
        <li><?php
        $x = implode(", ", $diceGame->getCurrentRoll());
        echo $x; ?>
    </li>
    </ul>
    <p><strong>Histogram</strong></p>
    <pre><?= $diceGame->getAsText($diceGame->getAllRolls()) ?></pre>

<?php endif; ?>

<!-- <?php
echo "SESSION";
var_dump($_SESSION);

?> -->
