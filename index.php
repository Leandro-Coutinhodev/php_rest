<?php

use App\Routes\Routes;
use Src\Teste\Teste;

include __DIR__ . '/bootstrap/bootstrap.php';

//inicia a aplicação
try {
  Routes::setRoutes();
  Routes::dispatch();
} catch (Exception $e) {

  throw new Exception($e->getMessage());
}
