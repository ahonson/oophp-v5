<?php

namespace Anax\View;

if (is_numeric(substr($_SERVER["REQUEST_URI"], -1, 1))) {
    $myPath = "../";
} else {
    $myPath = "";
}
?>

<h1 class="movieheader">My Movie Database</h1>

<navbar class="movieNavbar">
    <a href="<?= $myPath ?>showall">Show all</a>
    <!-- <a href="?route=reset">Reset database</a> | -->
    <a href="<?= $myPath ?>searchtitle">Search title</a>
    <a href="<?= $myPath ?>searchyear">Search year</a>
    <a href="<?= $myPath ?>crud">CRUD</a>
    <a href="<?= $myPath ?>reset">Reset DB</a>
<!--    <a href="?route=movie-edit">Edit</a> | -->
    <!-- <a href="?route=show-all-sort">Show all sortable</a> |
    <a href="?route=show-all-paginate">Show all paginate</a> | -->
</navbar>
