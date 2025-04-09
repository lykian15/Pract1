<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить студента</title>
    <link rel="stylesheet" href="../сайтпракт/css/index.css">
</head>
<body>
    <header>
        <div class="logo_text">Учёт успеваемости</div>
        <nav class="menu">
            <a href="index.php">Главная</a>
            <a href="add_student.php">Добавить студента</a>
            <a href="add_grade.php">Добавить оценку</a>
        </nav>
    </header>

    <main>
        <h1>Добавить нового студента</h1>
        <form method="POST" action="">
            <label>Фамилия: <input type="text" name="last_name" required></label>
            <label>Имя: <input type="text" name="first_name" required></label>
            <label>Отчество: <input type="text" name="middle_name"></label>
            <label>Курс: <input type="number" name="course" min="1" max="4" required></label>
            <button type="submit" name="add_student">Добавить</button>
        </form>

        <?php
        if (isset($_POST['add_student'])) {
            $last_name = pg_escape_string($_POST['last_name']);
            $first_name = pg_escape_string($_POST['first_name']);
            $middle_name = pg_escape_string($_POST['middle_name']);
            $course = (int)$_POST['course'];

            $query = "INSERT INTO students (last_name, first_name, middle_name, course) 
                      VALUES ('$last_name', '$first_name', '$middle_name', $course)";
            $result = pg_query($conn, $query);

            if ($result) {
                echo "<p>Студент успешно добавлен!</p>";
            } else {
                echo "<p>Ошибка: " . pg_last_error($conn) . "</p>";
            }
        }
        ?>
    </main>
</body>
</html>