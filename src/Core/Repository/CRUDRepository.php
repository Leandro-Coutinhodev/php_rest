<?php

namespace Core\Repository;
use Exception;
use PDO;
use PDOException;
use Support\Utils\ConstantsUtil;
use Support\Utils\JsonUtil;

class CRUDRepository
{

  protected $conn;


  public function save(object $object)
  {
    // Trabalhar aqui posteriormente
    if (static::TABLE && static::COLUMNS) {

      $columns = '';
      $valparams = '';
      foreach (static::COLUMNS as $column) {
        $columns .= ', ' . $column;
        $valparams .= ', :' . $column;
      }

      $columns = ltrim($columns, ', ');
      $valparams = ltrim($valparams, ', ');
      $Sql = 'INSERT INTO ' . static::TABLE . ' (' . $columns . ') VALUES (' . $valparams . ');';
      $this->conn->beginTransaction();
      try {

        $stmt = $this->conn->prepare($Sql);
        foreach (static::COLUMNS as $column) {

          $method = 'get' . ucfirst($column);
          $value = $object->$method();

          $type = PDO::PARAM_STR;

          if (is_int($value)) {
            $type = PDO::PARAM_INT;
          } elseif (is_bool($value)) {
            $type = PDO::PARAM_BOOL;
          } elseif (is_null($value)) {
            $type = PDO::PARAM_NULL;
          }

          $stmt->bindValue(':' . $column, $value, $type);

        }

        $stmt->execute();
        $this->conn->commit();

      } catch (PDOException $e) {
        $this->conn->rollBack();
        throw new Exception('Erro: ' . $e->getMessage());
      }

      if ($stmt->rowCount() > 0) {
        http_response_code(200);
        return true;
      } else {
        http_response_code(400);
        return false;
      }
    }

  }
  public function getAll()
  {

    if (static::TABLE) {
      $Sql = 'SELECT * FROM ' . static::TABLE . ';';

      try {

        $result = $this->conn->query($Sql);
      } catch (PDOException $e) {

        throw new Exception($e->getMessage());
      }

      if ($result->rowCount() > 0) {

        return $result->fetchAll(PDO::FETCH_ASSOC);
      } else {

        echo ConstantsUtil::MSG_RETORNO_NAO_AFETADO;
      }

    } else {
      throw new Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);
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

      } catch (PDOException $e) {

        throw new Exception($e->getMessage());
      }

      if (count($result) > 0) {

        return $result;
      } else {

        JsonUtil::jsonResponse([
          'retorno' => ConstantsUtil::MSG_RETORNO_NAO_AFETADO
        ]);
      }

    } else {
      throw new Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);

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
      } catch (PDOException $e) {

        $this->conn->rollBack();
        throw new Exception($e->getMessage());

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
      throw new Exception('Erro: ' . ConstantsUtil::MSG_ERRO_CONSTANTES_DB);
    }
  }
}