<?php
/**
 * AUTOLOAD DE CLASSES
 */

function autoload($class)
{
  $classPath = str_replace('\\', DS, $class) . '.php';

  $file = DIR_APP . DS . $classPath;


  if (file_exists($file) && !is_dir($file)) {
    include $file;
  } else {
    echo "Arquivo da classe não encontrado: $file";
  }
}

spl_autoload_register('autoload');
