<?php
session_start();
require_once 'db.php';

$error = '';

// Обработка выхода из системы
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Удаляем токен из сессии
    $_SESSION['token'] = '';
    // Перенаправляем на страницу авторизации
    header("Location: login.php");
    exit;
}

$db = new PDO('mysql:host=localhost; dbname=module; charset=utf8', 
'root', 
null, 
[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

// 1. Проверка наличия токена : локально ($_SESSION['token']) и сравнение с бд
//                  Если есть -> перекидываем на странцу пользователя / админа
//                  Если нет -> остаёмся на этой странице

$_SESSION['token'] = '';

// Проверка : существует ли токен и что он не пустой
if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
    $token = $_SESSION['token'];
    //
    $user = $db->query("SELECT id, type FROM users WHERE token = '$token'")->fetchALL();
    
    if (empty($user)) {
        $userType = $token[0]['type'];
        $isAdmin = $userType == 'admin';
        $isUser = $userType == 'user';
    }
    
    $isAdmin && header('Location: admin.php');
    $isUser && header('Location: user.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (empty($login) || empty($password)) {
        $error = 'Введите логин и пароль';
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
            $stmt->execute([$login, $password]);
            $user = $stmt->fetch();

            if ($user) {
                if ($user['blocked']) {
                    $error = 'Учетная запись заблокирована';
                } else {
                    // Генерируем новый токен
                    $token = bin2hex(random_bytes(16));
                    
                    // Обновляем токен и время последнего входа
                    $stmt = $db->prepare("UPDATE users SET token = ?, latest = NOW(), amountAttempt = 0 WHERE id = ?");
                    $stmt->execute([$token, $user['id']]);
                    
                    $_SESSION['token'] = $token;
                    
                    // Перенаправляем в зависимости от роли
                    switch ($user['type']) {
                        case 'admin':
                            header("Location: employees.php");
                            break;
                        case 'cook':
                        case 'waiter':
                            header("Location: orders.php");
                            break;
                        default:
                            header("Location: index.php");
                    }
                    exit();
                }
            } else {
                // Увеличиваем счетчик неудачных попыток
                $stmt = $db->prepare("
                    UPDATE users 
                    SET amountAttempt = amountAttempt + 1,
                        blocked = CASE WHEN amountAttempt + 1 >= 3 THEN 1 ELSE blocked END
                    WHERE login = ?
                ");
                $stmt->execute([$login]);
                
                $error = 'Неверный логин или пароль';
            }
        } catch (PDOException $e) {
            $error = 'Ошибка базы данных: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Авторизация</title>
</head>
<body>
    <div class="auth-container">
        <h1>Авторизация</h1>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="login">Введите логин</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Введите пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>