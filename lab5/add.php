<?php

require_once 'db.php';

$row = [
    'surname' => '',
    'name' => '',
    'lastname' => '',
    'gender' => '',
    'date' => '',
    'phone' => '',
    'location' => '',
    'email' => '',
    'comment' => ''
];

$button = 'Добавить';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $stmt = $db->prepare("
        INSERT INTO contacts
        (
            surname,
            name,
            lastname,
            gender,
            date,
            phone,
            location,
            email,
            comment
        )
        VALUES
        (
            ?,?,?,?,?,?,?,?,?
        )
    ");

    if($stmt->execute([
        $_POST['surname'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['gender'],
        $_POST['date'],
        $_POST['phone'],
        $_POST['location'],
        $_POST['email'],
        $_POST['comment']
    ]))
    {
        echo "<div class='success'>Запись добавлена</div>";
    }
    else
    {
        echo "<div class='error'>Ошибка добавления</div>";
    }
}

include 'templates/form.php';