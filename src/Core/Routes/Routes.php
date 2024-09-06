<?php

namespace Core\Routes;
use DirectoryIterator;
use Support\Utils\RoutesUtil;



abstract class Routes
{

  static array $routes;

  public static function get($uri, $action)
  {

    self::$routes['GET'][$uri] = $action;
  }

  public static function post($uri, $action)
  {

    self::$routes['POST'][$uri] = $action;
  }

  public static function put($uri, $action)
  {

    self::$routes['PUT'][$uri] = $action;
  }

  public static function delete($uri, $action)
  {

    self::$routes['DELETE'][$uri] = $action;
  }

  public static function setRoutes()
  {
    $directory = __DIR__ . '/../../../App/Routes';

    foreach (new DirectoryIterator($directory) as $file) {

      if ($file->isFile() && $file->getExtension() === 'php') {

        $class = 'App\\Routes\\' . $file->getBasename('.php');

        if (is_subclass_of($class, HttpRoutes::class)) {

          $classinstance = new $class();
          $classinstance->registerRoutes();

        }

      }
    }

  }

  public static function dispatch()
  {


    $uri = RoutesUtil::getUriRequest();
    $method = RoutesUtil::getMethodRequest();


    if (isset(self::$routes[$method][$uri])) {

      $action = self::$routes[$method][$uri];
      $controller = $action[0];
      $actionMethod = $action[1];
      $controllerInstance = new $controller();
      $controllerInstance->$actionMethod();


    } else {
      http_response_code(404);
    }
  }
}