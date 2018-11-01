<?php

namespace Core;

/**
 * Base Controller
 * @package Core
 */
abstract class Controller
{
    /*
     * Parameters from the matched route
     */
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is called on an object of this class.
     * Used to execute before and after filter methods on action methods
     * Action methods need to be named with an "Action" suffix, e.g. indexAction, showAction etc.
     * @param string $name Method name
     * @param array $args Arguments passed to the method.
     */
    public function __call($name, $args)
    {
        $method = $name . "Action";
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();

            }
        } else {
            throw new \Exception("Method $method not found in controller".get_class($this));
        }

    }

    /**
     * Before filter - called before an action method.
     */
    public function before()
    {
    }

    /**
     * After filter - called after an action method.
     */
    public function after()
    {
    }


}