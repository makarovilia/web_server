<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Хэштеги</title>
</head>
<body>

<h2>Непривязанные хэштеги</h2>

<?php foreach ($tags as $tag): ?>

    <div>

        <strong>
            #<?= htmlspecialchars($tag['name']) ?>
        </strong>

        <form method="post" action="?action=attach">

            <input
                type="hidden"
                name="tag_id"
                value="<?= $tag['id'] ?>"
            >

            <select name="field_id">

                <?php foreach ($fields as $field): ?>

                    <option value="<?= $field['id'] ?>">
                        <?= htmlspecialchars($field['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <button type="submit">
                Привязать
            </button>

        </form>

    </div>

<?php endforeach; ?>

<hr>

<h2>Привязанные хэштеги</h2>

<?php if (empty($assignedTags)): ?>

    <p>Привязанных хэштегов пока нет.</p>

<?php else: ?>

    <table border="1" cellpadding="5">

        <tr>
            <th>Хэштег</th>
            <th>Область знаний</th>
        </tr>

        <?php foreach ($assignedTags as $item): ?>

            <tr>
                <td>#<?= htmlspecialchars($item['hashtag']) ?></td>
                <td><?= htmlspecialchars($item['field_name']) ?></td>
            </tr>

        <?php endforeach; ?>

    </table>

<?php endif; ?>

<hr>

<h3>Новая область знаний</h3>

<form method="post" action="?action=createField">

    <input
        type="text"
        name="name"
        required
    >

    <button type="submit">
        Создать
    </button>

</form>
<h3>Новый хэштег</h3>
<form method="post" action="?action=createTag">
    <input type="text" name="name" placeholder="Хэштег">
    <button type="submit">Добавить</button>
</form>

</body>
</html>