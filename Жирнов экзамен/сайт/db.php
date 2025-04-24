<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=module;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // В production версии лучше записывать ошибки в лог, а не выводить напрямую
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

// Функция для безопасного получения значения из POST
function getPostValue($key, $default = '') {
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

// Функция для безопасного получения значения из GET
function getGetValue($key, $default = '') {
    return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
}

// Функция для проверки авторизации
function checkAuth($db, $token) {
    if (empty($token)) return false;
    
    $stmt = $db->prepare("SELECT id, type FROM users WHERE token = ? AND status = 'active'");
    $stmt->execute([$token]);
    return $stmt->fetch();
}

// Функция для генерации случайного токена
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Функция для обновления токена пользователя
function updateUserToken($db, $userId, $token) {
    $stmt = $db->prepare("UPDATE users SET token = ?, last_activity = NOW() WHERE id = ?");
    return $stmt->execute([$token, $userId]);
}

// Функция для форматирования даты
function formatDate($date) {
    return date('d.m.Y', strtotime($date));
}

// Функция для форматирования времени
function formatDateTime($datetime) {
    return date('d.m.Y H:i', strtotime($datetime));
}