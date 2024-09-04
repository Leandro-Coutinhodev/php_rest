<?php
namespace App\Routes;
use App\Controllers\TesteController;
use App\Controllers\UsuarioController;
use App\Routes\Routes;

class HttpRoutes
{
  public function __construct()
  {
    //REQUISIÇÕES GET AQUI:
    Routes::get('/usuarios/listar', [UsuarioController::class, 'retornarUsuarios']);
    Routes::get('/usuarios/listar/{id}', [UsuarioController::class, 'retornarUsuario']);
    Routes::post('/', [TesteController::class, 'index']);


    //REQUISIÇÕES POST AQUI:
    Routes::post('/usuarios/criar', [UsuarioController::class, 'novoUsuario']);


    //REQUISIÇÕES PUT AQUI:
    Routes::put('/teste/lista', [TesteController::class, 'update']);

    //REQUISIÇÕES DELETE AQUI:
    Routes::delete('/usuarios/excluir/{id}', [UsuarioController::class, 'excluirUsuario']);
  }
}