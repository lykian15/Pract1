<?php
session_start();

require_once('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $phone = (int)$_POST['phone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    $error='';

    if (empty($error) && !preg_match('/^8\d{10}$/', $phone)) {
        $error = "Телефон должен быть в формате: 89003330033.";
    }

    if(empty($error)){

        $query = "INSERT INTO users (surname, name, patronymic, email, phone, login, password) VALUES ($1, $2, $3, $4, $5, $6, $7)";

        $result = pg_query_params($conn, $query, array($surname, $name, $patronymic, $email, $phone, $login, $password));

        if ($result){
            header('Location: autor.php');
        } else {
            $error = "Ошибка: " . pg_last_error($conn);
        }
    }
    if (!empty($error)) {
        echo "<p>$error</p>";
    }

}
pg_close($conn);
?>