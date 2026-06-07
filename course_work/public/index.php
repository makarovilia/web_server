<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';

require_once __DIR__ . '/../models/Tag.php';
require_once __DIR__ . '/../models/Field.php';
require_once __DIR__ . '/../models/TagField.php';

require_once __DIR__ . '/../controllers/TagController.php';

$controller = new TagController();

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'attach':
        $controller->attach();
        break;

    case 'createField':
        $controller->createField();
        break;

    case 'createTag':
        $controller->createTag();
        break;
    default:
        $controller->index();
    
}