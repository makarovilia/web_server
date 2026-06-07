<?php $user = currentUser(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">

    <title>
        <?= $title ?? 'SOCIALSOLVER' ?>
    </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/style.css">

</head>

<body class="bg-dark text-light" data-bs-theme="dark">

<div class="wrapper container py-4">

    <!-- HEADER -->
    <header class="mb-4">

        <div class="d-flex align-items-center gap-3 p-3 bg-body-tertiary rounded shadow-sm">

            <img
                src="/lab7-10/templates/logo.png"
                alt="logo"
                style="width: auto; height: 50px;"
            >

            <h1 class="h4 m-0">
                SOCIALSOLVER
            </h1>

        </div>

    </header>

    <div class="row">

        <!-- MAIN -->
        <main class="col-lg-8">

            <div class="p-4 rounded shadow-sm bg-body-tertiary">

                <?= $content ?>

            </div>

        </main>

        <!-- SIDEBAR -->
        <aside class="col-lg-4">

            <div class="p-3 rounded shadow-sm bg-body-tertiary">

                <h3 class="h5 mb-3">Меню</h3>

                <ul class="list-group">

                    <li class="list-group-item bg-transparent">
                        <a class="text-decoration-none text-light" href="<?= url('') ?>">
                            Главная
                        </a>
                    </li>
                    <?php if (!$user): ?>

                        <li class="list-group-item bg-transparent"><a class="text-decoration-none text-light" href="<?= url('login') ?>">Вход</a></li>
                        <li class="list-group-item bg-transparent"><a class="text-decoration-none text-light" href="<?= url('register') ?>">Регистрация</a></li>

                    <?php else: ?>

                        <li class="list-group-item bg-transparent"><a class="text-decoration-none text-light" href="<?= url('card/create') ?>">Создать карточку</a></li>

                        <li class="list-group-item bg-transparent">
                            <a class="text-decoration-none text-light" href="<?= url('logout') ?>">
                                Выйти (<?= htmlspecialchars($user['login']) ?>)
                            </a>
                        </li>

                        <?php if ($user['role'] === 'moderator'): ?>

                            <li class="list-group-item bg-transparent">
                                <a class="text-decoration-none text-light" href="<?= url('card/pending') ?>">
                                    Модерация
                                </a>
                            </li>
                        <?php endif; ?>

                     <?php endif; ?>
                    <li class="list-group-item bg-transparent">
                        <a class="text-decoration-none text-light" href="<?= url('about') ?>">
                            Обо мне
                        </a>
                    </li>

                </ul>

            </div>

        </aside>

    </div>

    <!-- FOOTER -->
    <footer class="text-center mt-4 text-secondary">
        Все права защищены
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>