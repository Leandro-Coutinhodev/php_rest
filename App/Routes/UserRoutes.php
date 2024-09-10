<?php

namespace App\Routes;
use App\Controllers\TesteController;
use Core\Routes\HttpRoutes;
use Core\Routes\Routes;

class UserRoutes implements HttpRoutes
{

  public function registerRoutes(): void
  {
    Routes::get('/teste/lista/{id}', [TesteController::class, 'teste']);
  }

}