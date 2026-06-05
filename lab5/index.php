<?php include "templates/header.php"; ?>
<main>

<?php

require_once 'menu.php';

echo getMenu();

$page = $_GET['page'] ?? 'view';

switch($page)
{
    case 'add':
        require 'add.php';
        break;

    case 'edit':
        require 'edit.php';
        break;

    case 'delete':
        require 'delete.php';
        break;

    default:
        require 'viewer.php';
        echo showContacts(
            $_GET['sort'] ?? 'id',
            $_GET['p'] ?? 1
        );
}

?>  
</main>
<?php include "templates/footer.php"; ?>