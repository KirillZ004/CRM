<?php session_start();
// Вход по логину / паролю админа

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once '../DB.php'; 
    $login = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    //Переменная для ошибок
    $_SESSION['login-errors'] = [];
    //проверка на логин 
    if(!$login){ 
        $_SESSION['login-errors']['login'] = 
        'Field is required'; 
     
    header('Location: ../../login.php'); 
    exit; 
    } 
    //проверка на пароль 
    if(!$password){ 
        $_SESSION['password-errors']['password'] = 
        'Field is required'; 
     
    header('Location: ../../login.php'); 
    exit; 
    }
    //Функция для фильтрации данных
    function clearData($fields) {
        //Принимает строку чистит её возращает чистую
        $fields = trim($fields); // Удаляет пробелы в начале и конце
        $fields = stripslashes($fields); // Удаляет экранирование
        $fields = strip_tags($fields); // Удаляет HTML и PHP теги
        $fields = htmlspecialchars($fields); // Преобразует специальные символы в HTML сущности
        return $fields;
    }
    $login = clearData($login);
    $password = clearData($password);
    //Проверка(Пришли ли данные),
    $userID = $DB->query( 
        "SELECT id  FROM users WHERE login='$login' 
        ")->fetchAll(); 
    if (empty($userID)) {
        $_SESSION['login-errors']['login'] = 'User not found'; 
     
        header('Location: ../../login.php'); 
        exit;
    }

    $userID = $DB->query( 
        "SELECT id  FROM users WHERE login='$login' AND password='$password'
        ")->fetchAll(); 
    if (empty($userID)) {
        $_SESSION['password-errors']['password'] = 'Wrong password'; 
        header('Location: ../../login.php'); 
        exit;
    }
    $uniqueString = time();
    $token = base64_encode("login = $login & password = $password & unique=$uniqueString");
    
    //Записать в сессию в поле token
    $_SESSION['token'] = $token;
    
    //Записать в БД в поле token
    try {
        $updateToken = $DB->prepare("UPDATE users SET token = ? WHERE login = ? AND password = ?");
        $updateToken->execute([$token, $login, $password]);
        
        // Если успешно, делаем редирект на страницу клиентов
        header('Location: ../../clients.php');
        exit;
    } catch(PDOException $e) {
        $_SESSION['login-errors']['token'] = 'Ошибка сохранения сессии';
        header('Location: ../../login.php');
        exit;
    }

}else{
    echo json_encode([
        "error" => 'Неверный запрос',
    ]);
}


?>