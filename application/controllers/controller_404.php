<?php
namespace core\controllers;
use core as c;

/**
 * Class Controller_404
 * @package core\controllers
 * @category Controllers class
 * @author Mazur Alexandr
 * <pre>
 * Рендерит страницу 404 (Page not found).
 * </pre>
 */
class Controller_404 extends c\Controller
{
    /**
     * Controller_404 constructor.
     * <pre>
     * Создает объект представления (View)
     * </pre>
     */
    function __construct()
    {
        $this->view = new c\View();
    }

    /**
     * @return void
     * @access public
     * <pre>
     * Рендерит страницу 404 (Page not found)
     * </pre>
     */
    public function action_index()
    {
        $this->view->generate('404_view.php','template_main_view.php');
    }
}
