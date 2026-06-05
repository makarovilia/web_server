<?php

function getMenu()
{
    $page = $_GET['page'] ?? 'view';
    $sort = $_GET['sort'] ?? 'id';

    $items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '<div class="header">';

    foreach($items as $key => $value)
    {
        $class = ($page == $key) ? 'select' : '';

        $html .= "
            <a class='$class'
               href='index.php?page=$key'>
                $value
            </a>
        ";
    }

    $html .= '</div>';

    if($page == 'view')
    {
        $html .= '<div class="submenu">';

        $sorts = [
            'id' => 'По добавлению',
            'surname' => 'По фамилии',
            'date' => 'По дате рождения'
        ];

        foreach($sorts as $key => $value)
        {
            $class = ($sort == $key) ? 'select' : '';

            $html .= "
                <a class='$class'
                   href='index.php?page=view&sort=$key'>
                    $value
                </a>
            ";
        }

        $html .= '</div>';
    }

    return $html;
}