<?php
/**
 * Created by PhpStorm.
 * User: kpf
 * Date: 2018/10/13
 * Time: 上午9:54
 */

namespace App\Controllers;

use \Core\View;
use \App\Models\Post;

class Posts extends \Core\Controller
{

    public function before()
    {
        echo "(before)";
        return false;
    }

    public function after()
    {
        echo "(after)";
    }

    public function addNewAction()
    {
        echo "Hello from Posts class AddNew method!";
        echo "<p>Analysing the GET parameter</p>";
        echo "<pre>" . htmlspecialchars(print_r($this->route_params, true)) . "</pre>";
    }

    public function index()
    {
        $posts = Post::getAll();
        View::renderTemplate('Posts/index.html', ['posts' => $posts]);
    }

}


