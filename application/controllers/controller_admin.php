<?php
namespace core\controllers;
use core as c;
use core\models as cm;

/**
 * Class Controller_Admin
 * @package core\controllers
 */
class Controller_Admin extends c\Controller
{
    public function __construct(){
        $this->model = new cm\Model_Admin();
        $this->view = new c\View();
    }

    function action_index()
    {
        session_start();

        if(!isset($_SESSION['isAdminCorrect'])){
          $_SESSION['isAdminCorrect'] = FALSE;
        }

        if($_SESSION['isAdminCorrect']){
          header('Location: /Admin/Main');
        }
        else{
          $this->view->generate('admin_view.php','template_main_view.php');
        }
    }

    function action_main(){
      session_start();

      if(!isset($_SESSION['isAdminCorrect'])){
        $_SESSION['isAdminCorrect'] = FALSE;
      }

      if($_SESSION['isAdminCorrect']){
        $data = $this->model->getAllData();
        $this->view->generate('admin_success.php','template_main_view.php',$data);
      }
      else{
        $this->view->generate('adminMainFalse_view.php','template_main_view.php');
      }
    }



}
?>
