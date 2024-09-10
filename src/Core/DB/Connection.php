<?php

namespace Core\DB;
use Exception;
use PDO;

class Connection
{

  private PDO $pdo;

  public function __construct()
  {

    switch (DB) {
      case 'postgres':
        $dsn = 'pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        break;

      case 'mysql':
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        break;

      case 'oracle':
        $dsn = 'oci:dbname=//' . DB_HOST . ':1521/' . DB_NAME;
        break;

      case 'sqlite':
        $dsn = 'sqlite:' . DB_NAME;
        break;

      case 'sqlserver':
        $dsn = 'sqlsrv:Server=' . DB_HOST . ';Database=' . DB_NAME;
        break;

      default:
        throw new Exception("Tipo de banco de dados não definido ou não suportado: " . DB);
    }


    try {

      $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
    } catch (\PDOException $e) {

      throw new Exception('error:' . $e->getMessage());
    }
  }

  public function getConnection()
  {

    return $this->pdo;
  }
}