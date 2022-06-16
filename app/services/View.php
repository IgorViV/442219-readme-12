<?php
namespace Readme\app\services;

/**
 *
 */
class View
{
    /**
     * Current route
     *
     * @var array
     */
    public $route = [];

    /**
     * Current view
     *
     * @var string
     */
    public $view;

    /**
     * Current layout
     *
     * @var string
     */
    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?? LAYOUT;
        }
        $this->view = $view;
    }

    /**
     * Rendering of template
     *
     * @param array $data Data
     */
    public function render(array $data)
    {
        if (is_array($data)) {
            extract($data);
        }

        $content = $this->includeTemplate($data);

        if ($this->layout !== false) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "<p>Not found layout <b>{$file_layout}</b></p>";
            }
        }
    }

    /**
     * Include template
     */
    public function includeTemplate(array $data, string $file_name = ''): string
    {
        $cur_contr = lcfirst($this->route['controller']);
        $file_name = $file_name ?
            APP . "/views/{$cur_contr}/{$file_name}" :
            APP . "/views/{$cur_contr}/{$this->view}.php";

        if (!is_readable($file_name)) {
            return '';
        }

        ob_start();
        extract($data);
        require $file_name;

        return ob_get_clean();
    }
}
