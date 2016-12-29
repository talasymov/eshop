<?php
namespace core\controllers;

use core as c;
use core\models as cm;

/**
 * Class Controller_AboutUs
 * @package core\controllers
 * @category Controllers category
 * @author Mazur Alexandr
 */
class Controller_AboutUs extends c\Controller
{
    /**
     * Controller_AboutUs constructor.
     * <pre>
     * Инициализирует свойства model и view
     * </pre>
     */
    public function __construct()
    {
        $this->model = new cm\Model_AboutUs;
        $this->view = new c\View();
    }

    /**
     * @access public
     * @return void
     * <pre>
     * Рендерит страницу "О нас" (AboutUs)
     * </pre>
     */
    public function action_index()
    {
        //$this->view-> так доступ к статическому свойству не получить
        //$this->view:: так тоже
        //View:: тоже не то, свойство же protected
        //А как тогда???


        $this->view->
        generate($this->view->get_folders_name()['info_pages'] . "/aboutUs_view", "template_main_view.php");
    }
}