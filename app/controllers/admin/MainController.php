<?php

namespace app\controllers\admin;

use wfm\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        echo "<h1>Привет ADMIN</h1>";
    }
}