<?php
namespace Readme\app\controllers;

use Readme\app\services\View;

/**
 * BaseController
 *
 *
 */
abstract class BaseController
{
    protected string $title_page = 'Readme';
    protected array $route = [];
    protected ?string $layout = null;
    protected ?string $view = null;
    protected array $data = [];
    protected bool $is_auth = false;
    protected bool $is_search = true;
    protected bool $is_reg = false;          // The registration button is set
    protected string $uri_page = '';

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    /**
     * Description of getView()
     */
    public function getView(): void
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
