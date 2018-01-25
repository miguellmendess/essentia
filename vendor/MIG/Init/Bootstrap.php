<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 18/12/2017
 * Time: 20:17
 */

namespace MIG\Init;


abstract class Bootstrap
{

    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function initRoutes();

    protected function setRoutes(array $routes){
        $this->routes = $routes;
    }

    protected function run($url){


        array_walk($this->routes,function($route) use ($url){
            if($url == $route['route']){
                $class = "App\\Controllers\\".ucfirst($route['controller']);
                $controller = new $class;
                $action = $route['action'];
                $controller->$action();
            }
        });
    }

    protected function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

}