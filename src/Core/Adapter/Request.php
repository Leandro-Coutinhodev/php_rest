<?php

namespace Core\Adapter;
use Support\Utils\JsonUtil;

class Request
{
  public static function requestBody()
  {
    return JsonUtil::requestBody();
  }

  public static function response(array $data, int $status = null)
  {
    JsonUtil::response($data, $status);
  }
}