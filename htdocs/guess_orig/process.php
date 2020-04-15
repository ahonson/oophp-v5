<?php

require __DIR__ . "/src/autoload.php";
require __DIR__ . "/src/config.php";

session_name("guessing_game");
session_start();

echo "<h1>PROCESSINGSSIDA</h1>";

if (isset($_POST["submit"])) {
    if ($_POST["guess"] !== "") {
        try {
            $_SESSION["res"] = $_SESSION["guess"]->makeGuess($_POST["guess"]);
            $_SESSION["current_guess"] = $_POST["guess"];
            if (isset($_SESSION["cheat"])) {
                unset($_SESSION["cheat"]);
            }
            if (isset($_SESSION["except"])) {
                unset($_SESSION["except"]);
            }
        } catch (GuessException $e) {
            echo "Got exception: " . get_class($e) . "<hr>";
            $_SESSION["except"] = $e->errorMessage();
        }
    }
}

if (isset($_POST["reset"])) {
    session_destroy();
    // unset($_SESSION["guess"]);
    // unset($_SESSION["res"]);
    // unset($_SESSION["number"]);
    // unset($_SESSION["current_guess"]);
    // unset($_SESSION["cheat"]);
}

if (isset($_POST["cheat"])) {
    $_SESSION["cheat"] = $_SESSION["guess"]->number();
}

header("Location: index.php");
