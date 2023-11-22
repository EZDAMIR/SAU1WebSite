<?php
// logout.php

// Инициализация сессии
session_start();

// Уничтожение всех данных сессии
session_destroy();

// Перенаправление на страницу входа
header("Location: login.php");
exit();
?>