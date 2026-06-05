<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/view.php';

class ArticleController
{
    public function show(int $id): void
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT a.title, a.text, u.nickname
            FROM articles a
            JOIN users u ON u.id = a.user_id
            WHERE a.id = :id
        ");

        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        global $pdo;
        if (!$article) {
            echo "Статья не найдена";
            return;
        }

        View::render('article', [
            'title' => $article['title'],
            'text' => $article['text'],
            'author' => $article['nickname']
        ]);
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