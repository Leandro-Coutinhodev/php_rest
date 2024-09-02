<?php

namespace App\Utils;

class RoutesUtil
{



  public static function getIdRequest()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $uriparts = explode('/', trim($uri, '/'));
    if (count($uriparts) >= 3 && $uriparts[2] != null) {
      try {
        return intval($uriparts[2]);
      } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
      }
    }
  }

  public static function getUriRequest()
  {
    return $_SERVER['REQUEST_URI'];
  }

  public static function getMethodRequest()
  {

    return $_SERVER['REQUEST_METHOD'];
  }

}
