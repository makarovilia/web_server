<?php

class View
{
    public static function render(
        string $template,
        array $data = []
    ): void
    {
        // Превращаем массив в переменные
        extract($data);

        // Подключаем шаблон
        require __DIR__ . '/templates/' . $template . '.php';
    }
}