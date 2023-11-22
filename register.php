<?php
require_once("db.php");

$message = ""; // Инициализация переменной для сообщения

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iin = $_POST["iin"];
    $fullName = $_POST["fullName"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Проверка, существует ли пользователь с заданным ИИН
    $checkUserQuery = "SELECT * FROM users WHERE IIN = '$iin'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $message = "Пользователь с указанным ИИН уже зарегистрирован";
    } else {
        // Пользователь не существует, выполняем вставку данных
        $sql = "INSERT INTO users (IIN, Name, surname, password, Telephone, Address) VALUES ('$iin', '$fullName', '$surname', '$password', '$phone', '$address')";

        if ($conn->query($sql) === TRUE) {
            $message = "Данные успешно добавлены в базу данных";
            header("Location: login.php");
            exit();
        } else {
            $message = "Ошибка: " . mysqli_error($conn);
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Регистрация</title>
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
    <form action="register.php" method="post">
        <label for="iin">ИИН:</label>
        <input type="text" id="iin" name="iin" required>

        <label for="fullName">Имя учащегося:</label>
        <input type="text" id="fullName" name="fullName" required>

        <label for="surname">Фамилия учащегося:</label>
        <input type="text" id="surname" name="surname" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <label for="phone">Контактный телефон:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="address">Адрес:</label>
        <input type="text" id="address" name="address" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
    <?php if (!empty($message)) : ?>
            <div class="<?php echo $result->num_rows > 0 ? 'error-message' : 'success-message'; ?>">
                <?php echo $message; ?>
            </div>
    <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2023 Организация кружков</p>
    </footer>
</body>
</html>