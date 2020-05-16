<?php

namespace arts19\CMS;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CMSController implements AppInjectableInterface
{
    use AppInjectableTrait;

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
        $session = $this->app->session;
        $session->set("loginStatus", new Login());
        // Deal with the action and return a response.
        $response = $this->app->response;
        return $response->redirect("cms/showall");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function logoutAction() : object
    {
        $session = $this->app->session;
        $session->get("loginStatus")->logout();
        // Deal with the action and return a response.
        $response = $this->app->response;
        return $response->redirect("cms/index");
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
        $session = $this->app->session;
        $page = $this->app->page;

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/showall", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function crudAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;
        $response = $this->app->response;

        if (!$session->get("loginStatus")->isLoggedIn()) {
            return $response->redirect("cms/showall");
        }
        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/crud", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function adminActionGet() : object
    {
        // Deal with the action and return a response.
        $session = $this->app->session;
        $page = $this->app->page;

        $data = [
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        $page->add("cms/header", $data);
        $page->add("cms/admin", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function adminActionPost() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;
        $response = $this->app->response;
        $request = $this->app->request;

        $username = $request->getPost("username");
        $password = $request->getPost("password");

        $this->app->db->connect();
        $sql = "SELECT * FROM usertable;";
        $users = $this->app->db->executeFetchAll($sql);

        $data = [
            "users" => $users,
            "username" => $username,
            "password" => $password,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        if ($session->get("loginStatus")->loginSuccess($data)) {
            return $response->redirect("cms/crud");
        } else {
            $page->add("cms/header", $data);
            $page->add("cms/admin");
            $page->add("cms/footer");

            return $page->render([
                "title" => "My CMS",
            ]);
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
    public function pagesAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $this->app->db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type = 'page' AND deleted IS NULL;
EOD;
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/pages", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function blogsAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $this->app->db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type = 'post' AND deleted IS NULL
ORDER BY published DESC
;
EOD;
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/blogs", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function blogAction($slug) : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE slug = '$slug'";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/blog", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function pageAction($title) : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE title = '$title'";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/page", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function deleteActionGet($id) : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        if (!$session->get("loginStatus")->isLoggedIn()) {
            return $response->redirect("cms/showall");
        }


        $page = $this->app->page;

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE id = '$id'";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/delete", $data);
        $page->add("cms/showall", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function deleteActionPost($id) : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        // $session = $this->app->session;

        $save = $request->getPost("doSave") ? $request->getPost("doSave") : null;

        if ($save) {
            $itemId = $id; // $request->getPost("movieId");

            $this->app->db->connect();
            $sql = "UPDATE content SET deleted = CURRENT_TIMESTAMP WHERE id = '$itemId';";
            $this->app->db->executeFetchAll($sql);
        }

        return $response->redirect("cms/showall");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function editActionGet($id) : object
    {
        // Deal with the action and return a response.
        $session = $this->app->session;
        $response = $this->app->response;

        if (!$session->get("loginStatus")->isLoggedIn()) {
            return $response->redirect("cms/showall");
        }

        $this->app->db->connect();
        $sql = "SELECT * FROM content WHERE id = $id;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
            "warning" => "",
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        $page = $this->app->page;
        $page->add("cms/header", $data);
        $page->add("cms/edit", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function editActionPost($id) : object
    {
        // Deal with the action and return a response.
        $response = $this->app->response;
        $request = $this->app->request;
        $session = $this->app->session;
        $page = $this->app->page;

        $filter = new MyTextFilter();

        $this->app->db->connect();
        $sql = "SELECT COUNT(type) AS allblogs FROM content WHERE type = 'post';";
        $number = $this->app->db->executeFetchAll($sql);
        $sql = "SELECT * FROM content WHERE id != $id;";
        $res0 = $this->app->db->executeFetchAll($sql);
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);
        $warning = "Titeln och texten får inte lämnas tomma. Varje titel måste vara unik.";

        $title = $request->getPost("contentTitle");
        $contentData = $request->getPost("contentData");
        $type = $request->getPost("contentType");
        $slug = $filter->getSlug($type, $title);
        $path = $filter->getUpdatedPath($type, $title, ($number[0]->allblogs));

        $data = [
            "contentTitle" => $title,
            "contentData" => $contentData,
            "resultset" => $res0,
            "slug" => $slug,
            "path" => $path,
            "number" => $number,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        $noDuplicate = $filter->checkPathAndSlug($data);

        if ($title === "" || $contentData === "" || !$noDuplicate) {
            $data["warning"] = $warning;
            $data["noDuplicate"] = $noDuplicate;
            $page->add("cms/header", $data);
            $page->add("cms/edit", $data);
            $page->add("cms/footer");

            return $page->render([
                "title" => "My CMS",
            ]);
        }

        $data["resultset"] = $res;
        $chosenFilters = $request->getPost("bbcode") ? $request->getPost("bbcode") . "," : "";
        $chosenFilters .= $request->getPost("link") ? $request->getPost("link") . "," : "";
        $chosenFilters .= $request->getPost("markdown") ? $request->getPost("markdown") . "," : "";
        $chosenFilters .= $request->getPost("nl2br") ? $request->getPost("nl2br") : "";

        $contentData = $filter->strip($contentData);
        $contentData = $filter->esc($contentData);
        if ($slug) {
            $sql = "UPDATE content SET title = '$title', data = \"$contentData\", type = '$type', slug = '$slug', `path` = '$path', filter = '$chosenFilters' WHERE id = $id;";
        } else {
            $sql = "UPDATE content SET title = '$title', data = \"$contentData\", type = '$type', slug = NULL, `path` = '$path', filter = '$chosenFilters' WHERE id = $id;";
        }
        $this->app->db->executeFetchAll($sql);

        return $response->redirect("cms/showall");
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
        $session = $this->app->session;
        $page = $this->app->page;
        $response = $this->app->response;

        if (!$session->get("loginStatus")->isLoggedIn()) {
            return $response->redirect("cms/showall");
        }

        $data = [
            "contentTitle" => "",
            "contentData" => "",
            "warning" => "",
            "noDuplicate" => false,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        // Deal with the action and return a response.
        $page->add("cms/header", $data);
        $page->add("cms/add", $data);
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
    public function addActionPost() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;
        $request = $this->app->request;

        $filter = new MyTextFilter();

        $contentType = $request->getPost("contentType");
        $contentTitle = $request->getPost("contentTitle");
        $contentData = $request->getPost("contentData");
        $contentData = $filter->strip($contentData);
        $contentData = $filter->esc($contentData);
        $contentPublish = $request->getPost("contentPublish");
        $warning = "Titeln och texten får inte lämnas tomma. Varje titel måste vara unik.";

        $this->app->db->connect();
        $sql = "SELECT COUNT(type) AS allblogs FROM content WHERE type = 'post';";
        $number = $this->app->db->executeFetchAll($sql);
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $slug = $filter->getSlug($contentType, $contentTitle);
        $path = $filter->getPath($contentType, $contentTitle, $number[0]->allblogs);
        $data = [
            "contentTitle" => $contentTitle,
            "contentData" => $contentData,
            "resultset" => $res,
            "slug" => $slug,
            "path" => $path,
            "number" => $number,
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        $noDuplicate = $filter->checkPathAndSlug($data);

        if ($contentTitle === "" || $contentData === "" || !$noDuplicate) {
            $data["warning"] = $warning;
            $data["noDuplicate"] = $noDuplicate;
            $page->add("cms/header", $data);
            $page->add("cms/add", $data);
            $page->add("cms/footer");

            return $page->render([
                "title" => "My CMS",
            ]);
        }
        $chosenFilters = $request->getPost("bbcode") ? $request->getPost("bbcode") . "," : "";
        $chosenFilters .= $request->getPost("link") ? $request->getPost("link") . "," : "";
        $chosenFilters .= $request->getPost("markdown") ? $request->getPost("markdown") . "," : "";
        $chosenFilters .= $request->getPost("nl2br") ? $request->getPost("nl2br") : "";

        $sql = $filter->getSQL($path, $slug, $contentType, $contentPublish, $contentTitle, $contentData, $chosenFilters);
        $res = $this->app->db->executeFetchAll($sql);

        $data["resultset"] = $res;

        $response = $this->app->response;
        return $response->redirect("cms/showall");
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
        $session = $this->app->session;
        $response = $this->app->response;

        if (!$session->get("loginStatus")->isLoggedIn()) {
            return $response->redirect("cms/showall");
        }

        $data = [
            "loginStatus" => $session->get("loginStatus")->isLoggedIn()
        ];

        $page->add("cms/header", $data);
        $page->add("cms/reset");
        $page->add("cms/footer");

        return $page->render([
            "title" => "My CMS",
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
            $command = "mysql -hblu-ray.student.bth.se -uarts19 -pFHvy4Gx85J6E arts19 < ../sql/content/setup.sql 2>&1";
        } else {
            $command = "mysql -uuser -ppass oophp < ../sql/content/setup.sql 2>&1";
        }

        $output = [];
        $status = null;
        exec($command, $output, $status);

        return $response->redirect("cms/showall");
    }
}
