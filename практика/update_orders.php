<?php
session_start();
require_once('../практика/db.php');


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: autor.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    // Проходим по каждому статусу заказа
    foreach ($_POST['status'] as $orderId => $status) {
        // Подготовка и выполнение запроса на обновление статуса заказа
        $query = "UPDATE orders SET status = \$1 WHERE id = \$2";
        $result = pg_query_params($conn, $query, array($status, $orderId));
        
        if (!$result) {
            // Обработка ошибок, если запрос не выполнен
            echo "Ошибка обновления статуса для заказа ID: $orderId";
        }
    }
}


header('Location: admin.php');
exit();
?>
