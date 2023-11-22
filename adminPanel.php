<?php
require_once("db.php"); // Подключение к базе данных



// Обработка формы добавления кружка
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addClub"])) {
    $clubName = $_POST["clubName"];

    // Вставка данных в базу данных
    $insertQuery = "INSERT INTO clubs (ClubName) VALUES ('$clubName')";
    if ($conn->query($insertQuery) === TRUE) {
        $successMessage = "Кружок успешно добавлен!";
    } else {
        $errorMessage = "Ошибка при добавлении кружка: " . $conn->error;
    }
}



// Получение данных о кружках из базы данных
$clubsQuery = "SELECT * FROM clubs";
$result = $conn->query($clubsQuery);

// Получение идентификатора кружка для удаления
$clubID = $_POST["clubID"];

// Удаление кружка из базы данных
$deleteQuery = "DELETE FROM clubs WHERE ClubID=$clubID";
if ($conn->query($deleteQuery) === TRUE) {
    $successMessage = "Кружок успешно удален!";
} else {
    $errorMessage = "Ошибка при удалении кружка: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Админ-панель</h2>

    <!-- Форма добавления кружка -->
    <form action="adminPanel.php" method="post">
        <label for="clubName">Название кружка:</label>
        <input type="text" id="clubName" name="clubName" required>
        <button type="submit" name="addClub">Добавить кружок</button>
    </form>

    <!-- Сообщения об успехе или ошибке -->
    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <!-- Таблица существующих кружков -->
    <h3>Список кружков:</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название кружка</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["ClubID"]; ?></td>
                    <td><?php echo $row["ClubName"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <form action="adminPanel.php" method="post">
    <label for="clubID">ID кружка:</label>
    <input type="number" id="clubID" name="clubID" required>
    <button type="submit" name="deleteClub">Удалить кружок</button>
</form>
</body>
</html>

<?php
// Закрытие соединения с базой данных
$conn->close();
?>