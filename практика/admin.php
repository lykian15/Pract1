<?php
session_start();
require_once('../практика/db.php');

// Проверка на администратора
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: autor.php');
    exit();
}

// Получение всех заказов из базы данных
$query = "SELECT orders.id, 
                 CONCAT(users.surname, ' ', users.name, ' ', users.patronymic) AS full_name, 
                 orders.service_type, 
                 users.phone, 
                 orders.address, 
                 orders.order_date, 
                 orders.order_time, 
                 orders.status, 
                 orders.price, 
                 orders.method_pay 
          FROM orders 
          JOIN users ON orders.user_id = users.id";
$result = pg_query($conn, $query);
$orders = pg_fetch_all($result);

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заказами</title>
    <link rel="stylesheet" href="../практика/assets/style.css">
</head>

<body>
    <header>
        <div>
            <img src="../практика/assets/img/images.png" alt="Логотип">
            <span style="font-size: 24px; margin-left: 10px;">Мой Не Сам</span>
        </div>
        <button class="logout-button" onclick="logout()">Выход</button>
    </header>

    <div class="container">
        <h2>История заказов</h2>
        <form method="POST" action="update_orders.php">
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>ФИО пользователя</th>
                        <th>Телефон</th>
                        <th>Адрес</th>
                        <th>Вид услуги</th>
                        <th>Дата заказа</th>
                        <th>Время заказа</th>
                        <th>Статус</th>
                        <th>Цена</th>
                        <th>Способ оплаты</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders): ?>
                        <?php $count = 1; ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['address']); ?></td>
                                <td><?php echo htmlspecialchars($order['service_type']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_time']); ?></td>
                                <td>
                                    <select name="status[<?php echo $order['id']; ?>]"> <!-- Изменено для отправки статусов по id -->
                                        <option value="в обработке" <?php echo $order['status'] === 'в обработке' ? 'selected' : ''; ?>>В обработке</option>
                                        <option value="выполнен" <?php echo $order['status'] === 'выполнен' ? 'selected' : ''; ?>>Выполнен</option>
                                        <option value="отказ" <?php echo $order['status'] === 'отказ' ? 'selected' : ''; ?>>Отказ</option>
                                    </select>
                                </td>
                                <td><?php echo htmlspecialchars($order['price']) . ' руб.'; ?></td>
                                <td><?php echo htmlspecialchars($order['method_pay']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Нет заказов.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="save-changes">
                <button type="submit" class="but_ad">Сохранить изменения</button>
            </div>
        </form>
    </div>

    <script>
        function logout() {
            window.location.href = 'autor.php';
        }
    </script>
</body>

</html>
