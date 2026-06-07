<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/helper.php';
require __DIR__ . '/articleController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$url = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

Define('PROJECT_FOLDER', '/cw');
$projectFolder = PROJECT_FOLDER;


if (strpos($url, $projectFolder) === 0) {
    $url = substr($url, strlen($projectFolder));
}

if ($url === '') {
    $url = '/';
}
$controller = new PageController();

// Главная
if($url === '/'){

    $controller->home();

    exit;
}

// Обо мне
if($url === '/about'){

    $controller->about();

    exit;
}

// Hello
if(
    preg_match(
        '#^/hello/(.+)$#',
        $url,
        $matches
    )
){

    $controller->hello(
        $matches[1]
    );

    exit;
}

// Bye
if(
    preg_match(
        '#^/bye/(.+)$#',
        $url,
        $matches
    )
){

    $controller->bye(
        $matches[1]
    );

    exit;
}


$articleController = new ArticleController();

if ($url === '/card/create')
{
    $articleController->create();
    exit;
}

if (
    preg_match(
        '#^/card/(\d+)$#',
        $url,
        $matches
    )
)
{
    $articleController->show(
        (int)$matches[1]
    );

    exit;
}