<?php

require_once 'db.php';

function showContacts($sort = 'id', $page = 1)
{
    global $db;

    $limit = 10;
    $offset = ($page - 1) * $limit;

    $stmt = $db->query("
        SELECT *
        FROM contacts
        ORDER BY $sort
        LIMIT $limit
        OFFSET $offset
    ");

    $html = '<table>';

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $html .= "
        <tr>
            <td>{$row['surname']}</td>
            <td>{$row['name']}</td>
            <td>{$row['lastname']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['email']}</td>
        </tr>
        ";
    }

    $html .= '</table><br>';

    $count = $db->query(
        "SELECT COUNT(*) FROM contacts"
    )->fetchColumn();

    $pages = ceil($count / 10);

    for($i = 1; $i <= $pages; $i++)
    {
        $html .= "
        <a href='index.php?page=view&sort=$sort&p=$i'>
            $i
        </a>
        ";
    }

    return $html;
}