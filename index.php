<?php
use App\Services\Services;
use Core\Attributes\RoutesScan;
use Core\Container\Container;
use Core\Routes\HttpRoutes;
use Core\Routes\Routes;

require_once 'bootstrap/bootstrap.php';

global $container;
$container = new Container;
$container->load((new Services)->getServices());
//inicia a aplicação
try {
  //require __DIR__ . '/App/Services/Definitions.php';
  RoutesScan::scanClassAndMethod(__DIR__ . '/App/Controllers', $container);
  $httpRoutes = $container->getContainer()->get(HttpRoutes::class);
  $httpRoutes->registerRoutes();
  Routes::dispatch();
} catch (Exception $e) {

  throw new Exception($e->getMessage());
}
