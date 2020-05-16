<?php

namespace Anax\View;

if (is_numeric(substr($_SERVER["REQUEST_URI"], -1, 1)) ||
    strpos($_SERVER["REQUEST_URI"], '/blog/') !== false ||
    strpos($_SERVER["REQUEST_URI"], '/page/') !== false) {
    $myPath = "../";
} else {
    $myPath = "";
}
?>

<h1 class="movieheader">Mitt Content Management System</h1>

<navbar class="cmsNavbar">
    <a href="<?= $myPath ?>showall">Show all</a>
    <a href="<?= $myPath ?>pages">View pages</a>
    <a href="<?= $myPath ?>blogs">View blog</a>
<?php if (!$loginStatus) { ?>
    <a href="<?= $myPath ?>admin">Admin</a>
<?php } else { ?>
    <a href="<?= $myPath ?>crud">CRUD</a>
    <a href="<?= $myPath ?>reset">Reset DB</a>
    <a href="<?= $myPath ?>logout">Logout</a>
<?php } ?>
</navbar>
