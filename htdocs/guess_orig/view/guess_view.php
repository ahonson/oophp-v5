<?php  ?>

<body>
<main>
<h1>Guess my number (POST)</h1>
<p>Guess a number between 1 and 100, you have <?= $counter ?> guess<?= $plural ?> left.</p>

<form method="post" action="process.php">
    <input type="number" name="guess" autofocus
    <?php if ($counter < 1 || $res === "CORRECT") { echo "readonly";
    } ?>
    >
    <input type="submit" name="submit" value="Make a guess"
    <?php if ($counter < 1 || $res === "CORRECT") { echo "disabled";
    } ?>
    >
    <input type="submit" name="reset" value="Reset game">
    <input type="submit" name="cheat" value="Cheat"
    <?php if ($counter < 1 || $res === "CORRECT") { echo "disabled";
    } ?>
    >
</form>

<?php
if (isset($_SESSION["res"])) : ?>
<p>Your guess: <?= $guess ?> is <strong><?= $res ?></strong>.</p>
<?php endif; ?>

<?php
if (isset($_SESSION["cheat"])) : ?>
<p>The secret number is: <strong><?= $number ?></strong>.</p>
<?php endif; ?>

<?php
if (isset($_SESSION["except"])) : ?>
<p><?= $_SESSION["except"] ?></p>
<?php endif; ?>

</main>
</body>
</html>
