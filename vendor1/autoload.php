<?php
/**
 * AUTOLOAD DE CLASSES
 */

function autoload($class)
{

  $json = file_get_contents(__DIR__ . DS . 'namespaces.json');
  $namespaceMap = json_decode($json, true);

  foreach ($namespaceMap as $namespace => $path) {

    if (strpos($class, $namespace . '\\') === 0) {

      $classPath = str_replace('\\', DS, $class) . '.php';
      $classPath = str_replace($namespace, $path, $classPath);

      $file = DIR_APP . DS . $classPath;

      if (file_exists($file) && !is_dir($file)) {
        require_once $file;
      } else {
        echo "Arquivo da classe não encontrado: $file";
      }

    }

  }
}


spl_autoload_register('autoload');
