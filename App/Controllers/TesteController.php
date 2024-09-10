<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Repository\UserRepository;
use DI\Attribute\Inject;
use Support\Utils\JsonUtil;
use Support\Utils\RoutesUtil;

class TesteController
{
  private UserModel $user;
  private UserRepository $repo;

  #[Inject]
  public function __construct(
    UserModel $user,
    UserRepository $repo
  ) {


    $this->user = $user;
    $this->repo = $repo;
  }
  public function index()
  {

    $this->user->setNome('Leandro');
    echo "Funcionou com sucesso!" . $this->user->getNome();
  }

  public function teste()
  {
    $data = $this->repo->getById(RoutesUtil::getIdRequest());
    JsonUtil::jsonResponse([$data]);
  }
}