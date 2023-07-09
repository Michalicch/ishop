<?php

namespace wfm;

use RedBeanPHP\R;
use RedBeanPHP\RedException;

class Db
{

    use TSimgleton;


    private function __construct()
    {
        $db = require_once CONFIG . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['password']);
        if(!R::testConnection()) {
            throw new \Exception('Нет  подключения к базе данных DB', 500);
        }
        R::freeze(true);
        if (DEBUG) {
            R::debug(true, 3);
        }

    }

}