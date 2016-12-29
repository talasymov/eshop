<?php

/**
 * Класс Route
 * @category Core класс
 * @package none
 * <pre>
 * Управляет работой приложения:
 *  - Динамическое стягивание необходимых компонентов;
 *  - Динамическое создание объектов для рендеринга страниц;
 *  - Переадресация на страницу 404, если нужна.
 * </pre>
 */
class Route
{

    /**
     * @var string хранит путь к корневой папке контроллеров
     * @access private
     * @static
     */
    private static $CONTROLLERS_PATH = "application/controllers/";

    /**
     * @var string хранит путь к корневой папки моделей
     * @access private
     * @static
     */
    private static $MODELS_PATH = 'application/models/';

    /**
     * @var array хранит дополнительные подпапки, в которых может быть нужный класс "controller"
     * @access private
     * @static
     */
    private static $SUB_CONRTOLLERS_PATH = array(
        "authorization",
        "info_pages"
    );

    /**
     * @var array хранит дополнительные подпапки, в которых может быть нужный класс "model"
     * @access private
     * @static
     */
    private static $SUB_MODELS_PATH = array(
        "info_pages"
    );

    /**
     * @static
     * @access public
     * <pre>
     * Управляет работой приложения:
     *  - Динамическое стягивание необходимых компонентов;
     *  - Динамическое создание объектов для рендеринга страниц;
     *  - Переадресация на страницу 404, если нужна.
     * </pre>
     * @return void
     */
    public static function start()
    {
        //контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';

        //разбиваем uri на страницы
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        //получаем имя контроллера, начинаем с первого, т.к. 0й элемент - dns-адрес хоста
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        //получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        //добавляем префиксы
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'Action_' . $action_name;

        //подцепляем файл с классом модели (файла может и не быть)
        $model_file = strtolower($model_name) . '.php';
        $model_path = Route::$MODELS_PATH . $model_file;
        if (file_exists($model_path)) {
            require $model_path;
        } else {
            foreach (Route::$SUB_MODELS_PATH as $sub_model) {
                $model_path = Route::$MODELS_PATH . $sub_model . '/' . $model_file;
                if (file_exists($model_path)) {
                    require $model_path;
                    break;
                }
            }
        }

        //подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = Route::$CONTROLLERS_PATH . $controller_file;
        //если файла нету в корневой папке
        if (file_exists($controller_path)) {
            require $controller_path;
        } else { // то проверяем по подпапкам
            $is_file_exists = false; //флаг нахождения файла
            //бегаем по циклу в поисках файла в подпапке
            foreach (Route::$SUB_CONRTOLLERS_PATH as $sub_controller) {
                //создаем путь к искомому файлу
                $controller_path = Route::$CONTROLLERS_PATH . '/' . $sub_controller . '/' . $controller_file;
                //проверяем наличие этого файла, если находим
                if (file_exists($controller_path)) {
                    //меняем флаг на "найдено"
                    $is_file_exists = true;
                    //подцепляем его
                    require $controller_path;
                    //выходим с цикла
                    break;
                }
            }
            //по завершению цикла проверяем найден ли наш файл
            //если не найден - редиректим на страницу 404 Not Found
            if (!$is_file_exists) {
                Route::ErrorPage404();
            }
        }
        //создаем контроллер
        $controller_name = 'core\controllers\\' . $controller_name;
        $controller = new $controller_name;
        $action = $action_name;

        if ($controller_name == "core\controllers\Controller_Product") {
            if ($action != 'Action_index') {
                $action = "Action_product";
            }
        }

        if (method_exists($controller, $action)) {
            //вызываем действие контроллера
            $controller->$action();
        } else {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

        if ($controller_name == "Admin") {
            $controller->$action();
        }


    }

    /**
     * @static
     * @access public
     * <pre>
     * Делает переадресацию на страницу 404, в случае, если указанной в адресной строке страницы не существует.
     * </pre>
     * @return void
     */
    public static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
