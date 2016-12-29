<?php
switch ($_POST['action']) {
    //authorization
    case 'signIn':
        include '../processing/authorization/sign_in.php';
        break;
    case 'signUp':
        include '../processing/authorization/sign_up.php';
        break;
    case 'signOutAdmin':
        include '../processing/authorization/sign_out_admin.php';
        break;
    case 'signInAdmin':
        include '../processing/authorization/sign_in_admin.php';
        break;
    case 'signOut':
        include '../processing/authorization/sign_out.php';
        break;
    case 'profileUpdate':
        include '../processing/profile_update.php';
        break;
    case 'adminSearch':
        include '../processing/user_admin_search.php';
        break;
    //product
    case 'addFavorite':
        include "../processing/product/add_favorite.php";
        break;
    case 'removeFavorite':
        include "../processing/product/remove_favorite.php";
        break;
    case 'addReview':
        include '../processing/product/add_review.php';
        break;
    case 'removeReview':
        include '../processing/product/remove_review.php';
        break;
    case 'makeSearch':
        include '../processing/product/make_search.php';
        break;
    default:
        $a = array('default', $_POST['action']);
        echo json_encode($a);
        break;
}
?>