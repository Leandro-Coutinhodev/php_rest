<?php

require_once 'require.php';

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', dirname(__DIR__));

$init = Dotenv\Dotenv::createUnsafeMutable(DIR_APP);
$init->load();

define('DB', $_ENV['DB']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

