<?php

namespace Core\Adapter;
use Support\Utils\RoutesUtil;

class Http
{

  public static function getUrlParameter(...$params)
  {

    return RoutesUtil::getParameterRequest(...$params);
  }
}
