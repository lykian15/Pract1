<?php
session_start();
require_once('../практика/db.php');


if (!isset($_SESSION['user'])) {
    header('Location: autor.php');
    exit();
}



$userData = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $date = $_POST['date']; // Исправлено: использовано правильное имя поля
    $time = $_POST['time']; // Исправлено: использовано правильное имя поля
    $service_type = $_POST['service_type'];
    $method_pay = $_POST['radio-group']; // Исправлено: используем правильное имя поля для способа оплаты


    if ($service_type == 'Иная услуга' && !empty($_POST['other_service'])) {
        $service_type = $_POST['other_service']; // Берем текст из поля "Иная услуга"
    }


    $status = 'в обработке';
    // Определяем цену в зависимости от выбранного типа услуги
    if ($service_type == 'Уборка') {
        $price = 1000;
    } else if ($service_type == 'Стирка') {
        $price = 1500;
    } else if ($service_type == 'Чистка') {
        $price = 2000;
    } else {
        $price = 3000;
    }

    if (empty($error) && !preg_match('/^8\d{10}$/', $phone)) {
        $error = "Телефон должен быть в формате: 89003330033.";
    }

    $query = "INSERT INTO orders (user_id, address, order_date, order_time, service_type, method_pay, price, status) VALUES (\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8)";

    $result = pg_query_params($conn, $query, array($userData['id'], $address, $date, $time, $service_type, $method_pay, $price, $status));

    if ($result) {
        header('Location: zacaz.php'); 
        exit();
    } else {
        $error = "Ошибка: " . pg_last_error($conn);
        echo $error;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заказа</title>
    <link rel="stylesheet" href="../практика/assets/style.css">
</head>

<body>
    <header>
        <div>
            <img src="../практика/assets/img/images.png" alt="Логотип">
            <span style="font-size: 24px; margin-left: 10px;">Создание заказа</span>
        </div>
        <button class="logout-button" onclick="logout()">Выход</button>
    </header>

    <div class="registration-container">
        <h3>Формирование заявки</h3>
        <form method="POST">
            <label for="address">Адрес:<span class="star">*</span></label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Номер телефона:<span class="star">*</span></label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Дата:<span class="star">*</span></label>
            <input type="date" id="date" name="date" required>

            <label for="time">Время:<span class="star">*</span></label>
            <input type="time" id="time" name="time" required>

            <label for="service_type">Вид услуги:<span class="star">*</span></label>
            <select id="service_type" name="service_type" required>
                <option value="" disabled selected>Выберите услугу</option>
                <option value="Уборка">Уборка</option>
                <option value="Стирка">Стирка</option>
                <option value="Чистка">Чистка</option>
                <option value="Иная услуга">Иная услуга</option>
            </select>

            <div class="radio-group">
                <label>Если иная услуга:</label>
                <input type="radio" id="other_service_radio" name="other_service_radio" value="yes">
                <label for="other_service_radio">Иная услуга</label>
                <input type="text" id="other_service" name="other_service" placeholder="Укажите вид услуги" style="display:none;">
            </div>
            <label>Способ оплаты:<span class="star">*</span></label>
            <div class="radio-group">
                <select id="radio-group" name="radio-group" required>
                    <option value="" disabled selected>Способ оплаты</option>
                    <option value="Карта">Карта</option>
                    <option value="Наличные">Наличные</option>
                </select>
            </div>

            <input type="submit" value="Отправить заявку">
        </form>
        <a href="zacaz.php">Отмена</a>
    </div>

    <script>
        const otherServiceRadio = document.getElementById('other_service_radio');
        const otherServiceInput = document.getElementById('other_service');

        otherServiceRadio.addEventListener('change', function() {
            if (this.checked) {
                otherServiceInput.style.display = 'block';
            } else {
                otherServiceInput.style.display = 'none';
            }
        });
    </script>
</body>

</html>