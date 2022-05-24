<?php
namespace Readme\app\controllers;

use Readme\app\services\View;

/**
 * Description of BaseController
 */
abstract class BaseController
{
    protected $route = [];
    protected $layout;
    protected $view;
    protected $data = [];

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    /**
     * Description of getView()
     */
    public function getView()
    {
        $cur_view = new View($this->route, $this->layout, $this->view);
        $cur_view->render($this->data);
    }

    /**
     * Description of getTemplate()
     */
    public function getTemplate(string $name_template, array $data = [])
    {
        $cur_view = new View($this->route, $name_template);
        return $cur_view->includeTemplate($data, $name_template);
    }

    /**
     * Description of setData()
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
