<?php
if (!empty($card['image']))
{
    $content .= '

    <img
        src="/' .
        htmlspecialchars(
            $card['image']
        ) .
        '"
        class="img-fluid mb-3"
    >';
}
$content = '

<div class="card shadow-sm">

    <div class="card-body">

        <h2>'
        . htmlspecialchars($card['title']) .
        '</h2>

        <p>'
        . nl2br(
            htmlspecialchars(
                $card['text']
            )
        ) .
        '</p>

    </div>

</div>

<h3 class="mt-4">
    Комментарии
</h3>
';


foreach($comments as $comment)
{
    $content .= '

    <div class="card mt-2">

        <div class="card-body">

            <strong>'
            . htmlspecialchars($comment['author']) .
            '</strong>

            <p class="mb-0">'
            . htmlspecialchars($comment['text']) .
            '</p>

        </div>

    </div>';
}

$content .= '

<form method="POST" class="mt-4">

    <input
        type="text"
        name="author"
        class="form-control mb-2"
        placeholder="Ваше имя"
    >

    <textarea
        name="text"
        class="form-control mb-2"
        placeholder="Комментарий"
    ></textarea>

    <button class="btn btn-primary">
        Отправить
    </button>

</form>';