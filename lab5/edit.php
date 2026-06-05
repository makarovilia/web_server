<?php

require_once 'db.php';

$id = $_GET['id'] ?? null;

$contacts = $db->query("
    SELECT *
    FROM contacts
    ORDER BY surname,name
")->fetchAll(PDO::FETCH_ASSOC);

if(!$contacts)
{
    echo "Нет записей";
    return;
}

if(!$id)
{
    $id = $contacts[0]['id'];
}

if(isset($_POST['button']))
{
    $stmt = $db->prepare("
        UPDATE contacts
        SET
            surname=?,
            name=?,
            lastname=?,
            gender=?,
            date=?,
            phone=?,
            location=?,
            email=?,
            comment=?
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['surname'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['gender'],
        $_POST['date'],
        $_POST['phone'],
        $_POST['location'],
        $_POST['email'],
        $_POST['comment'],
        $_POST['id']
    ]);

    echo "<div class='success'>Запись обновлена</div>";

    $id = $_POST['id'];
}

$stmt = $db->prepare("
    SELECT *
    FROM contacts
    WHERE id=?
");

$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<div class='div-edit'>";

foreach($contacts as $contact)
{
    $class = '';

    if($contact['id'] == $id)
    {
        $class = 'currentRow';
    }

    echo "
        <div class='$class'>
            <a href='index.php?page=edit&id={$contact['id']}'>
                {$contact['surname']} {$contact['name']}
            </a>
        </div>
    ";
}

echo "</div>";

$button = "Сохранить";

include 'templates/form.php';