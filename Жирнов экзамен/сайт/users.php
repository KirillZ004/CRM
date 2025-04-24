<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}

// Подключение к БД
require_once 'db.php';

// Получаем информацию о пользователе по токену
$token = $_SESSION['token'];
$stmt = $db->prepare("SELECT id, login, type FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Если пользователь не найден или не админ
if (!$user || $user['type'] !== 'admin') {
    $_SESSION['token'] = '';
    header("Location: login.php");
    exit();
}

// Обработка блокировки/разблокировки
if (isset($_POST['toggle_block'])) {
    $user_id = (int)$_POST['user_id'];
    $new_status = $_POST['new_status'];
    
    if ($user_id != $user['id']) { // Нельзя заблокировать самого себя
        $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $user_id]);
    }
    
    header("Location: users.php");
    exit();
}

// Получение списка пользователей
$users = $db->query("
    SELECT 
        u.id,
        u.login,
        u.first_name,
        u.last_name,
        u.status,
        u.login_attempts,
        u.last_activity,
        u.type
    FROM users u
    ORDER BY u.last_activity DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="styles/add.css">
    <style>
        .user-row:hover {
            background-color: #f8f9fa;
        }
        
        .status-active {
            color: #28a745;
        }
        
        .status-blocked {
            color: #dc3545;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-block {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-unblock {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-edit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-block:hover, .btn-unblock:hover, .btn-edit:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <span>Администратор: <?php echo htmlspecialchars($user['login']); ?></span>
            <a href="logout.php" class="btn-logout">Выйти</a>
        </div>

        <h1>Список пользователей</h1>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Статус</th>
                        <th>Попыток входа</th>
                        <th>Последняя активность</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr class="user-row">
                            <td><?php echo htmlspecialchars($u['login']); ?></td>
                            <td><?php echo htmlspecialchars($u['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($u['last_name']); ?></td>
                            <td>
                                <span class="status-<?php echo $u['status'] === 'active' ? 'active' : 'blocked'; ?>">
                                    <?php echo $u['status'] === 'active' ? 'Активен' : 'Заблокирован'; ?>
                                </span>
                            </td>
                            <td><?php echo $u['login_attempts']; ?></td>
                            <td>
                                <?php 
                                echo $u['last_activity'] ? 
                                    date('d.m.Y H:i', strtotime($u['last_activity'])) : 
                                    'Нет активности';
                                ?>
                            </td>
                            <td class="action-buttons">
                                <?php if ($u['id'] != $user['id']): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                        <?php if ($u['status'] === 'active'): ?>
                                            <input type="hidden" name="new_status" value="blocked">
                                            <button type="submit" name="toggle_block" class="btn-block">Заблокировать</button>
                                        <?php else: ?>
                                            <input type="hidden" name="new_status" value="active">
                                            <button type="submit" name="toggle_block" class="btn-unblock">Разблокировать</button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                                <a href="edit_user.php?id=<?php echo $u['id']; ?>" class="btn-edit">Редактировать</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 