<?php
namespace core\models;

use core as c;

/**
 * Class Model_Main
 * @package core\models
 * @category Models category
 * @author Mazur Alexandr
 * <pre>
 * Используется для получения данных для рендера страницы
 * </pre>
 */
class Model_Main extends c\Model
{
    /**
     * @return array с данными для отображения главной страницы
     * @access public
     * <pre>
     * Метод, который возвращает данные для отображения главной страницы
     * </pre>
     */
    public function get_data()
    {
        $tmp_conn = new \mysqli(c\Model::$host, c\Model::$username, c\Model::$password, c\Model::$dbname);
        if ($tmp_conn->connect_errno) {
            printf("Соединение не удалось: %s\n", $tmp_conn->connect_error);
            exit();
        }

        $data = [];
        $data['Template'] = $this->get_main_template_data();
        $tmp_conn->close();
        return $data;
    }
}

?>
