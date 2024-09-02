<?php

namespace App\Repository;
use App\Utils\ConstantsUtil;
use PDO;

class DbRepository
{

  protected $conn;

  public function getAll()
  {

    if (static::TABLE) {
      $Sql = 'SELECT * FROM ' . static::TABLE . ';';

      try {

        $result = $this->conn->query($Sql);
      } catch (\PDOException $e) {

        throw new \Exception($e->getMessage());
      }

      if ($result->rowCount() > 0) {

        return $result->fetchAll(PDO::FETCH_ASSOC);
      } else {

        echo ConstantsUtil::MSG_ERRO_SEM_RETORNO;
      }

    }
  }

  public function getById($id)
  {

    $Sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id = :id;';
    $stmt = $this->conn->prepare($Sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    try {

      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {

      throw new \Exception($e->getMessage());
    }

    if (count($result) > 0) {

      return $result;
    } else {

      echo ConstantsUtil::MSG_ERRO_SEM_RETORNO;
    }

  }
}