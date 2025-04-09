<?php
session_start()
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой Не Сам</title>
    <link rel="stylesheet" href="../практика/assets/style.css">
</head>
<body>

<div class="registration-container">
    <h2>Регистрация</h2>
    <form action="reg.php" method="post">
        <label for="surname">Фамилия<span class="star">*</span>:</label>
        <input type="text" id="surname" name="surname" required>

        <label for="name">Имя<span class="star">*</span>:</label>
        <input type="text" id="name" name="name" required>

        <label for="patronymic">Отчество:</label>
        <input type="text" id="patronymic" name="patronymic">

        <label for="phone">Номер телефона<span class="star">*</span>:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="email">Email<span class="star">*</span>:</label>
        <input type="email" id="email" name="email" required>

        <label for="login">Логин<span class="star">*</span>:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Пароль<span class="star">*</span>:</label>
        <input type="password" id="password" name="password" minlength="6" required>

        <input type="submit" value="Зарегистрироваться">
    </form>
</div>
</body>
</html>
