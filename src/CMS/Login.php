<?php

namespace arts19\CMS;

/**
 * A class for verification and login status.
 */
class Login
{

    /**
     * Constructor to initiate a login object
     *
     */

    public function __construct()
    {
        $this->loggedIn = false;
    }



    /**
     * verify login data
     * @param object $data
     * @return bool
     */
    public function loginSuccess($data)
    {
        $users = $data["users"];
        $username = $data["username"];
        $password = $data["password"];
        foreach ($users as $user) {
            if ($user->username === $username && $user->password === $password) {
                $this->loggedIn = true;
                return true;
            }
        }
        return false;
    }


    /**
     * return login status
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->loggedIn;
    }


    /**
     * set login status to false
     * @return void
     */
    public function logout()
    {
        $this->loggedIn = false;
    }
}
