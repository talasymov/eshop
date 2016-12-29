<?php
namespace core\controllers;

use core as c;
use core\models as cm;

/**
 * Class Controller_Search
 * @package core\controllers
 * @category Controllers class
 * @author Mazur Alexandr
 * <pre>
 * Класс для рендера страницы поиска
 * </pre>
 */
class Controller_Search extends c\Controller
{
    /**
     * Controller_Search constructor.
     * <pre>
     * Создает объекты модели и представления (View)
     * </pre>
     */
    function __construct()
    {
        $this->model = new cm\Model_Search();
        $this->view = new c\View();
    }

    /**
     * @return void
     * @access protected
     * <pre>
     * Рендерит страницу поиска.
     * Не запускает сессию.
     * </pre>
     */
    function action_index()
    {
//        session_start();

        if (!isset($_SESSION['isUserCorrect'])) {
            $_SESSION['isUserCorrect'] = FALSE;
        }

        $data = $this->model->get_data();
        $this->view->generate("search_view.php", "template_main_view.php", $data);
    }
}
