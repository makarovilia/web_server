<?php

$content = '';

if (empty($cards))
{
    $content .= '

    <div class="alert alert-warning">

        Пока нет ни одной карточки

    </div>';
}
else{
    foreach ($cards as $card)
    {
        $content .= '
    
        <div class="card mb-3">
    
            <div class="card-body">
    
                <h5 class="card-title">'
                    . htmlspecialchars($card['title']) .
                '</h5>
    
                <p class="card-text">'
                    . htmlspecialchars(
                        mb_substr(
                            $card['text'],
                            0,
                            100
                        )
                    ) .
                '...</p>
    
                <a
                    href="' . url('card/' . $card['id']) . '"
                    class="btn btn-primary"
                >
                    Подробнее
                </a>
    
            </div>
    
        </div>';
    }
}

require __DIR__ . '/layout.php';