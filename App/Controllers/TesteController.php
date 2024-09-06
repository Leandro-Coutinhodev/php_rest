<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Repository\UsuarioRepository;
use Support\Utils\JsonUtil;
use Support\Utils\RoutesUtil;


class TesteController
{
  public function index()
  {

    /**
     * LEIA! melhorar a estrutura da api: (tratamento de erros, pegar id da requisição, etc...) 
     */


    $data = JsonUtil::decodeRequestBody();
    $user = new UserModel();
    $user->setNome($data['nome']);
    $user->setIdade($data['idade']);
    $repo = new UsuarioRepository();
    $repo->save($user);
    /*$data = $repo->getAll();
    JsonUtil::jsonResponse($data);
    JsonUtil::jsonResponse($data);*/
  }

  public function getOne()
  {
    $repo = new UsuarioRepository();
    $data = $repo->getById(RoutesUtil::getIdRequest());
    JsonUtil::jsonResponse($data);
  }

  public function new()
  {

    $data = JsonUtil::decodeRequestBody();
    $usuario = new UserModel();
    $usuario->setNome($data['nome']);
    $usuario->setIdade($data['idade']);
    $new = new UsuarioRepository();
    $new->create($usuario);
  }
  public function update()
  {

  }
}
