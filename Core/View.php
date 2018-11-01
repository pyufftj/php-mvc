<?php

namespace Core;

class View
{
    /**
     * Render a view
     * @param string $view The view file
     *
     * @param array $args
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP); // EXTR_SKIP - On collision, the existing variable is not overwritten

        $file = "../App/Views/$view"; //relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception( "$file not found");
        }
    }

    public static function renderTemplate($template, $args=[]){
        static $twig=null;
        if($twig==null){
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig=new \Twig_Environment($loader);
        }

        try {
            echo $twig->render($template, $args);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }
    }
}