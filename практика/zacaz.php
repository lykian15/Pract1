<?php
session_start();
require_once('../практика/db.php');


if (!isset($_SESSION['user'])) {
    header('Location: autor.php');
    exit();
}


$user_id = $_SESSION['user']['id'];


$query = "SELECT * FROM orders WHERE user_id = \$1 ORDER BY order_date DESC";
$result = pg_query_params($conn, $query, array($user_id));


if (!$result) {
    echo "Ошибка выполнения запроса: " . pg_last_error($conn);
    exit();
}


$orders = pg_fetch_all($result);
pg_close($conn); 
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
    <header>
        <div>
            <img src="../практика/assets/img/images.png" alt="Логотип">
            <span style="font-size: 24px; margin-left: 10px;">Мой Не Сам</span>
        </div>
        <button class="logout-button" onclick="logout()">Выход</button>
    </header>

    <div class="container">
        <h2>История заказов</h2>
        <table>
            <thead>
                <tr>
                    <th>№</th>
                    <th>Вид услуги</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders): ?>
                    <?php $count = 1; ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo htmlspecialchars($order['service_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['price']) . ' руб.'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Нет заказов.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="new-order">
            <p>Оставьте новую заявку:</p>
            <button onclick="location.href='create_order.php'" class="but">Оставить заявку</button>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = 'autor.php';
        }
    </script>
</body>

</html>