<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 18/12/2017
 * Time: 12:03
 */

namespace App;


use MIG\Init\Bootstrap;

class Route extends Bootstrap
{
    protected function initRoutes(){
        $routes['home'] = array('route'=>'/','controller'=>"indexController",'action'=>'index');
        $routes['cadastro'] = array('route'=>'/cadastro','controller'=>"indexController",'action'=>'cadastro');
        $routes['consulta'] = array('route'=>'/consulta','controller'=>"indexController",'action'=>'consulta');
        $routes['exclusao'] = array('route'=>'/exclusao','controller'=>"indexController",'action'=>'exclusao');
        $routes['contact'] = array('route'=>'/contact','controller'=>"indexController",'action'=>'contact');
        $this->setRoutes($routes);

    }

}