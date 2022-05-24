<?php
/**
 * This file
 */
declare(strict_types=1);

require_once 'helpers.php';
require_once 'data.php';
require_once 'app/init.php';

$post_id = filter_input(INPUT_GET, 'id');
if (!$post_id) {
    // method()
}
