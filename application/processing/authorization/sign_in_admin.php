<?php
require('../core/model.php');
//соединяемся
$tmp_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);

//проверяем, установлено ли соединение
if ($tmp_conn->connect_errno) {
    printf("Не удалось подключиться: %s\n", $tmp_conn->connect_error);
    exit();
}

//массив с пользователями, у которых есть права войти в админку
$admin_user = [];

//выбираем пользователей с правами админа
if ($result = $tmp_conn->query("SELECT Login, Password FROM User JOIN User_permission ON
User.ID_user = User_permission.ID_permission WHERE User_permission.Permission = 'Администратор'")) {
    //запихиваем их в массив
    while ($row = $result->fetch_assoc()) {
        array_push($admin_user, $row);
    }
    //очищаем результирующий набор
    $result->close();
}

//начинается наша сессия, выше была "прелюдия"
session_start();

//если переменная сессии не установлена - устанавливаем
if (!isset($_SESSION['isAdminCorrect'])) {
    $_SESSION['isAdminCorrect'] = FALSE;
}

$login = htmlspecialchars(strtolower($_POST['login']));
$password = htmlspecialchars(md5($_POST['psw']));

$checkResult = false;

foreach ($admin_user as $item) {
    if (strtolower($item['Login']) == $login && $item['Password'] == $password) {
        $checkResult = true;
        break;
    }
}

if ($checkResult) {
    $_SESSION['isAdminCorrect'] = TRUE;
    echo json_encode('true');
} else {
    $_SESSION['isAdminCorrect'] = FALSE;
    echo json_encode('false');
}


$tmp_conn->close();

?>
