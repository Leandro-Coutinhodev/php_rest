<?php

namespace Core\Attributes;
use Core\Container\Container;
use DirectoryIterator;
use ReflectionClass;

class RoutesScan
{
  public static function scanClassAndMethod(string $ControllerPath, Container $container)
  {
    $directory = new DirectoryIterator($ControllerPath);
    foreach ($directory as $file) {
      if ($file->isFile() && $file->getExtension() == 'php') {
        $classname = 'App\\Controllers\\' . $file->getBasename('.php');
        $controller = $container->getContainer()->get($classname);
        self::registerRoutesAttributes($controller);
      }
    }
  }
  private static function registerRoutesAttributes(object $controller): void
  {

    $reflection = new ReflectionClass($controller);
    foreach ($reflection->getMethods() as $method) {
      $attributes = $method->getAttributes(RequestMapping::class);
      foreach ($attributes as $attribute) {
        $routerInstance = $attribute->newInstance();
        $routerInstance->registerRouteAttribute($reflection->getName(), $method->getName());
      }
    }


  }
}
