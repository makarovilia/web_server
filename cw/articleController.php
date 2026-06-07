<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/view.php';

class ArticleController
{
public function show(int $id): void
{
    global $pdo;

    

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
    $user = currentUser();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!$user) {
            echo "Только авторизованные пользователи могут оставлять комментарии";
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO comments(user_id, card_id, text)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $user['id'],
            $id,
            $_POST['text']
        ]);
        header('Location: ' . url('card/' . $id));
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT
            comments.*,
            users.login
        FROM comments
        JOIN users
            ON users.id = comments.user_id
        WHERE comments.card_id = ?
    ");

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

    $user = currentUser();

    if (!$user) {
        echo "Только авторизованные пользователи могут создавать карточки";
        exit;
    };

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
                __DIR__ . '/uploads/' .
                $fileName;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $imagePath
            );
        }

        $status = "pending";
        $imagePath = $imagePath
            ? 'cw/uploads/' . $fileName
            : null;

        $stmt = $pdo->prepare(
            'INSERT INTO cards
             (title, text, image, status)
             VALUES (?, ?, ?, ?)'
        );

        $stmt->execute([
            $_POST['title'],
            $_POST['text'],
            $imagePath,
            $status
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


public function pending(): void
{
    global $pdo;

    requireRole(['moderator']);

    $stmt = $pdo->query("
        SELECT * FROM cards
        WHERE status = 'pending'
        ORDER BY id DESC
    ");

    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    View::render('pendingCards', [
        'cards' => $cards,
        'title' => 'Модерация'
    ]);
}
public function publish(int $id): void
{
    global $pdo;

    requireRole(['moderator']);

    $stmt = $pdo->prepare("
        UPDATE cards
        SET status = 'published'
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    header('Location: ' . url('card/pending'));
    exit;
}
public function delete(int $id): void
{
    global $pdo;

    requireRole(['moderator']);

    $stmt = $pdo->prepare("
        DELETE FROM cards WHERE id = ?
    ");

    $stmt->execute([$id]);

    header('Location: ' . url(''));
    exit;
}
}