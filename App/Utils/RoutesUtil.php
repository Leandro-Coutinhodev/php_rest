<?php

namespace App\Utils;

class RoutesUtil
{



  public static function getIdRequest()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $uriparts = explode('/', trim($uri, '/'));
    if (count($uriparts) > 1 && end($uriparts) != null) {
      try {
        return intval(end($uriparts));
      } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
      }
    }
  }


  public static function getUriRequest()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $uriparts = explode('/', trim($uri, '/'));
    if (count($uriparts) > 2 && end($uriparts) != null) {

      $replace = str_replace('/' . end($uriparts), '/{id}', $uri);
      return $replace;

    } else {
      return $uri;
    }

  }

  public static function getMethodRequest()
  {

    return $_SERVER['REQUEST_METHOD'];
  }

}