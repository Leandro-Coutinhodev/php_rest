<?php

namespace App\Db;

class ConnectionDb
{

  private $pdo;

  public function __construct()
  {

    $dsn = 'pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME;

    try {

      $this->pdo = new \PDO($dsn, DB_USER, DB_PASS);
    } catch (\PDOException $e) {

      throw new \Exception('error:' . $e->getMessage());
    }
  }

  public function getConnection()
  {

    return $this->pdo;
  }
}