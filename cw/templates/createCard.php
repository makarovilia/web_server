<?php

if (!empty($error))
{
    $content .= '

    <div class="alert alert-danger">

        ' . htmlspecialchars($error) . '

    </div>';
}

$content = '

<h2>
    Создание карточки
</h2>

<form
    method="POST"
    enctype="multipart/form-data"
>

    <div class="mb-3">

        <input
            type="text"
            name="title"
            class="form-control"
            placeholder="Название"
        >

    </div>

    <div class="mb-3">

        <textarea
            name="text"
            class="form-control"
            placeholder="Описание"
        ></textarea>

    </div>

    <div class="mb-3">

        <input
            type="file"
            name="image"
            class="form-control"
        >

    </div>

    <button
        class="btn btn-primary"
    >
        Создать
    </button>

</form>

';

require __DIR__ . '/layout.php';