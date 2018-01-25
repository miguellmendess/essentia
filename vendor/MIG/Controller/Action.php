<?php

namespace MIG\Controller;


abstract class Action
{
    protected $view;
    private $action;

    public function __construct()
    {
        $this->view = new \stdClass;
    }

    protected function render($action, $layout = true)
    {
        $this->action = $action;
        if($layout == false && file_exists("../Views/layout.phtml")){
            include_once "../App/Views/layout.phtml";
        }else{
            $this->content($action);
        }

    }

    protected function content($action)
    {
        $currentUrl = get_class($this);
        $singleClassName = strtolower((str_replace("Controller","",str_replace("App\\Controllers\\","",$currentUrl))));
        include_once "../App/Views/".$singleClassName."/".$this->action.".phtml";

    }


}