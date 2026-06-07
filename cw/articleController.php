<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/view.php';

class ArticleController
{
public function show(int $id): void
{
    global $pdo;
    if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $stmt = $pdo->prepare(
            'INSERT INTO comments(card_id, author, text)
             VALUES(?, ?, ?)'
    );

        $stmt->execute([
            $id,
            $_POST['author'],
            $_POST['text']
        ]);

        header(
            'Location: ' .
            url('card/' . $id)
        );
        exit;}

    $stmt = $pdo->prepare(
        'SELECT * FROM cards WHERE id = ?'
    );

    $stmt->execute([$id]);

    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$card)
    {
        echo 'Карточка не найдена';
        return;
    }

    $stmt = $pdo->prepare(
        'SELECT * FROM comments WHERE card_id = ?'
    );

    $stmt->execute([$id]);

    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    View::render(
        'card',
        [
            'title' => $card['title'],
            'card' => $card,
            'comments' => $comments
        ]
    );
}

public function create(): void
{
    global $pdo;
    if (
        !empty($_FILES['image']['name']) &&
        $_FILES['image']['error'] !== UPLOAD_ERR_OK
    )
    {
        View::render(
            'createCard',
            [
                'title' => 'Создание карточки',
                'error' => 'Не удалось загрузить изображение'
            ]
        );

        return;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $uploadDir = 'uploads/';

        $imagePath = null;

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        )
        {
            $fileName =
                time() . '_' .
                basename(
                    $_FILES['image']['name']
                );

            $imagePath =
                $uploadDir .
                $fileName;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $imagePath
            );
        }

        $stmt = $pdo->prepare(
            'INSERT INTO cards
             (title, text, image)
             VALUES (?, ?, ?)'
        );

        $stmt->execute([
            $_POST['title'],
            $_POST['text'],
            $imagePath,
        ]);

        header(
            'Location: ' .
            url('')
        );

        exit;
    }

    View::render(
        'createCard',
        [
            'title' => 'Создание карточки'
        ]
    );
}
    public function edit(int $id): void
{
    global $pdo;

    // если отправили форму
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = $_POST['title'] ?? '';
        $text  = $_POST['text'] ?? '';

        $stmt = $pdo->prepare("
            UPDATE articles
            SET title = :title,
                text = :text
            WHERE id = :id
        ");

        $stmt->execute([
            'title' => $title,
            'text'  => $text,
            'id'    => $id
        ]);

        header("Location: /lab7/article/$id");
        exit;
    }

    // иначе просто показываем форму
    $stmt = $pdo->prepare("
        SELECT a.title, a.text, u.nickname
        FROM articles a
        JOIN users u ON u.id = a.user_id
        WHERE a.id = :id
    ");

    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        echo "Статья не найдена";
        return;
    }

    View::render('edit', [
        'title' => 'Редактирование статьи',
        'article' => $article,
        'text' => $article['text'],
        'author' => $article['nickname']
    ]);
}

}