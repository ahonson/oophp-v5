<?php

namespace Anax\View;

namespace arts19\CMS;

$filter = new MyTextFilter();

?>

<article>
    <header>
        <h2><?= $filter->esc($resultset[0]->title) ?></h2>
        <p><i>Published: <time datetime="<?= $filter->esc($resultset[0]->published) ?>" pubdate><?= $filter->esc($resultset[0]->published) ?></time></i></p>
    </header>
    <?= $filter->parse($resultset[0]->data, $resultset[0]->filter) ?>
</article>
