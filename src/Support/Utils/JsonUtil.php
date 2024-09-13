<?php

namespace Support\Utils;

class JsonUtil
{

  public static function requestBody()
  {

    try {

      $data = json_decode(file_get_contents('php://input'), true);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    if (is_array($data) && count($data) > 0)
      return $data;
  }

  public static function response(array $data, int $status = null)
  {

    try {

      echo json_encode($data);
      http_response_code($status);

    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

}