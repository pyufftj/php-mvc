<?php

namespace App\Models;

use Core\Model;
use PDO;

class Post extends \Core\Model
{
    public static function getAll()
    {
//        $host = 'localhost';
//        $dbname = 'mvc';
//        $username = 'root';
//        $password = 'root';
        try {
//            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

            $db = Model::getDB();

            $stmt = $db->query('select title,content from posts order by create_at');

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}