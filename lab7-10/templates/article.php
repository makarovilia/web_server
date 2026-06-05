<?php

$content = '

    <h2>
        ' . $title . '
    </h2>

    <p>
        ' . $text . '
    </p>

    <hr>

    <p>
        Автор статьи:
        <strong>' . $author . '</strong>
    </p>

';

require __DIR__ . '/layout.php';