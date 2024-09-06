<?php

namespace Support\Utils;

class JsonUtil
{
  public static function decodeRequestBody()
  {

    try {

      $data = json_decode(file_get_contents('php://input'), true);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
    if (is_array($data) && count($data) > 0)
      return $data;
  }

  public static function jsonResponse(array $data)
  {

    try {

      echo json_encode($data);

    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

}