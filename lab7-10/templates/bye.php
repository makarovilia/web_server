<?php

$content = '

    <h2>
        Прощание
    </h2>

    <p>
        Пока, ' . htmlspecialchars($name) . '
    </p>

';

require __DIR__ . '/layout.php';