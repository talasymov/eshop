<?php
namespace core\controllers;

use core as c;
use core\models as cm;

class Controller_AskAndAnswer extends c\Controller{
    
    public function __construct()
    {
        $this->model = new cm\Model_AskAndAnswer();
        $this->view = new c\View();
    }

    public function action_index()
    {
        // TODO: Implement action_index() method.
    }
}