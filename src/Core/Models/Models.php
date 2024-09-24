<?php

namespace Core\Models;

abstract class Models implements \JsonSerializable
{

  public function jsonSerialize(): array
  {
    $reflection = new \ReflectionClass($this);
    $propertie = $reflection->getProperties();
    $data = [];

    foreach ($propertie as $prop) {
      $prop->setAccessible(true);
      $data[$prop->getName()] = $prop->getValue($this);
    }
    return $data;
  }
}