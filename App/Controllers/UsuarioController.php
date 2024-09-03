<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Repository\UsuarioRepository;
use App\Utils\JsonUtil;
use App\Utils\RoutesUtil;

class UsuarioController
{

  public function novoUsuario()
  {

    $data = JsonUtil::decodeRequestBody();
    $usuario = new UserModel();
    $usuario->setNome($data['nome']);
    $usuario->setIdade($data['idade']);

    $newUsuario = new UsuarioRepository();
    $newUsuario->create($usuario);
  }

  public function retornarUsuarios()
  {
    $usuarios = new UsuarioRepository();
    $data = $usuarios->getAll();
    JsonUtil::jsonResponse($data);
  }

  public function retornarUsuario()
  {
    $usuario = new UsuarioRepository();
    $data = $usuario->getById(RoutesUtil::getIdRequest());
    JsonUtil::jsonResponse($data);
  }
}