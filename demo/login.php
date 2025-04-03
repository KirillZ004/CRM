<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSH</title>
    <link rel="stylesheet" href="стили/style.css">
</head>
<body>
    <div class="login">
        <form>
            <h1>Авторизация</h1>
            <label for="Login">
                Введите логин
                <span class="error">Необходимо заполнить</span>
            </label>
            <input type="text" name="login" id="login">
            <label for="password">
                Введите пароль
                <span class="error">Необходимо заполнить</span>
            </label>
            <input type="text" name="password" id="password">
            <button type="submit">Вход</button>
            <p class="error">Неверный логин или пароль</p>
        </form>
    </div>
</body>
</html>