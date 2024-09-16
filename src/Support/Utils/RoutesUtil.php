<?php

namespace Support\Utils;
use Core\Routes\Routes;

class RoutesUtil
{
  protected static $urlParams = [];
  public static function getParameterRequest(...$params)
  {
    $result = [];
    foreach ($params as $param) {
      if (is_string($param) && isset(self::$urlParams[$param])) {
        $result[$param] = self::$urlParams[$param] ?? null;
      }
    }
    return count($result) === 1 ? reset($result) : $result;
  }

  public static function getUriRequest()
  {
    $routes = array_keys(Routes::$routes[self::getMethodRequest()]);

    $uri = trim($_SERVER['REQUEST_URI'], '/');
    $uriparts = explode('/', $uri);

    foreach ($routes as $route) {
      $routeParts = explode('/', trim($route, '/'));
      if (count($uriparts) !== count($routeParts)) {
        continue;
      }

      $matched = true;
      self::$urlParams = [];

      foreach ($routeParts as $index => $routePart) {
        if (preg_match('/\{(.+?)\}/', $routePart, $matches)) {
          //Seta os parametros recebidos pela url que serão utilizados no controller através do adaptador Http que faz uso do método getParameterRequest 
          self::$urlParams[$matches[1]] = $uriparts[$index] ?? null;
          $uriparts[$index] = $routePart;
        } elseif ($routePart !== $uriparts[$index]) {
          $matched = false;
          break;
        }
      }

      if ($matched) {
        return '/' . implode('/', $uriparts);
      }
    }

    // Se nenhuma rota corresponder, retorna a URI original
    return $uri;
  }

  public static function getMethodRequest()
  {

    return $_SERVER['REQUEST_METHOD'];
  }

}
