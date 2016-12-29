<?php
namespace core\controllers;

use core as c;
use core\models as cm;

/**
 * Class Controller_Product
 * @package core\controllers
 * @category Controllers class
 * @author Mazur Alexandr
 * <pre>
 * Рендерит страницу продукта (-ов)
 * </pre>
 */
class Controller_Product extends c\Controller
{
    /**
     * Controller_Product constructor.
     * <pre>
     * Создает объекты модели и представления (View)
     * </pre>
     */
    function __construct()
    {
        $this->model = new cm\Model_Product();
        $this->view = new c\View();
    }

    /**
     * <pre>
     * Рендерит и отображает страницу товара, данные для которой взяты из БД.
     * Запускается, если есть action в виде ссылке на товар
     * </pre>
     * @access public
     * @return void
     */
    public function action_product()
    {
        try {
            $data = $this->model->get_data();
            $this->view->generate('product_view.php', 'template_main_view.php', $data);

            session_start();

            if (!isset($_SESSION['isUserCorrect'])) {
                $_SESSION['isUserCorrect'] = FALSE;
            }
        } catch (\Exception $e) {
            $this->action_index();
        }
    }

    /**
     * <pre>
     * Рендерит и отображает страницу товаров, данные для которой взяты из БД.
     * Запускается, если action'a в виде ссылке на товар нету
     * или обращение к странице /Product
     * </pre>
     * @access public
     * @return void
     */
    public function action_index()
    {
        session_start();

        if (!isset($_SESSION['isUserCorrect'])) {
            $_SESSION['isUserCorrect'] = FALSE;
        }
//        $this->view->generate('')
        echo '<br>отображение всех товаров здесь';
    }

}