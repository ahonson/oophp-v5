<?php

require __DIR__ . "/src/autoload.php";
require __DIR__ . "/src/config.php";

session_name("guessing_game");
session_start();

if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
    $_SESSION["number"] = $_SESSION["guess"]->random();
}

// if (isset($_SESSION["res"])) {
//     $res = $_SESSION["res"];
//     $guess = $_SESSION["current_guess"];
// }

$res = $_SESSION["res"] ?? null;
$guess = $_SESSION["current_guess"] ?? null;

$counter = $_SESSION["guess"]->tries();
if ($counter !== 1) {
    $plural = "es";
} else {
    $plural = "";
}
$number = $_SESSION["guess"]->number();

// echo "-----------------------------------------";
// echo "<br>Counter: ";
// var_dump($counter);
// echo "<br>Number: ";
// var_dump($number);
// echo "<br>SESSION: ";
// var_dump($_SESSION);
// echo "<br>guess: ";
// var_dump($guess);
// echo "<br>res: ";
// var_dump($res);
// echo "<br>";
// echo "-----------------------------------------";

require __DIR__ . "/view/header.php";


require __DIR__ . "/view/guess_view.php";
