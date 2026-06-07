<?php

$content = '';

foreach ($cards as $card)
{
    $content .= '

    <div class="card mb-2">
        <div class="card-body">

            <h5>' . htmlspecialchars($card['title']) . '</h5>

            <a class="btn btn-success"
               href="' . url('card/' . $card['id'] . '/publish') . '">
               Опубликовать
            </a>

        </div>
    </div>';
}

require __DIR__ . '/layout.php';