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
    <h2>Вход в систему</h2>
    <h3><a href="../практика/regist.php">Регистрация</a></h3>
    <form action="aut.php" method="post">
        <label for="login">Логин<span class="star">*</span>:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Пароль<span class="star">*</span>:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Войти">
    </form>
</div>

</body>
</html>
