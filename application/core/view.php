<?php

namespace core;

/**
 * Class View
 * @author Mazur Alexandr
 * @category View class
 * @package core
 * <pre>
 * Описывает контракт представления (View) для приложения.
 * </pre>
 */
class View
{

    #region Private members
    private const TEMPLATE_PATH = "";
    #endregion

    #region Public Static members
    protected static $VIEWS_SUB_FOLDERS = array(
        'authorization' => "authorization",
        'admin' => "admin",
        'info_pages' => "info_pages"
    );
    #endregion

    //public $template_view; //здесь можно указать общий вид по умолчанию.

    /**
     * @return array с папками view, в которых могут хранится необходимые файлы
     * @access public     
     */
    public function get_folders_name(){
        return self::$VIEWS_SUB_FOLDERS;
    }

    /**
     * @param $content_view виды отображающие контент страниц;
     * @param $template_view общий для всех страниц шаблон;
     * @param null $data массив, содержащий элементы контента страницы. Обычно заполняется в модели.
     * @access public
     * @return void
     */
    public function generate($content_view, $template_view, $data = null)
    {
        require 'application/views/templates/' . $template_view;
    }
}

?>
