<?php

$content = '

    <h2>
        Приветствие
    </h2>

    <p>
        Привет, ' . htmlspecialchars($name) . '
    </p>

';

require __DIR__ . '/layout.php';