<?php

namespace App\Repository;
use App\Db\ConnectionDb;
use App\Models\UserModel;
use PDO;
use PDOException;

class UsuarioRepository extends DbRepository
{
  protected const TABLE = 'usuario';

  public function __construct()
  {

    $this->conn = (new ConnectionDb())->getConnection();
  }

  public function create(UserModel $user)
  {

    $Sql = 'INSERT INTO ' . self::TABLE . ' (nome, idade) VALUES (:nome, :idade);';
    $stmt = $this->conn->prepare($Sql);
    $stmt->bindValue(':nome', $user->getNome(), PDO::PARAM_STR);
    $stmt->bindValue(':idade', $user->getIdade(), PDO::PARAM_INT);

    try {

      $stmt->execute();
    } catch (PDOException $e) {

      throw new \Exception($e->getMessage());
    }
    echo json_encode([
      'msg' => 'sucess'
    ]);
  }
}