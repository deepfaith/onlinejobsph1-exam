<?php

// Load config
require_once 'config/config.php';

// Load helpers
require_once 'helpers/redirect.php';
require_once 'helpers/session.php';

// Autoloading
define('ROOT', dirname(__DIR__));
define('SLASH', DIRECTORY_SEPARATOR);

spl_autoload_register(function ($className)
{
    $fileName = sprintf("%s%sapp%s%s.php", ROOT, SLASH, SLASH, str_replace("\\", "/", $className));

    if (file_exists($fileName))
    {
        require ($fileName);
    }
    else
    {
        echo "file not found {$fileName}";
    }
});