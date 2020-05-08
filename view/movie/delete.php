<?php

namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Delete</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>
    <p>Are you sure you you want to delete this film?</p>
    <p>
        <input type="submit" name="doSave" value="Delete">
        <input type="submit" name="noSave" value="NOOO!!">
    </p>
    <p>
        <a href="../crud">Delete another movie</a> |
        <a href="../showall">Show all</a>
    </p>
    </fieldset>
</form>
