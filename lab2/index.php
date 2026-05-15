<?php include("templates/header.php")?>
<main>
    <form method="post" action="https://httpbin.org/post" class="form">
        <div class = "mb-3">
            <label class="form-label">Имя пользователя:</label>
            <input type="text" name="username" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email пользователя:</label>
            <input type="email" name="email" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Тип обращения:</label>
            <select required class="form-select">
                <option value="жалоба">Жалоба</option>
                <option value="предложение">Предложение</option>
                <option value="благодарность">Благодарность</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Текст обращения:</label>
            <textarea name="message" required class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Вариант ответа:</label>
            <div>
                <input type="checkbox" value="sms" class="form-check-input"> SMS
                <input type="checkbox" value="email" class="form-check-input"> E-mail
            </div>
        </div>

        <button type="submit" class="btn btn-danger w-100">Отправить</button>
    </form>
    <div class="center">
        <a href="headers.php" class="link btn btn-outline-dark mt-3">Перейти на следующую страницу</a>
    </div>
</main>
<?php include ("templates/footer.php")?>