<?php
use Core\Routes\Routes;

require_once 'bootstrap/bootstrap.php';

//inicia a aplicação
try {
  Routes::setRoutes();
  Routes::dispatch();
} catch (Exception $e) {

  throw new Exception($e->getMessage());
}
