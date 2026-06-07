<?php

require_once __DIR__ . '/db.php';

function currentUser(): ?array
{
    global $pdo;

    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $stmt = $pdo->prepare("
        SELECT id, login, role
        FROM users
        WHERE id = ?
    ");

    $stmt->execute([$_SESSION['user_id']]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
function requireRole(array $roles): void
{
    $user = currentUser();

    if (!$user || !in_array($user['role'], $roles)) {
        echo "Доступ запрещён";
        exit;
    }
}