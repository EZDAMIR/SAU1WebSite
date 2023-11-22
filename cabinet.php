<?php
// Подключение к базе данных
require_once("db.php");

session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION["IIN"])) {
    // Если не авторизован, перенаправление на страницу входа
    header("Location: login.php");
    exit();
}

// Проверка, является ли пользователь администратором
if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) {
    // Если администратор, перенаправление на страницу с доступом к админ панели
    header("Location: fullaccesscabinet.php");
    exit();
}

// Остальной код для личного кабинета
$userID = $_SESSION["IIN"];

$message = "";


// Обработка формы изменения данных
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $newFullName = $_POST["newFullName"];
    $newPassword = $_POST["newPassword"];

    // Обновление данных в базе данных
    $updateQuery = "UPDATE users SET name='$newFullName', password='$newPassword' WHERE IIN=$userID";

    if ($conn->query($updateQuery) === TRUE) {
        $message = "Данные успешно обновлены";
    } else {
        $message = "Ошибка при обновлении данных: " . $conn->error;
    }
}

// Обработка формы записи на кружок
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enroll"])) {
    $selectedCircleID = $_POST["selectedCircle"];
    
    // Вставка записи в таблицу, представляющую записи на кружки
    $enrollQuery = "INSERT INTO participants (IIN, ClubID) VALUES ($userID, $selectedCircleID)";

    if ($conn->query($enrollQuery) === TRUE) {
        $message = "Вы успешно записались на кружок!";
    } else {
        $message = "Ошибка при записи на кружок: " . $conn->error;
    }
}

// Получение текущих данных пользователя
$userQuery = "SELECT * FROM users WHERE IIN=$userID";
$result = $conn->query($userQuery);
$userData = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Лого организации</div>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="kruzhki.php">Кружки</a></li>
                <li><a href="raspisanie.php">Расписание</a></li>
				<li><a href="cabinet.php">Личный кабинет</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h2>Личный кабинет</h2>
        <div class="message">
            <?php echo $message; ?>
        </div>

        <h3>Изменить данные</h3>
        <form action="cabinet.php" method="post">
            <label for="newFullName">Новое полное имя:</label>
            <input type="text" id="newFullName" name="newFullName" value="<?php echo $userData["Name"]; ?>" required>

            <label for="newPassword">Новый пароль:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <button type="submit" name="update">Обновить данные</button>
        </form>

        <form action="logout.php" method="post">
        <button type="submit" name="logout">Выйти</button>
        </form>

        <h3>Записаться на кружок</h3>
        <form action="cabinet.php" method="post">
            <!-- Получение доступных кружков из базы данных -->
            <?php
            $circlesQuery = "SELECT * FROM clubs";
            $circlesResult = $conn->query($circlesQuery);

            if ($circlesResult->num_rows > 0) {
                while ($circle = $circlesResult->fetch_assoc()) {
                    echo '<input type="radio" id="circle' . $circle["id"] . '" name="selectedCircle" value="' . $circle["id"] . '" required>';
                    echo '<label for="circle' . $circle["id"] . '">' . $circle["name"] . '</label><br>';
                }
            } else {
                echo "Нет доступных кружков";
            }
            ?>

            <button type="submit" name="enroll">Записаться на кружок</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Организация кружков</p>
    </footer>
</body>
</html>

<?php
// Закрытие соединения с базой данных
$conn->close();
?>