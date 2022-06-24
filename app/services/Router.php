<?php
namespace Readme\app\services;

/**
 * Class for routing
 */
class Router
{
    /**
     * Route table
     *
     * @var array
     */
    protected static $routes = [];

    /**
     * Current route
     *
     * @var array
     */
    protected static $route = [];

    /**
     * Adds a route to the route table
     *
     * @param string $regexp Regular expression of the route
     * @param array $route Route ([controller, action])
     * @return void
     */
    public static function add($regexp, $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Returns the route table
     *
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Returns the current route
     *
     * @return array
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * Searches for the URL in the query table
     *
     * @param string $url Incoming URL
     * @return boolean
     */
    public static function matchRoute(string $url): bool
    {
        foreach(self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                self::$route = $route;

                return true;
            }
        }

        return false;
    }

    /**
     * Redirects the URL to the correct route
     *
     * @param string $url Incoming URL
     * @return void
     */
    public static function dispatch(string $url): void
    {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {
            $controller = 'Readme\app\controllers\\' . self::upperCamelCase(self::$route['controller']) . 'Controller';
            if (class_exists($controller)) {
                $cur_contr = new $controller(self::$route);
                $action = 'action' . self::upperCamelCase(self::$route['action']);
                if (method_exists($cur_contr, $action)) {
                    $cur_contr->$action();
                } else {
                    echo "Method of controller <b><i>$controller::$action</i></b> not found"; // TODO Exception
                }
            } else {
                echo "Class of controller <b><i>$controller</i></b> not found"; // TODO Exception
            }
        } else {
            http_response_code(404);
            include '404.html'; // TODO Refactoring
        }
    }

    /**
     * Converts names to the form CamelCase
     *
     * @param string $name String fo convert
     * @return string
     */
    protected static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * Excludes request parameters from the URL
     *
     * @param string $url URL
     * @return string
     */
    protected static function removeQueryString(string $url): string
    {
        if ($url) {
            $params = explode('?', $url);
            if (false === strpos($params[0], '=')) {

                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }

        return $url;
    }
}
