<?php

namespace Anax\View;

namespace arts19\MyTextFilter;

$filter = new MyTextFilter();

if (!$resultset) {
    return;
}

?>

<article>

<?php foreach ($resultset as $row) : ?>
    <section>
        <header>
            <h1><a href="blog/<?= $filter->esc($row->slug) ?>"><?= $filter->esc($row->title) ?></a></h1>
            <p><i>Published: <time datetime="<?= $filter->esc($row->published_iso8601) ?>" pubdate><?= $filter->esc($row->published) ?></time></i></p>
        </header>
        <?= $filter->esc($row->data) ?>
    </section>
<?php endforeach; ?>

</article>
