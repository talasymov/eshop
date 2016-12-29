<?php
require('../application/core/model.php');
$this->connect = new mysqli(Model_Admin::$host, Model_Admin::$username, Model_Admin::$password, Model_Admin::$dbname);

$query = "SELECT * FROM Users WHERE ";

$tables;
$values;

if(isset($_POST['name']) && $_POST['name'] != ''){
  $tables .= "User_name,";
  $values .= htmlspecialchars($_POST['name']) . ',';
}

if(isset($_POST['surname']) && $_POST['surname'] != ''){
  $tables .= "User_surname,";
  $values .= htmlspecialchars($_POST['surname']) . ',';
}

if(isset($_POST['secondname']) && $_POST['secondname']){
  $tables .= "User_secondname,";
  $values .= htmlspecialchars($_POST['secondname']) . ',';
}

if(isset($_POST['birthday'])){
  $tables .= "User_birthday,";
  $values .= htmlspecialchars($_POST['birthday'])
}

if(isset($_POST['sex']) && $_POST['sex'] != ''){
  $tables .= "User_sex,";
  $values .= htmlspecialchars($_POST['sex']);
}

if(isset($_POST['interests']) && $_POST['interests'] != ''){
  $tables .= "User_interests,";
  $values .= htmlspecialchars($_POST['interests']);
}

if(isset($_POST['login']) && $_POST['login'] != ''){
  $tables .= "User_login,";
  $values .= htmlspecialchars($_POST['login']);
}

if(isset($_POST['telephone']) && $_POST['telephone'] != ''){
  $tables .= "User_telephone,";
  $values .= htmlspecialchars($_POST['login']);
}

if(isset($_POST['email']) && $_POST['email'] != ''){
  $tables .= "User_email,";
  $values .= htmlspecialchars($_POST['email']);
}

$tmp = explode('/',$tables);
echo json_encode($tmp);

foreach ($variable as $key => $value) {
  # code...
}

$connect->close();
 ?>
