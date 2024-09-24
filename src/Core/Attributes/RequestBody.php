<?php

namespace Core\Attributes;
use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class RequestBody
{

  public function __construct()
  {

    $this->requestBody();
  }

  public function requestBody()
  {
    return RequestBody::requestBody();
  }
}