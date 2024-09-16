<?php

namespace App\Repository;
use Core\DB\Connection;
use Core\Repository\CRUDRepository;
use DI\Attribute\Inject;

class UserRepository extends CRUDRepository
{

  protected const TABLE = 'usuario';
  protected const PK = 'id';
  protected const COLUMNS = ['nome', 'idade'];

  #[Inject]
  public function __construct(Connection $connection)
  {
    $this->DB = $connection->getConnection();
  }

  public function teste($var)
  {
    echo $var;
  }
}