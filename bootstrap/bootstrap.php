<?php

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', dirname(__DIR__));


define('DB_HOST', 'localhost');
define('DB_NAME', 'rest');
define('DB_USER', 'postgres');
define('DB_PASS', 'root');


const AUTOLOAD_DIR = __DIR__ . '/../vendor/autoload.php';
if (file_exists(AUTOLOAD_DIR)) {
  include AUTOLOAD_DIR;
} else {
  echo 'erro ao incluir bootstrap';
}