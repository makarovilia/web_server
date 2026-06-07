<?php

require_once __DIR__ . '/view.php';

class PageController
{
    // Главная страница
    public function home(): void
{
    global $pdo;

    $cards = $pdo->query(
        'SELECT * FROM cards'
    )->fetchAll(PDO::FETCH_ASSOC);

    View::render(
        'home',
        [
            'title' => 'Главная',
            'cards' => $cards
        ]
    );
}

    // Страница обо мне
    public function about(): void
    {
        View::render(
            'about',
            [
                'title' => 'Обо мне'
            ]
        );
    }

    // Страница приветствия
    public function hello(
        string $name
    ): void
    {
        View::render(
            'hello',
            [
                'title' => 'Страница приветствия',

                'name' => $name
            ]
        );
    }

    // Страница прощания
    public function bye(
        string $name
    ): void
    {
        View::render(
            'bye',
            [
                'title' => 'Прощание',

                'name' => $name
            ]
        );
    }
}