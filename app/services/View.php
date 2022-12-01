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
    public array $route = [];

    /**
     * Current view
     *
     * @var string|null
     */
    public ?string $view;

    /**
     * Current layout
     *
     * @var string|null
     */
    public ?string $layout;

    public function __construct(array $route, ?string $layout = '', ?string $view = '')
    {
        $this->route = $route;
        if ($layout === '') {
            $this->layout = null;
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
    public function render(array $data): void
    {
        if (is_array($data)) {
            extract($data);
        }

        $content = $this->includeTemplate($data);

        if ($this->layout !== null) {
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
