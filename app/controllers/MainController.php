<?php

namespace app\controllers;

use app\models\Main;

use RedBeanPHP\R;
use wfm\Controller;


/** @property Main $model */
class MainController extends Controller
{
   // public false|string $layout = 'test2';
    public function indexAction()
    {
        //$this->layout = 'default';
        //$names = ['John', 'Dave', 'Katy'];
        $names = $this->model->get_names();
        $one_name = R::getRow('SELECT * FROM name WHERE id = 2');
        $this->setMeta('Главная страница', 'Description...', 'keywords...');
        //$this->set(['test' => 'TEST VAR', 'name' => 'John']);
        //$this->set(['names' => $names]);
        $this->set(compact('names'));
    }
}