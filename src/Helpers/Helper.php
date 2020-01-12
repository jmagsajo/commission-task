<?php

declare(strict_types=1);

define('ROOT_PATH', __DIR__);

if (!function_exists('config')) {
    function config($name)
    {
        $path = ROOT_PATH.'/../../config.php';
        $file = include $path;

        if ($file && isset($file[$name])) {
            return $file[$name];
        }

        return false;
    }
}
