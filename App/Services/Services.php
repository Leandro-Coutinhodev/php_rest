<?php

namespace App\Services;
use App\Controllers\TesteController;
use App\Models\UserModel;

use App\Repository\UserRepository;
use App\Routes\UserRoutes;
use Core\DB\Connection;
use Core\Repository\CRUDRepository;
use Core\Routes\HttpRoutes;
use function DI\autowire;
class Services
{
  public function getServices()
  {
    return [
      /*UserModel::class => autowire(UserModel::class),
      TesteController::class => autowire(TesteController::class),*/
      //UserRepository::class => autowire(UserRepository::class),


    ];
  }
}