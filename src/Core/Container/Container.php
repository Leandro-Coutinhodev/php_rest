<?php

namespace Core\Container;
use Core\Services\Services;
use DI\ContainerBuilder;

class Container
{

  public \DI\Container $container;


  private function build(array $services)
  {

    $container = new ContainerBuilder();
    $container->useAutowiring(true);
    $container->useAttributes(true);
    $container->addDefinitions($services);
    $this->container = $container->build();


  }

  public function load(array $services = [])
  {

    $default = (new Services)->getService();
    $allServices = array_merge($default, $services);
    $this->build($allServices);
  }

  public function getContainer()
  {
    return $this->container;
  }
}