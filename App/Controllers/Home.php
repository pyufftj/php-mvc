<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function index()
    {
//        View::render("Home/index.php", [
//            'name' => 'Pingfan',
//            'colors' => ['red', 'blue', 'green'],
//        ]);

                View::renderTemplate("Home/index.html", [
            'name' => 'Pingfan',
            'colors' => ['red', 'blue', 'green'],
        ]);
    }
}