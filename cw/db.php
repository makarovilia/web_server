<?php

$pdo = new PDO(
    'sqlite:' . __DIR__ . '/db.db'
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>