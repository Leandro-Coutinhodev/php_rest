<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Repository\UserRepository;
use Core\Adapter\Http;
use Core\Adapter\Request;
use Core\Attributes\RequestMapping;
use DI\Attribute\Inject;

class TesteController
{

  #[Inject]
  private UserRepository $userRepository;

  #[RequestMapping('/usuarios/{user}/lista/{id}', 'GET')]
  public function listarUsuarios()
  {
    $parameter = Http::getUrlParameter('user', 'id');
    $data = $this->userRepository->getAll();
    return Request::response($data);
  }

  #[RequestMapping('/usuarios/salvar', 'POST')]
  public function salvarUsuario()
  {
    $data = Request::requestBody();
    $user = new UserModel;
    $user->setIdade($data['idade']);
    $user->setNome($data['nome']);
    $this->userRepository->save($user);

  }
}