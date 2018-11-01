<?php

namespace Core;

class Router
{
    /**
     * Associate array of routes(the routing table)
     * @var array
     */
    protected $routes = [];


    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route The route URL
     * @param array $params Parameters(controller, action, etc.)
     *
     * @return void
     */
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }


    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @param $url string The route URL
     * @return bool true if a match found, else false.
     */
    public function match($url)
    {
        // Match to the fixed URL format /controller/action
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
                //$params = [];

                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controller object and running the action method
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);

//            $controller = "App\Controllers\\$controller";    // the complete namespace
            $controller = $this->getNamespace().$controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params); //Change this because every controller extends the \Core\Controller.php

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
//            echo $action;
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    echo("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
            } else {
                throw new \Exception( "Controller class $controller not found");
            }
        } else {
            throw new \Exception( "No route matched",404);
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     * @param string $string The string to convert
     * @return string
     */
    public function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     * @param string $string The string to convert
     *
     * @return string
     */
    public function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove the query string variables from the URL(if only). As the full query string is used for the route, any variables at the end will need to be removed before the route is matched to the routing table.
     *
     * @param string $url The full URL
     * @return string The URL with query string variables removed.
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != "") {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the route parameters is added if present.
     *
     * @return string The request URL
     */
    public function getNamespace()
    {
        $namespace = 'App\Controllers\\';
//        var_dump($this->params);
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
//            echo $namespace;
        }
        return $namespace;
    }
}