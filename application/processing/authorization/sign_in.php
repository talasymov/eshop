<?php
require('../core/model.php');
session_start();

if (!isset($_SESSION['isUserCorrect'])) {
    $_SESSION['isUserCorrect'] = FALSE;
}

if ($_SESSION['isUserCorrect']) {
    echo json_encode('redirect');
} else {
    $login = htmlspecialchars(strtolower($_POST['login']));
    $password = htmlspecialchars(md5($_POST['password']));
    $tmp_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    if ($result = $tmp_conn->query("SELECT Login, Password FROM User WHERE Login = '$login' AND Password = '$password'")) {
        if ($result->num_rows > 0) {
            $_SESSION['userLogin'] = $_POST['login'];
            $_SESSION['isUserCorrect'] = TRUE;
            echo json_encode('true');
        } else {
            $_SESSION['isUserCorrect'] = FALSE;
            echo json_encode('false');
        }
    } else {
        $_SESSION['isUserCorrect'] = FALSE;
        echo json_encode('false');
    }
    $tmp_conn->close();
}
?>
