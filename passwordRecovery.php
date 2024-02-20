<?php
require_once("db.php");

if (isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {

  $userID = $_POST['email'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];


  if ($newPassword !== $confirmPassword) {
    echo "<p style='color: red'>Пароли не совпадают!</p>";
    exit;
  }


  if (!$user) {
    echo "<p style='color: red'>Пользователь с таким IIN не найден. Пожалуйста, зарегистрируйтесь.</p>";
    exit;
  }

  $updateQuery = "UPDATE users SET password='$newPassword' WHERE IIN=$userID";
  
    if ($conn->query($updateQuery) === TRUE) {
      $message = "Данные успешно обновлены";
    } else {
      $message = "Ошибка при обновлении данных: " . $conn->error;
    }

  // Сообщение об успешном сбросе пароля
  echo "<p style='color: green'>Ваш пароль успешно обновлен!</p>";

} else {
  // Отображение формы сброса пароля
}
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="styles.css">
  </head>

<body>
  <div class="container">
    <h3>Reset Password</h1>
    <p align="center">Enter your registered email address to receive a password reset link.</p>

    <form method="post">
    <label for="email">Введите IIN</label>
    <input type="text" name="email" id="email" required>

    <label for="new_password">Введите новый пароль:</label>
    <input type="password" name="new_password" id="new_password" required>

    <label for="confirm_password">Подтвердите пароль:</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit">Сбросить пароль</button>
  </form>

    </div>

  </body>

</html>