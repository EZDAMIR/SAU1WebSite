<?php
require_once("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT IIN FROM users WHERE IIN = '$username' AND password = '$password'";

    $result = $conn->query($sql);

    // Проверка результата запроса
    if ($result->num_rows > 0) {
        // Успешная авторизация

        // Получение user_id
        $row = $result->fetch_assoc();
        $user_id = $row["IIN"];

        // Установка сессии для авторизованного пользователя
        $_SESSION["IIN"] = $user_id;

         // Проверка, является ли пользователь администратором
        if ($user_id == 'admin') {
        $_SESSION["isAdmin"] = true;
        }

        header("Location: cabinet.php");
        exit();
    } else {
        $error_message = "Неверные учетные данные. Пожалуйста, проверьте свой логин и пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Вход</title>
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
    <form action="login.php" method="post
        <label for="username">ИИН пользователя:</label>
        <input type="text" id="username" name="username" placeholder="Write IIN here" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password"  placeholder="Write password here" required>

        <button type="submit">Войти</button>

        <a class="register-link" href="register.php">Зарегистрироваться</a>
        <a class="reset-link" href="passwordRecovery.php">Забыли пароль?</a>
    </form>
    </div>

    <?php if (isset($error_message)) : ?>
    <div class="error-message">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>

    <footer>
        <p>&copy; 2023 Организация кружков</p>
    </footer>
</body>
</html>
