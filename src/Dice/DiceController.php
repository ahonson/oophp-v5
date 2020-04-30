<?php

namespace arts19\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        $page = $this->app->page;
        $page->add("dice1/index");

        return $page->render([
            "title" => "Dice 100",
        ]);
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function initAction($nrOfDices) : object
    {
        $response = $this->app->response;
        $session = $this->app->session;
        // echo "init the session for starting the game" . $arg;
        // $_SESSION["dice"] = new DiceGame(intval(2));
        $session->set("dice", new DiceGame($nrOfDices));
        return $response->redirect("dice1/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function playActionGet() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;

        $data = [
            // "player" => $_SESSION["dice"]->getScorePlayer1(),
            // "computer" => $_SESSION["dice"]->getScorePlayer2(),
            // "currentPlayer" => $_SESSION["dice"]->getCurrentPlayer(),
            // "currentScore" => $_SESSION["dice"]->getCurrentRound(),
            // "rounds" => $_SESSION["dice"]->getNrOfRounds(),
            "player" => $session->get("dice")->getScorePlayer1(),
            "computer" => $session->get("dice")->getScorePlayer2(),
            "currentPlayer" => $session->get("dice")->getCurrentPlayer(),
            "currentScore" => $session->get("dice")->getCurrentRound(),
            "rounds" => $session->get("dice")->getNrOfRounds(),
            "diceGame" => $session->get("dice")
            // "x" => $x
        ];

        $page->add("dice1/play", $data);
        // $this->app->page->add("guess/debug");

        return $page->render([
            "title" => "Dice 100",
        ]);
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function processActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        $reset = $request->getPost("reset");
        $save = $request->getPost("save");
        $submit = $request->getPost("submit");

        // if (isset($_POST["reset"])) {
        if ($reset) {
            // session_destroy();
            $session->destroy();
            return $response->redirect("dice1");
        // } elseif (isset($_POST["submit"])) {
        } elseif ($submit) {
            // $_SESSION["dice"]->roll();
            $session->get("dice")->roll();
        // } elseif (isset($_POST["save"])) {
        } elseif ($save) {
            // $_SESSION["dice"]->quitCurrentRound();
            $session->get("dice")->quitCurrentRound();
        }

        return $response->redirect("dice1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game!!";
    }
}
