<?php
namespace core\controllers;
use core\models as cm;
use core as c;
use Ubench;
/**
 * Class Controller_Main служит для рендеринга главной страницы
 * @package core\controllers
 * @category Controllers class
 * @author Mazur Alexandr
 * <pre>
 * Рендерит главную страницу приложения.
 * </pre>
 */
class Controller_Main extends c\Controller
{
    /**
     * Controller_Main constructor.
     * <pre>
     * Создает объекты модели и представления (View)
     * </pre>
     */
    public function __construct(){
        $this->model = new cm\Model_Main();
        $this->view = new c\View();
    }

    /**
     * <pre>
     * Создает (рендерит) главную страницу приложения.
     * Запускает сессию и устанавливает ей параметры по умолчанию, если не установлены.
     * <code>
     * session_start();
     * </code>
     * </pre>
     * @return void
     * @access public
     */
    public function action_index()
    {
        $bench = new Ubench;
        $bench->start();
        session_start();

        if(!isset($_SESSION['isUserCorrect'])){
          $_SESSION['isUserCorrect'] = FALSE;
        }
        $data = $this->model->get_data();

        $this->view->generate('main_view.php','template_main_view.php', $data);
        $bench->end();
        echo "controller_main: <br>";
        echo $bench->getTime() . "<br>";
        echo $bench->getMemoryPeak() . "<br>";
        echo $bench->getMemoryUsage() . "<br>";
    }
}
?>
