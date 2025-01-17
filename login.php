<?php

session_start();

require_once 'modules/AuthCheck.php';
AuthCheck('clients.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM | Авторизация</title>
    <link rel="stylesheet" href="styles/settings.css"> 
    <link rel="stylesheet" href="styles/pages/login.css">
</head>
<body>
    <div class="login-container">
        <!-- Форма с полями логин, пароль и кнопкой войти -->
        <form class="login-form" action="/login" method="post">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>