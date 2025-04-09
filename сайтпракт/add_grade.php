<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить оценку</title>
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
        <h1>Добавить оценку</h1>
        <form method="POST" action="">
            <label>Студент:
                <select name="student_id" required>
                    <?php
                    $students = pg_query($conn, "SELECT * FROM students ORDER BY last_name");
                    while ($student = pg_fetch_assoc($students)) {
                        echo "<option value='{$student['student_id']}'>{$student['last_name']} {$student['first_name']}</option>";
                    }
                    ?>
                </select>
            </label>
            <label>Предмет:
                <select name="subject_id" required>
                    <?php
                    $subjects = pg_query($conn, "SELECT * FROM subjects ORDER BY name");
                    while ($subject = pg_fetch_assoc($subjects)) {
                        echo "<option value='{$subject['subject_id']}'>{$subject['name']}</option>";
                    }
                    ?>
                </select>
            </label>
            <label>Оценка:
                <select name="grade" required>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                </select>
            </label>
            <button type="submit" name="add_grade">Добавить</button>
        </form>

        <?php
        if (isset($_POST['add_grade'])) {
            $student_id = (int)$_POST['student_id'];
            $subject_id = (int)$_POST['subject_id'];
            $grade = (int)$_POST['grade'];

            $query = "INSERT INTO grades (student_id, subject_id, grade) 
                      VALUES ($student_id, $subject_id, $grade)";
            $result = pg_query($conn, $query);

            if ($result) {
                echo "<p>Оценка успешно добавлена!</p>";
            } else {
                echo "<p>Ошибка: " . pg_last_error($conn) . "</p>";
            }
        }
        ?>
    </main>
</body>
</html>