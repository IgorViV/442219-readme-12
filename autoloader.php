<?php
/**
 * Autoloader
 *
 * @param class Class name
 */
function autoloader($class)
{
    $class = str_replace("Readme\\", '', $class);
    $class = str_replace("\\", '/', $class);
    $file = __DIR__ . "/{$class}.php";

    if (file_exists($file)) {
        require_once $file;
    }
}
