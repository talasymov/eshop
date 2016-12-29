<?php
require('../../core/model.php');

$tmp_conn = new mysqli(Model::$host, Model::$username, Model::$password, Model::$dbname);

if ($tmp_conn->connect_errno) {
    echo json_encode("{error: connection_error},{error_msg: $tmp_conn->connect_error }");
    exit();
}

if ($_POST['UserID'] <= 0 OR gettype($_POST['UserID']) != 'integer') {
    echo json_encode("login_error");
    exit();
}

if ($_POST['ProductID'] <= 0 OR gettype($_POST['ProductID']) != 'integer') {
    echo json_encode(false);
    exit();
}

$favorite_prod_id = $tmp_conn->real_escape_string($_POST['ProductID']);
$user_id = $tmp_conn->real_escape_string($_POST['UserID']);

$stmt = $tmp_conn->prepare("DELETE FROM Favorite WHERE ID_product_FK = ? AND ID_user_FK = ?");
$stmt->bind_param('ii', $favorite_prod_id, $user_id);
if ($stmt->execute()) {
    echo json_encode(true);
} else {
    echo json_encode(false);
}

$stmt->close();
$tmp_conn->close();