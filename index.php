<?php

use App\Routes\Routes;
use Src\Teste\Teste;

include __DIR__ . '/bootstrap/bootstrap.php';

$start = Routes::setRoutes();
$start = Routes::dispatch();