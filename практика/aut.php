<?php
session_start();
require_once('db.php');

$login = trim($_POST['login']);
$password = $_POST['password'];


if ($login === 'Adminka' && $password === 'admin') {
    $_SESSION['user'] = [
        "role" => "admin"
    ];
    header('Location: admin.php'); 
    exit(); 
}


$query = "SELECT * FROM users WHERE login = \$1";
$result = pg_query_params($conn, $query, array($login));

if ($result) {
    if (pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);

        
        if ($password === $user['password']) {
            $_SESSION['user'] = [
                "id" => $user['id'],
                "role" => "user"
            ];
            header('Location: zacaz.php');
            exit();
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Неверный логин.";
    }
} else {
    echo "Ошибка выполнения запроса: " . pg_last_error($conn);
}

pg_close($conn);
?>
