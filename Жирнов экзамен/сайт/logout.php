<?php
session_start();

// Очистка токена в базе данных
if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
    require_once 'db.php';
    
    try {
        $stmt = $db->prepare("UPDATE users SET token = NULL WHERE token = ?");
        $stmt->execute([$_SESSION['token']]);
    } catch (PDOException $e) {
        // Игнорируем ошибки базы данных при выходе
    }
}

// Очистка сессии
$_SESSION = array();
session_destroy();

// Перенаправление на страницу входа
header("Location: login.php");
exit();
?> 