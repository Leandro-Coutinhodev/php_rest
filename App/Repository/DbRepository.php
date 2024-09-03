<?php

namespace App\Repository;
use App\Utils\ConstantsUtil;
use App\Utils\JsonUtil;
use PDO;

class DbRepository
{

  protected $conn;


  public function save()
  {
    // Trabalhar aqui posteriormente

  }
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

        echo ConstantsUtil::MSG_RETORNO_NAO_AFETADO;
      }

    } else {
      throw new \Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);
    }
  }

  public function getById(int $id)
  {

    if (static::TABLE && static::ID) {
      $Sql = 'SELECT * FROM ' . static::TABLE . ' WHERE ' . static::ID . ' = :id;';
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

        JsonUtil::jsonResponse([
          'retorno' => ConstantsUtil::MSG_RETORNO_NAO_AFETADO
        ]);
      }

    } else {
      throw new \Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);

    }
  }

  public function delete(int $id)
  {

    if (static::TABLE && static::ID) {
      $Sql = 'DELETE FROM ' . static::TABLE . ' WHERE ' . static::ID . ' = :id;';
      $this->conn->beginTransaction();
      try {
        $stmt = $this->conn->prepare($Sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $this->conn->commit();
      } catch (\PDOException $e) {

        $this->conn->rollBack();
        throw new \Exception($e->getMessage());

      }

      if ($stmt->rowCount() > 0) {

        JsonUtil::jsonResponse([
          'retorno' => ConstantsUtil::MSG_RETORNO_DELETADO_SUCESSO
        ]);
      } else {

        JsonUtil::jsonResponse([
          'retorno' => ConstantsUtil::MSG_RETORNOI_DELETADO_ERRO
        ]);
      }
    } else {
      throw new \Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);
    }
  }
}