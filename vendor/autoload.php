<?php
/**
 * AUTOLOAD DE CLASSES
 * @param $class
 */

function autoload($class)
{
  $classPath = str_replace('\\', DS, $class) . '.php';

  $file = DIR_APP . DS . $classPath;

  // Verifica se o arquivo existe e não é um diretório
  if (file_exists($file) && !is_dir($file)) {
    include $file;
  } else {
    echo "Arquivo da classe não encontrado: $file";
  }
}

spl_autoload_register('autoload');
