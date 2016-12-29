<?php
define('OQ', ",'"); //открывающая кавычка
define('FQ', "'"); //закрывающая или первая кавычка

require('../core/model.php');

$tmp_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);

function isUserLoginExists($login)
{
    $func_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    if ($result = $func_conn->query("SELECT Login FROM User WHERE Login = '$login'")) {
        if ($result->num_rows > 0) {
            $result->free_result();
            return true;
        } else {
            $result->free_result();
            return false;
        }
    } else {
        return false;
    }
    $func_conn->close();
}

function getLastAddressID()
{
    $func_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);
    $result = $func_conn->query("SELECT ID_address From Address");
    $result->data_seek($result->num_rows-1);
    $row = $result->fetch_row();
    $id = $row[0];
    $func_conn->close();
    return $id;
}


$table_value = array();

$table_value_address = array();

//user data

if (!isset($_POST['login'])) {
    echo json_encode(false);
    exit();
}

if (isUserLoginExists($tmp_conn->real_escape_string(strtolower($_POST['login'])))) {
    echo json_encode('login exists');
    exit();
} else {
    $table_value['Login'] = $tmp_conn->real_escape_string(strtolower($_POST['login']));
}

if (!isset($_POST['name'])) {
    echo json_encode(false);
    exit();
} else {
    $table_value['Name'] = $tmp_conn->real_escape_string($_POST['name']);
}

if (!isset($_POST['email'])) {
    echo json_encode(false);
    exit();
} else {
    $table_value['Email'] = $tmp_conn->real_escape_string(strtolower($_POST['email']));
}

if (strlen($_POST['password']) < 8) {
    echo json_encode(false);
    exit();
} else {
    $table_value['Password'] = $tmp_conn->real_escape_string(md5($_POST['password']));
}

if (!isset($_POST['surname'])) {
    echo json_encode(false);
    exit();
} else {
    $table_value['Surname'] = $tmp_conn->real_escape_string($_POST['surname']);
}

if (isset($_POST['patronymic'])) {
    $table_value['Patronymic'] = $tmp_conn->real_escape_string($_POST['patronymic']);
}

if (isset($_POST['birthdate'])) {
    $date = array_reverse(explode('.', $tmp_conn->real_escape_string($_POST['birthdate'])));
    $table_value['Birthdate'] = implode('-', $date);
}

if (isset($_POST['gender'])) {
    $table_value['Gender'] = $tmp_conn->real_escape_string($_POST['gender']);
}

if (isset($_POST['telephone'])) {
    $table_value['Telephone'] = $tmp_conn->real_escape_string($_POST['telephone']);
}

$insert_query = "INSERT INTO User(";

foreach ($table_value as $key => $value) {
    $insert_query .= $key . ", ";
}

$insert_query .= "User_permission_FK, Address_FK) VALUES (";
$i = 0;
foreach ($table_value as $item) {
    if ($i == 0) {
        $insert_query .= FQ . $item . FQ;
        $i++;
    } else {
        $insert_query .= OQ . $item . FQ;
    }
}

//end user data

//address data
$insert_query_address = "INSERT INTO Address(";

if (isset($_POST['country'])) {
    $table_value_address['Country'] = $tmp_conn->real_escape_string($_POST['country']);
}

if (isset($_POST['state'])) {
    $table_value_address['State'] = $tmp_conn->real_escape_string($_POST['state']);
}

if (isset($_POST['region'])) {
    $table_value_address['Region'] = $tmp_conn->real_escape_string($_POST['region']);
}

if (isset($_POST['city'])) {
    $table_value_address['City'] = $tmp_conn->real_escape_string($_POST['city']);
}

if (isset($_POST['buildNumber'])) {
    $table_value_address['Build_numb'] = $tmp_conn->real_escape_string($_POST['buildNumber']);
}

if (isset($_POST['porch'])) {
    $table_value_address['Porch'] = $tmp_conn->real_escape_string($_POST['porch']);
}

if(isset($_POST['street'])){
    $table_value_address['Street'] = $tmp_conn->real_escape_string($_POST['street']);
}

if (isset($_POST['apartment'])) {
    $table_value_address['Apartment'] = $tmp_conn->real_escape_string($_POST['apartment']);
}

if (isset($_POST['cityIndex'])) {
    $table_value_address['CityIndex'] = $tmp_conn->real_escape_string($_POST['cityIndex']);
}

foreach ($table_value_address as $key => $value) {
    $insert_query_address .= $key . ", ";
}

$insert_query_address = substr($insert_query_address, 0, strlen($insert_query_address) - 2);

$insert_query_address .= ") VALUES (";

$j = 0;

foreach ($table_value_address as $item) {
    if ($i == 0) {
        $insert_query_address .= FQ . $item . FQ;
        $i++;
    } else {
        $insert_query_address .= OQ . $item . FQ;
    }
}

$insert_query_address .= ');';

$tmp_conn->query($insert_query_address);

//end address

$last_address_id = getLastAddressID();

$insert_query .= ",1,$last_address_id);";


$tmp_conn->query($insert_query);
$tmp_conn->close();
echo json_encode(true);
?>
