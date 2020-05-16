<?php

namespace Anax\View;

?>

<h2>Skapa nytt innehåll</h2>

<p>Här kan du skapa nytt innehåll och spara det i databasen.</p>

<p <?= $warning !== "" ? "class='danger'" : null ?>><?= $warning ?></p>

<form method="post">
    <fieldset>
    <legend>Create</legend>
    <!-- <input type="hidden" name="contentId" value=""/>
 -->
    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= $contentTitle ?>"/>
        </label>
    </p>

    <!-- <p>
        <label>Path:<br>
        <input type="text" name="contentPath" value=""/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" value=""/>
    </p> -->

    <p>
        <label>Text:<br>
        <textarea name="contentData"><?= $contentData ?></textarea>
    </p>

     <p>
        <label>Type:<br>
        <select name="contentType">
            <option value="page">page</option>
            <option value="post">post</option>
        </select>
     </p>

     <p>
         <label>Filter (BEWARE: markdown is not compatible with nl2br and link)</label><br>
         <input type="checkbox" id="bbcode" name="bbcode" value="bbcode">
         <label for="bbcode"> BBCODE</label><br>
         <input type="checkbox" id="link" name="link" value="link">
         <label for="link"> LINK</label><br>
         <input type="checkbox" id="markdown" name="markdown" value="markdown">
         <label for="markdown"> MARKDOWN</label><br>
         <input type="checkbox" id="nl2br" name="nl2br" value="nl2br">
         <label for="nl2br"> NL2BR</label><br>
        <!-- <label>Filter:<br>
        <select name="contentFilter">
            <option value="bbcode">bbcode</option>
            <option value="link">link</option>
            <option value="markdown">markdown</option>
            <option value="nl2br">nl2br</option>
        </select> -->
    </p>

    <p>
        <label>Publish:<br>
        <input type="date" name="contentPublish" value=""/>
    </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <!-- <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button> -->
    </p>
    </fieldset>
</form>
