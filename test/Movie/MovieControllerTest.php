<?php

namespace arts19\Movie;

// use Anax\Controller\SampleAppController;
use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class MovieControllerTest extends TestCase
{
    private $controller;
    private $app;

    /**
    * Setup the controller before each testcase, just like the router would set it up
    */
    protected function setUp(): void
    {
        global $di;
        // init sevvice container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        // create and initiate the Controller
        $this->controller = new MovieController();
        $this->controller->setApp($app);
    }

    /**
    * Call the controller index action
    */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }



    // /**
    // * Call the controller showall action
    // */
    // public function testShowallAction()
    // {
    //     $res = $this->controller->showallAction();
    //     $this->assertInstanceOf(ResponseUtility::class, $res);
    // }


    // /**
    // * Call the controller process action POST
    // */
    // public function testProcessActionPost()
    // {
    //     $this->app->request->setGlobals([
    //         "post" => [
    //             // "reset" => 1111,
    //             // "save" => 2,
    //             "submit" => 3,
    //         ]
    //     ]);
    //     $res = $this->controller->processActionPost();
    //     $this->assertInstanceOf(ResponseUtility::class, $res);
    //
    //     $this->app->request->setGlobals([
    //         "post" => [
    //             // "reset" => 1111,
    //             "save" => 2,
    //             // "submit" => 3,
    //         ]
    //     ]);
    //     $res = $this->controller->processActionPost();
    //     $this->assertInstanceOf(ResponseUtility::class, $res);
    //
    //     $this->app->request->setGlobals([
    //         "post" => [
    //             "reset" => 1111,
    //             // "save" => 2,
    //             // "submit" => 3,
    //         ]
    //     ]);
    //     $res = $this->controller->processActionPost();
    //     $this->assertInstanceOf(ResponseUtility::class, $res);
    // }
}
