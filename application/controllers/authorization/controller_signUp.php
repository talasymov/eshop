<?php
namespace core\controllers;
use core as c;
use core\models as cm;

/**
 * Class Controller_SignUp
 * @package core\controllers
 * @category Controllers class
 * @author Mazur Alexandr
 * <pre>
 * Используется для рендера страницы регистрации.
 * </pre>
 */
class Controller_SignUp extends c\Controller
{
    /**
     * Controller_SignUp constructor.
     * Создает объект представления (View)
     */
    public function __construct(){
        $this->view = new c\View();
    }

    /**
     * @return void
     * @access public
     * <pre>
     * Рендерит страницу регистрации.
     * Не использует модель.
     * </pre>
     */
    public function action_index()
    {
        session_start();

        if(!isset($_SESSION['isUserCorrect'])){
          $_SESSION['isUserCorrect'] = FALSE;
        }


        $this->view->generate('signUp_view.php','templates/template_main_view.php');
    }

}
?>
