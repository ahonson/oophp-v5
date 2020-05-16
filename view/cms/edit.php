<?php

namespace Anax\View;

namespace arts19\CMS;

$filter = new MyTextFilter();

?>

<h2>Redigera <?= $resultset[0]->type ?> med ID nr <?= $resultset[0]->id ?></h2>

<p <?= $warning !== "" ? "class='danger'" : null ?>><?= $warning ?></p>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentPath" value="<?= $resultset[0]->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= $resultset[0]->title ?>"/>
        </label>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData"><?= $filter->esc($resultset[0]->data, $resultset[0]->filter) ?></textarea>
    </p>

     <p>
        <label>Type:<br>
        <select name="contentType">
            <option value="page" <?= $resultset[0]->type === "page" ? "selected" : null ?>>page</option>
            <option value="post" <?= $resultset[0]->type === "post" ? "selected" : null ?>>post</option>
        </select>
     </p>

     <p>
         <label>Filter (BEWARE: markdown is not compatible with nl2br and link)</label><br>
         <input type="checkbox" id="bbcode" name="bbcode" value="bbcode" <?= is_numeric(strpos($resultset[0]->filter, "bbcode")) ? "checked" : null ?>>
         <label for="bbcode"> BBCODE</label><br>
         <input type="checkbox" id="link" name="link" value="link" <?= is_numeric(strpos($resultset[0]->filter, "link")) ? "checked" : null ?>>
         <label for="link"> LINK</label><br>
         <input type="checkbox" id="markdown" name="markdown" value="markdown" <?= is_numeric(strpos($resultset[0]->filter, "markdown")) ? "checked" : null ?>>
         <label for="markdown"> MARKDOWN</label><br>
         <input type="checkbox" id="nl2br" name="nl2br" value="nl2br" <?= is_numeric(strpos($resultset[0]->filter, "nl2br")) ? "checked" : null ?>>
         <label for="nl2br"> NL2BR</label><br>
    </p>

    <p>
        <label>Publish:<br>
        <input type="date" name="contentPublish" value=""/>
    </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
    </p>
    </fieldset>
</form>
