<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Окно пользователя</title>
    <link rel="stylesheet" href="стили/style1.css">
</head>
<body>
    <div class="login-form">
        <h2>Вход</h2>
        <form id="loginForm">
        <div class="form-group">
                <label for="login">логин:</label>
                <input type="login" id="login" name="login" required>
                <span class="error" id="loginError"></span>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                <span class="error" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Подтверждение пароля:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span class="error" id="confirmPasswordError"></span>
            </div>
            <button type="submit">Войти</button>
        </form>
        <button id="changePasswordBtn">Изменить пароль</button>
    </div>

    <!-- Модальное окно -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Пароль изменен!</p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
