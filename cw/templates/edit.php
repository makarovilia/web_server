<?php

$content = '

<div class="card shadow-sm">

    <div class="card-body">

        <h2 class="mb-4">Редактирование статьи</h2>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="' . htmlspecialchars($article['title']) . '"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Текст</label>
                <textarea
                    name="text"
                    class="form-control"
                    rows="6"
                >' . htmlspecialchars($article['text']) . '</textarea>
            </div>

            <button class="btn btn-primary">
                Сохранить
            </button>

        </form>

    </div>

</div>

';

require __DIR__ . '/layout.php';