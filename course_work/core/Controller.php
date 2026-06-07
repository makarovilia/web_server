<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        require dirname(__DIR__) . "/views/$view.php";
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}