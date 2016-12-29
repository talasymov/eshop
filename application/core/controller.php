<?php
namespace core;

/**
 * Абстрактный класс Controller
 * @author Mazur Alexandr
 * @category Controllers class
 * @package core
 * <pre>
 * Описывает контракт контроллера для приложения.
 * </pre>
 */
abstract class Controller
{
    #region Public members & constructor
    /**
     * @var Model храненит объект модели в каждом классе, реализующем класс Controller
     */
    public $model;

    /**
     * @var View храненит объект представления в каждом классе, реализующем класс Controller
     */
    public $view;

    /**
     * Controller constructor. По умолчанию создает только объект класса (типа) View
     */
    function __construct()
    {
        $this->view = new View();
    }
    #endregion
    
    #region Abstract members
    /**
     * @return void
     * @access protected
     * @todo Реализация реакции на действие, указанное в адресной строке, если такое имеется. В противном случае - выполнить действие по умолчанию для текущего контроллера или сделать переадресацию на страницу 404.
     */
    protected abstract function action_index();
    
    #endregion
}

?>
