<?php

class DB
{
    private static ?PDO $pdo = null;

    public static function conn(): PDO
    {
        if (self::$pdo === null) {
            $dbPath = __DIR__ . '/db.db';

            self::$pdo = new PDO('sqlite:' . $dbPath);

            self::$pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            self::$pdo->exec('PRAGMA foreign_keys = ON');
        }

        return self::$pdo;
    }
}