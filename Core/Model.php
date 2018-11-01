<?php

namespace Core;

use PDO;
use \App\config;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;

        if ($db == null) {

            $db = new PDO("mysql:host=" . config::DB_HOST . ";dbname=" . config::DB_NAME . ";charset=utf8", config::DB_USER, config::DB_PASS);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        }

        return $db;
    }
}