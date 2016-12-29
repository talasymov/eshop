<?php
namespace core\controllers;
use core as c;
use core\models as cm;

class Controller_Profile extends c\Controller
{
    public function __construct(){
        $this->model = new cm\Model_Profile();
        $this->view = new c\View();
    }

    function action_index()
    {
        session_start();

        if(!isset($_SESSION['isUserCorrect'])){
          $_SESSION['isUserCorrect'] = FALSE;
        }
        if($_SESSION['isUserCorrect']){
          $data = $this->model->get_data();
          $this->view->generate('profile_view.php','templates/template_main_view.php', $data);
        } else {
          header('Location: /');
        }
    }
} ?>
