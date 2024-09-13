<?php

namespace Core\Attributes;
use Attribute;
use Core\Routes\HttpRoutes;
use Core\Routes\Routes;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestMapping
{

  private string $request;
  private string $method;
  private object $controller;
  private string $action;
  public function __construct(string $request, string $method)
  {

    $this->request = $request;
    $this->method = $method;

  }
  public function registerRouteAttribute(string $controller, string $action)
  {
    switch ($this->method) {
      case 'GET':
        Routes::get($this->request, [$controller, $action]);
        break;
      case 'POST':
        Routes::post($this->request, [$controller, $action]);
        break;
      case 'PUT':
        Routes::put($this->request, [$controller, $action]);
        break;
      case 'DELETE':
        Routes::delete($this->request, [$controller, $action]);
        break;
      default:
        throw new \Exception('Método http inválido.');
    }
  }

}