<?php
session_start();
require('../application/core/model.php');
$this->connect = new mysqli(Model_Admin::$host, Model_Admin::$username, Model_Admin::$password, Model_Admin::$dbname);

$query = "UPDATE Users SET ";

$values = array();

if(isset($_POST['name']) && $_POST['name'] != ''){
  $values['User_name'] = "'". htmlspecialchars($_POST['name']) . "',";
}

if(isset($_POST['surname']) && $_POST['surname'] != ''){
  $values['User_surname'] = "'". htmlspecialchars($_POST['surname']) . "',";
}

if(isset($_POST['secondname']) && $_POST['secondname'] != ''){
  $values['User_secondname'] = "'". htmlspecialchars($_POST['secondname']) . "',";
}

if(isset($_POST['telephone']) && $_POST['telephone'] != ''){
  $values['User_telephone'] = "'". htmlspecialchars($_POST['telephone']) . "',";
}

if(isset($_POST['interests']) && $_POST['interests'] != ''){
  $values['User_interests'] = "'". htmlspecialchars($_POST['interests']) . "',";
}

if(isset($_POST['email']) && $_POST['email'] != ''){
  $values['User_email'] = "'". htmlspecialchars($_POST['email']) . "',";
}

foreach ($values as $key => $value) {
  $query .= $key . '=' . $value;
}

$tmp = substr($query,0,strlen($query)-1);
$query = $tmp;
unset($tmp);

$query .= ' WHERE User_login = ' . "'" . $_SESSION['userLogin'] . "'";

$connect->query($query);
$connect->close();
 ?>
