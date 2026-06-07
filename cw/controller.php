<?php

require_once __DIR__ . '/view.php';

class PageController
{
    // Главная страница
    public function home(): void
{
    global $pdo;

    $cards = $pdo->query(
        'SELECT *
        FROM cards
        WHERE status = \'published\'
        ORDER BY id DESC'
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

    public function register(): void
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users(login, password, role)
                VALUES (?, ?, 'user')
            ");

            $stmt->execute([$login, $password]);

            header('Location: ' . url('login'));
            exit;
        }

        View::render('register', [
            'title' => 'Регистрация'
        ]);
    }

    public function login(): void
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $stmt = $pdo->prepare("
                SELECT * FROM users WHERE login = ?
            ");

            $stmt->execute([$_POST['login']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];

                header('Location: ' . url(''));
                exit;
            }

            echo "Неверный логин или пароль";
            return;
        }

        View::render('login', [
            'title' => 'Вход'
        ]);
    }
}