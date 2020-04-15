<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // echo "init the session for starting the game";

    if (!isset($_SESSION["guess"])) {
        $_SESSION["guess"] = new arts19\Guess\Guess();
        $_SESSION["number"] = $_SESSION["guess"]->random();
    }
    // $game = new arts19\Guess\Guess();
    return $app->response->redirect("guess/play");
});



/**
 * Play the game
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    if (!isset($_SESSION["guess"])) {
        $_SESSION["guess"] = new arts19\Guess\Guess();
        $_SESSION["number"] = $_SESSION["guess"]->random();
    }

    $title = "Play my game";

    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["current_guess"] ?? null;

    $counter = $_SESSION["guess"]->tries();
    if ($counter !== 1) {
        $plural = "es";
    } else {
        $plural = "";
    }
    $number = $_SESSION["guess"]->number();


    $data = [
        "who" => "mumintrollet",
        "counter" => $_SESSION["guess"]->tries(),
        "plural" => $plural,
        "res" => $res,
        "guess" => $guess,
        "number" => $number
    ];


    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("guess/process.php", function () use ($app) {
    // echo "Some debugging information";

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
            } catch (arts19\Guess\GuessException $e) {
                echo "Got exception: " . get_class($e) . "<hr>";
                $_SESSION["except"] = $e->errorMessage();
            }
        }
    }

    if (isset($_POST["reset"])) {
        session_destroy();
    }

    if (isset($_POST["cheat"])) {
        $_SESSION["cheat"] = $_SESSION["guess"]->number();
    }


    return $app->response->redirect("guess/play");
});
