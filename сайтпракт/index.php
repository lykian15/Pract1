<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учёт успеваемости студентов</title>
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
        <h1>Успеваемость студентов</h1>

        <!-- Фильтрация -->
        <form method="GET" action="index.php">
            <label>Студент:
                <select name="student_id">
                    <option value="">Все студенты</option>
                    <?php
                    $students_query = pg_query($conn, "SELECT * FROM students ORDER BY last_name");
                    while ($student = pg_fetch_assoc($students_query)) {
                        $selected = ($_GET['student_id'] == $student['student_id']) ? 'selected' : '';
                        echo "<option value='{$student['student_id']}' $selected>{$student['last_name']} {$student['first_name']}</option>";
                    }
                    ?>
                </select>
            </label>
            <label>Предмет:
                <select name="subject_id">
                    <option value="">Все предметы</option>
                    <?php
                    $subjects_query = pg_query($conn, "SELECT * FROM subjects ORDER BY name");
                    while ($subject = pg_fetch_assoc($subjects_query)) {
                        $selected = ($_GET['subject_id'] == $subject['subject_id']) ? 'selected' : '';
                        echo "<option value='{$subject['subject_id']}' $selected>{$subject['name']}</option>";
                    }
                    ?>
                </select>
            </label>
            <button type="submit">Фильтровать</button>
        </form>

        <!-- Таблица с оценками -->
        <table class="tab-results">
            <thead>
                <tr>
                    <th>Студент</th>
                    <th>Курс</th>
                    <th>Предмет</th>
                    <th>Преподаватель</th>
                    <th>Оценка</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
                    SELECT 
                        s.last_name || ' ' || s.first_name AS student_name,
                        s.course,
                        sub.name AS subject_name,
                        t.last_name || ' ' || t.first_name || ' ' || t.middle_name AS teacher_name,
                        g.grade,
                        g.date
                    FROM grades g
                    JOIN students s ON g.student_id = s.student_id
                    JOIN subjects sub ON g.subject_id = sub.subject_id
                    JOIN teachers t ON sub.teacher_id = t.teacher_id
                    WHERE 1=1
                ";

                if (!empty($_GET['student_id'])) {
                    $sql .= " AND s.student_id = " . (int)$_GET['student_id'];
                }

                if (!empty($_GET['subject_id'])) {
                    $sql .= " AND sub.subject_id = " . (int)$_GET['subject_id'];
                }

                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) {
                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['student_name']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['subject_name']}</td>
                            <td>{$row['teacher_name']}</td>
                            <td>{$row['grade']}</td>
                            <td>{$row['date']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Нет данных для отображения</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>