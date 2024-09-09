<?php

const AUTOLOAD_DIR = __DIR__ . '/../vendor/autoload.php';
if (file_exists(AUTOLOAD_DIR)) {
  include AUTOLOAD_DIR;
} else {
  echo 'erro ao incluir bootstrap';
}