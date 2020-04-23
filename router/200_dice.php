<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init/{arg}", function ($arg) use ($app) {
    echo "init the session for starting the game" . $arg;
    $_SESSION["dice"] = new arts19\Dice\DiceGame(intval($arg));
    return $app->response->redirect("dice/play");
});

/**
 * Play the game
 */
$app->router->get("dice/play", function () use ($app) {
    // echo "Some debugging information";
    // $x = new Anax\Session\Session;
    // $x->set("apa", "banan");
    // $x->destroy();

    $data = [
        "player" => $_SESSION["dice"]->getScorePlayer1(),
        "computer" => $_SESSION["dice"]->getScorePlayer2(),
        "currentPlayer" => $_SESSION["dice"]->getCurrentPlayer(),
        "currentScore" => $_SESSION["dice"]->getCurrentRound(),
        "rounds" => $_SESSION["dice"]->getNrOfRounds(),
        // "x" => $x
    ];

    $app->page->add("dice/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => "Dice 100",
    ]);
});

$app->router->post("dice/process.php", function () use ($app) {
    // echo "Some debugging information";
    if (isset($_POST["reset"])) {
        session_destroy();
        return $app->response->redirect("dice100");
    } elseif (isset($_POST["submit"])) {
        $_SESSION["dice"]->roll();
    } elseif (isset($_POST["save"])) {
        $_SESSION["dice"]->quitCurrentRound();
    }

    return $app->response->redirect("dice/play");
});
