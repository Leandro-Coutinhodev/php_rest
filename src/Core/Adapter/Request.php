<?php

namespace Core\Adapter;
use Support\Utils\JsonUtil;
use Support\Utils\RoutesUtil;

class Request
{
  public static function requestBody()
  {
    return JsonUtil::requestBody();
  }

  public static function response($data = null, int $status = null)
  {
    JsonUtil::response($data, $status);
  }

  public static function getUrlParameter(...$params)
  {

    return RoutesUtil::getParameterRequest(...$params);
  }
}