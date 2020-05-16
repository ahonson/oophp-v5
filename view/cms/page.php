<?php

namespace Anax\View;

namespace arts19\CMS;

$filter = new MyTextFilter();

$latest = $filter->esc($resultset[0]->updated) ? $filter->esc($resultset[0]->updated) : $filter->esc($resultset[0]->created);
?>

<article>
    <header>
        <h2><?= $filter->esc($resultset[0]->title) ?></h2>
        <p><i>Latest update: <time datetime="<?= $latest ?>" pubdate><?= $latest ?></time></i></p>
    </header>
    <?= $filter->parse($resultset[0]->data, $resultset[0]->filter) ?>
</article>
