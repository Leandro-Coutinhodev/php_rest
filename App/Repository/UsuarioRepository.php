<?php

namespace App\Repository;
use App\Models\UserModel;
use PDO;
use PDOException;
use Core\Database\ConnectionDb;
use Core\Repository\CRUDRepository;
use Support\Utils\ConstantsUtil;

class UsuarioRepository extends CRUDRepository
{
  protected const TABLE = 'usuario';
  protected const ID = 'id';
  protected const COLUMNS = ['nome', 'idade'];

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
      'retorno' => ConstantsUtil::MSG_RETORNO_SALVO_SUCESSO
    ]);
  }

}