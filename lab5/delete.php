<?php

require_once 'db.php';

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $stmt = $db->prepare("
        SELECT surname
        FROM contacts
        WHERE id=?
    ");

    $stmt->execute([$id]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if($contact)
    {
        $surname = $contact['surname'];

        $stmt = $db->prepare("
            DELETE FROM contacts
            WHERE id=?
        ");

        $stmt->execute([$id]);

        echo "
        <div class='success'>
            Запись с фамилией
            {$surname}
            удалена
        </div>
        ";
    }
}

$stmt = $db->query("
    SELECT *
    FROM contacts
    ORDER BY surname,name
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    $n = mb_substr($row['name'],0,1);
    $l = mb_substr($row['lastname'],0,1);

    echo "
    <div>
        <a href='index.php?page=delete&id={$row['id']}'>
            {$row['surname']} {$n}.{$l}.
        </a>
    </div>
    ";
}