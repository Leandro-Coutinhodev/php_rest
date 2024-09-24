<?php

namespace Core\Services;

use App\Routes\http;
use Core\DB\Connection;
use Core\Repository\CRUDRepository;
use Core\Routes\HttpRoutes;
use function DI\autowire;
class Services
{

  public function getService()
  {

    return [
      HttpRoutes::class => autowire(http::class),
      Connection::class => autowire(Connection::class),
      CRUDRepository::class => autowire(CRUDRepository::class),
    ];
  }
}