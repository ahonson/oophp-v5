<?php

namespace Anax\View;

if ($_SESSION["dice"]->rounds === 1) {
    $plural = "";
} else {
    $plural = "er";
}

?>
<h1>Tärningsspelet 100</h1>
<p>Spelaren har <?= $player ?> poäng.</p>
<p>Datorn har <?= $computer ?> poäng.</p>

<?php
if ($_SESSION["dice"]->getScorePlayer1() > 99 || $_SESSION["dice"]->getScorePlayer2() > 99) {
    echo "<h2>Spelet är slut, " . $_SESSION["dice"]->getOtherPlayer() . " har vunnit.</h2>";
    echo "<a href='../dice100'>Spela igen.</a>";
    die();
}
?>

<h2>Det är <?= $currentPlayer ?>s tur.</h2>

<form method="post" action="process.php">
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

<?php if (count($_SESSION["dice"]->getCurrentRoll()) > 0) : ?>
    <p>De senaste kasten (gjorda av <?php
    if ($rounds > 0) {
        echo $_SESSION["dice"]->getCurrentPlayer();
    } elseif ($rounds === 0) {
        echo $_SESSION["dice"]->getOtherPlayer();
    }
    ?>) är:</p>
    <ul>
        <li><?php
        $x = implode(", ", $_SESSION["dice"]->getCurrentRoll());
        echo $x; ?>
    </li>
    </ul>
<?php endif; ?>

<!-- <?php
echo "SESSION";
var_dump($_SESSION);

?> -->
