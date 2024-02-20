<?php
require_once("db.php");

session_start();

if (!isset($_SESSION["IIN"])) {
  header("Location: login.php");
  exit();
}

if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) {
  header("Location: fullaccesscabinet.php");
  exit();
}

$userID = $_SESSION["IIN"];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
  $newFullName = $_POST["newFullName"];
  $newPassword = $_POST["newPassword"];

  $updateQuery = "UPDATE users SET name='$newFullName', password='$newPassword' WHERE IIN=$userID";

  if ($conn->query($updateQuery) === TRUE) {
    $message = "Данные успешно обновлены";
  } else {
    $message = "Ошибка при обновлении данных: " . $conn->error;
  }
}



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
        <h2 style="text-align: center;">Личный кабинет</h2>
        <div class="message">
            <?php echo $message; ?>
        </div>

        <h3 style="text-align: center;">Изменить данные</h3>
        <form action="cabinet.php" method="post">
            <label for="newFullName">Новое полное имя:</label>
            <input type="text" id="newFullName" name="newFullName" value="<?php echo $userData["Name"]; ?>" required>

            <label for="newPassword">Новый пароль:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit" name="update">Обновить данные</button>
        </form>

        <form action="logout.php" method="post">
        <button type="submit" name="logout">Выйти</button>
        </form>

        

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