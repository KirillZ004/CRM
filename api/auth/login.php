<?php
if($_SERVER['REQUEST_METHOD']=== 'POST') {
    
    $login = isset ($_POST['username']) ? $_POST['username'] : '';

    $password = isset ($_POST['password']) ? $_POST['password']: '';
// Переменная для ошибок 
$errors=[];


//proverka
if (!$login) {
    $_SESSION['login-errors'] ['login'] = 
    'Field is required';
    header('Location:../../login.php');
    exit;
}



///напишите функцию для фильтрации данных
function clearData($input){
    $cleaned = strip_tags($input);
    $cleaned= trim($cleaned);
    $cleaned = preg_replace('/\s+/',' ',$cleaned);
    return $cleaned;
}
echo $login;
$login = clearData($login);
echo $login;
$password = clearData($password);
//проверка(пришли ли данные),

//проверка логина




} else {
    echo json_encode([
        "error"=> 'neverno zapros',
        

    ]);
}

?>