<?php

namespace arts19\Movie;

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
class MovieController implements AppInjectableInterface
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
        $response = $this->app->response;
        return $response->redirect("movie/showall");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function showallAction() : object
    {
        // Deal with the action and return a response.

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res
        ];

        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/show_all", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function searchtitleAction() : object
    {
        // Deal with the action and return a response.
        $request = $this->app->request;
        $page = $this->app->page;

        $this->app->db->connect();
        $searchPhrase = $request->getGet("searchTitle", null) ? $request->getGet("searchTitle") : "";
        $sql = "SELECT * FROM movie WHERE title LIKE '" . $searchPhrase . "';";
        $res = $this->app->db->executeFetchAll($sql);


        $data = [
            "searchTitle" => $request->getGet("searchTitle"),
            "resultset" => $res
        ];
        $page->add("movie/header");
        $page->add("movie/search_title", $data);
        $page->add("movie/show_all", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function searchyearAction() : object
    {
        // Deal with the action and return a response.
        $request = $this->app->request;
        $page = $this->app->page;

        $this->app->db->connect();
        $year1 = $request->getGet("year1") ? $request->getGet("year1") : 1900;
        $year2 = $request->getGet("year2") ? $request->getGet("year2") : 2100;
        $sql = "SELECT * FROM movie WHERE year >= $year1 AND year <= $year2;";
        $res = $request->getGet("doSearch") ? $this->app->db->executeFetchAll($sql) : null;

        $data = [
            "year1" => $year1,
            "year2" => $year2,
            "resultset" => $res
        ];
        $page->add("movie/header");
        $page->add("movie/search_year", $data);
        $page->add("movie/show_all", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function crudActionGet() : object
    {
        // Deal with the action and return a response.

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "movies" => $res
        ];


        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/crud", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function crudActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        // $session = $this->app->session;

        $add = $request->getPost("doAdd");
        $edit = $request->getPost("doEdit");
        $delete = $request->getPost("doDelete");
        $movieId = $request->getPost("movieId") ? $request->getPost("movieId") : null;


        if ($add) {
            return $response->redirect("movie/add");
        } elseif (!$movieId) {
            return $response->redirect("movie/crud");
        } elseif ($edit) {
            return $response->redirect("movie/edit/${movieId}");
        } elseif ($delete) {
            return $response->redirect("movie/delete/${movieId}");
        }
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function editActionGet($numb) : object
    {
        // Deal with the action and return a response.

        $this->app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = $numb;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "movie" => $res[0]
        ];


        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/edit", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function addActionGet() : object
    {
        // Deal with the action and return a response.

        $data = [
            "movie" => (object) [
                "id" => 0,
                "title" => "A title",
                "year" => 2017,
                "image" => "img/noimage.png"
            ]
        ];


        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/create", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function deleteActionGet($numb) : object
    {
        // Deal with the action and return a response.

        $this->app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = $numb;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "movie" => $res[0],
            "resultset" => $res
        ];


        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/delete", $data);
        $page->add("movie/show_all", $data);
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function editActionPost($numb) : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        // $session = $this->app->session;

        $save = $request->getPost("doSave") ? $request->getPost("doSave") : null;

        if ($save) {
            $movieId = $numb; // $request->getPost("movieId");
            $movieTitle = $request->getPost("movieTitle");
            $movieYear = $request->getPost("movieYear");
            $movieImage = $request->getPost("movieImage");

            $this->app->db->connect();
            $sql = "UPDATE movie SET title = '$movieTitle', year = '$movieYear', image = '$movieImage' WHERE id = '$movieId';";
            $this->app->db->executeFetchAll($sql);
        }

        return $response->redirect("movie/showall");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function addActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        // $session = $this->app->session;

        $save = $request->getPost("doSave") ? $request->getPost("doSave") : null;

        if ($save) {
            $movieTitle = $request->getPost("movieTitle");
            $movieYear = $request->getPost("movieYear");
            $movieImage = $request->getPost("movieImage");

            $this->app->db->connect();
            $sql = "INSERT INTO movie (title, year, image) VALUES ('$movieTitle', '$movieYear', '$movieImage');";
            $this->app->db->executeFetchAll($sql);
        }

        return $response->redirect("movie/showall");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function deleteActionPost($numb) : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        // $session = $this->app->session;

        $save = $request->getPost("doSave") ? $request->getPost("doSave") : null;

        if ($save) {
            $movieId = $numb; // $request->getPost("movieId");

            $this->app->db->connect();
            $sql = "DELETE FROM movie WHERE id = '$movieId';";
            $this->app->db->executeFetchAll($sql);
        }

        return $response->redirect("movie/showall");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        // Deal with the action and return a response.

        $page = $this->app->page;
        $page->add("movie/header");
        $page->add("movie/reset");
        $page->add("movie/footer");

        return $page->render([
            "title" => "Filmdatabas",
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
    public function resetActionPost() : object
    {
        $response = $this->app->response;

        if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
            $command = "mysql -hblu-ray.student.bth.se -uarts19 -pFHvy4Gx85J6E arts19 < ../sql/movie/setup.sql 2>&1";
        } else {
            $command = "mysql -uuser -ppass oophp < ../sql/movie/setup.sql 2>&1";
        }

        $output = [];
        $status = null;
        exec($command, $output, $status);

        return $response->redirect("movie/showall");
    }
}
