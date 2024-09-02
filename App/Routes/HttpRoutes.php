<?php
namespace App\Routes;
use App\Controllers\TesteController;
use App\Routes\Routes;

class HttpRoutes
{
  public function __construct()
  {
    //REQUISIÇÕES GET AQUI:
    $router = Routes::get('/', [TesteController::class, 'index']);
    $router = Routes::get('/usuario/retornar/1', [TesteController::class, 'getOne']);

    //REQUISIÇÕES POST AQUI:
    $router = Routes::post('/usuario/criar', [TesteController::class, 'new']);

    //REQUISIÇÕES PUT AQUI:
    $router = Routes::put('/teste/lista', [TesteController::class, 'update']);

    //REQUISIÇÕES DELETE AQUI:
  }
}