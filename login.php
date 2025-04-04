<?php session_start();

$db = new PDO(
    'mysql:host=localhost;dbname=module; charset=utf8',
    'root',
    null,
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);



// Проверка : существует ли токен и что он не пустой
if (isset($_SESSION['token']) && ! empty($_SESSION['token'])) {
$token = $_SESSION['token'];
//
$user = $db->query("SELECT id , type FROM users WHERE token = '$token'")->fetchAll();
if (! empty($user)) {
$userType = $token[0]['type'];
$isAdmin = $userType == 'admin';
$isUser = $userType == 'user';

$isAdmin && header('Location: admin.php');
$isUser && header('Location: user.php');
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка заполнения полей
    if (empty($login) || empty($password)) {
        $error = 'Поля необходимо заполнить';
    } else {
        // Проверка логина и пароля в БД
        $stmt = $db->prepare("SELECT id, type FROM users WHERE login = ? AND password = ?");
        $stmt->execute([$login, $password]);
        $user = $stmt->fetch();

        if ($user) {
            // Генерация токена
            $token = bin2hex(random_bytes(32));
            
            // Сохранение токена в БД
            $stmt = $db->prepare("UPDATE users SET token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);
            
            // Сохранение токена в сессии
            $_SESSION['token'] = $token;
            
            // Редирект в зависимости от типа пользователя
            if ($user['type'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: user.php');
            }
            exit();
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
}

?>
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
        <form action="login.php" method="post">
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
            <p class="error"><?php echo isset($error) ? $error : ''; ?></p>
        </form>
    </div>
</body>
</html>