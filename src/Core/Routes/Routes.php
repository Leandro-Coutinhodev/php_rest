<?php

namespace Core\Routes;
use Core\Container\Container;
use DirectoryIterator;
use Exception;
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


  public static function dispatch()
  {

    $uri = RoutesUtil::getUriRequest();
    $method = RoutesUtil::getMethodRequest();


    if (isset(self::$routes[$method][$uri])) {

      $action = self::$routes[$method][$uri];
      $controller = $action[0];
      $actionMethod = $action[1];

      global $container;
      $controllerInstance = $container->getContainer()->get($controller);
      if (method_exists($controllerInstance, $actionMethod)) {

        $controllerInstance->$actionMethod();
      } else {
        throw new Exception('M´rtodo não encontrado.');
      }


    } else {
      http_response_code(404);
    }
  }
}