<?php

namespace Anax\View;

namespace arts19\MyTextFilter;

$filter = new MyTextFilter();

$text1 = file_get_contents(__DIR__ . "/../../texter/bbcode.txt");
$bbcfilter = $filter->parse($text1, ["bbcode", "nl2br"]);

$text2 = file_get_contents(__DIR__ . "/../../texter/sample.md");
$mdfilter = $filter->parse($text2, ["markdown"]);
$nl2brmdfilter = $filter->parse($text2, ["nl2br", "markdown"]);

$text3 = file_get_contents(__DIR__ . "/../../texter/clickable.txt");
$linkfilter = $filter->parse($text3, ["link"]);

?>
<h1>Så här fungerar mina textfilter</h1>

<p><code>parse($text, [$filter1, $filter2, ...])</code> är en publik metod inom klassen MyTextFilter. Den bearbetar den första parametern och returnerar en sträng utifrån filtren i den andra parametern. Man får olika utslag beroende av antalet filter samt filtrens inbördes ordning. Varje element i arrayen måste anta ett av följande värden:</p>
<ul>
    <li>bbcode</li>
    <li>link</li>
    <li>markdown</li>
    <li>nl2br</li>
</ul>

<h2>Ursprungstexten för bbcode + nl2br</h2>
<p><?= $filter->esc($text1) ?></p>

<h2>BBCODE + NL2BR</h2>
<div><?= $bbcfilter ?></div>

<h2>Ursprungstexten för markdown</h2>
<p><?= $filter->esc($text2) ?></p>

<h2>MARKDOWN</h2>
<div><?= $mdfilter ?></div>

<h2>NL2BR + MARKDOWN (krockar med varandra)</h2>
<div><?= $nl2brmdfilter ?></div>

<h2>Ursprungstexten för link</h2>
<p><?= $filter->esc($text3) ?></p>

<h2>LINK</h2>
<div><?= $linkfilter ?></div>
