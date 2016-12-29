<?php
session_start();
if (!isset($_SESSION['isAdminCorrect'])) {
    $_SESSION['isAdminCorrect'] = FALSE;
} else {
    $_SESSION['isAdminCorrect'] = FALSE;
}
unset($_SESSION['isAdminCorrect']);
session_destroy();
echo json_encode('true');
?>
