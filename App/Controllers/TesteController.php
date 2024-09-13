<?php

namespace App\Controllers;
use Core\Adapter\Request;
use Core\Attributes\RequestMapping;
use Support\Utils\RoutesUtil;

class TesteController
{
  #[RequestMapping('/teste', 'GET')]
  public function index()
  {
    $data = Request::requestBody();
    return Request::response($data);
  }

  #[RequestMapping('/testando/aqui', 'POST')]
  public function teste()
  {
    echo "funcionando";
  }

  #[RequestMapping('/testando/url/{id}', 'PUT')]
  public function update()
  {
    echo 'url:' . RoutesUtil::getIdRequest();
  }
}