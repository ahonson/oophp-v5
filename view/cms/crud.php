<?php

namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<p>Här kan du redigera, uppdatera eller radera befintligt innehåll i databasen. Eller klicka <a href="add">här för att lägga till en ny sida eller ett nytt blogginlägg.</a></p>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Titel</th>
        <th>Typ</th>
        <th>Published</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><a href="edit/<?= $row->id ?>">&#x1F4F0;</a></td>
        <td><a href="delete/<?= $row->id ?>">&#x26D4;</a></td>
    </tr>
<?php endforeach; ?>
</table>
