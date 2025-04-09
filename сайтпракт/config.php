<?php

$host = 'localhost';
$db = 'pract1';
$user = '';
$password = '';

$conn = pg_connect("host=$host port = 5432 dbname=$db user=$user password=$password");

if (!$conn) {
    die("Ошибка подключения к базе данных: " . pg_last_error());
}
?>