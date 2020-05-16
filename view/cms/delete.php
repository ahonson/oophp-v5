<?php

namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Delete</legend>
    <input type="hidden" name="itemId" value="<?= $resultset[0]->id ?>"/>
    <p>Are you sure you you want to delete this <?= $resultset[0]->type ?>?</p>
    <p>
        <input type="submit" name="doSave" value="Delete">
        <input type="submit" name="noSave" value="NOOO!!">
    </p>
    </fieldset>
</form>
