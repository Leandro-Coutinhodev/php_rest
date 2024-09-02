<?php

namespace App\Routes;
use App\Utils\RoutesUtil;

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
    $set = new HttpRoutes();
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


    }
  }
}