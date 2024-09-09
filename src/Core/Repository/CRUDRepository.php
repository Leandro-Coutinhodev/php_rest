<?php

namespace Core\Repository;
use Exception;
use PDO;
use PDOException;
use Support\Utils\ConstantsUtil;
use Support\Utils\JsonUtil;

class CRUDRepository
{

  protected PDO $DB;


  public function save(object $object)
  {
    // Trabalhar aqui posteriormente
    if (static::TABLE && static::COLUMNS) {

      /* $columns = '';
       $valparams = '';*/
      /*foreach (static::COLUMNS as $column) {
        $columns .= ', ' . $column;
        $valparams .= ', :' . $column;
      }*/


      $columns = implode(', ', static::COLUMNS);
      $valparams = ':' . implode(', :', static::COLUMNS);

      $Sql = "INSERT INTO " . static::TABLE . " ({$columns}) VALUES ({$valparams});";
      $this->DB->beginTransaction();
      try {

        $stmt = $this->DB->prepare($Sql);
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
        $this->DB->commit();

      } catch (PDOException $e) {
        $this->DB->rollBack();
        throw new Exception('Erro: ' . $e->getMessage());
      }

      if ($stmt->rowCount() > 0) {
        http_response_code(200);
        return true;
      } else {
        http_response_code(400);
        return false;
      }
    } else {
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }

  }
  public function getAll()
  {

    if (static::TABLE) {
      $Sql = 'SELECT * FROM ' . static::TABLE . ';';

      try {

        $result = $this->DB->query($Sql);
      } catch (PDOException $e) {

        throw new Exception($e->getMessage());
      }

      if ($result->rowCount() > 0) {

        return $result->fetchAll(PDO::FETCH_ASSOC);
      } else {

        echo ConstantsUtil::MSG_RETORNO_NAO_AFETADO;
      }

    } else {
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }
  }

  public function getById(int $id)
  {

    if (static::TABLE && static::PK) {
      $Sql = 'SELECT * FROM ' . static::TABLE . ' WHERE ' . static::PK . ' = :id;';
      $stmt = $this->DB->prepare($Sql);
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
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);

    }
  }

  public function delete(int $id)
  {

    if (static::TABLE && static::PK) {
      $Sql = 'DELETE FROM ' . static::TABLE . ' WHERE ' . static::PK . ' = :id;';
      $this->DB->beginTransaction();
      try {
        $stmt = $this->DB->prepare($Sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $this->DB->commit();
      } catch (PDOException $e) {

        $this->DB->rollBack();
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
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }
  }

  public function update(int $id, object $object)
  {

    if (static::TABLE && static::PK && static::COLUMNS) {

      $columnValue = '';
      foreach (static::COLUMNS as $column) {

        $columnValue .= $column . ' = ' . ':' . $column . ', ';


      }
      $columnValue = rtrim($columnValue, ', ');

      $Sql = "UPDATE " . static::TABLE . " SET {$columnValue} WHERE " . static::PK . " = :id";

      $this->DB->beginTransaction();
      try {

        $stmt = $this->DB->prepare($Sql);

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
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->DB->commit();
      } catch (PDOException $e) {
        $this->DB->rollBack();
        throw new Exception($e->getMessage());
      }

      if ($stmt->rowCount() > 0) {
        http_response_code(200);
        return true;
      } else {
        http_response_code(401);
        return false;
      }
    } else {
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }

  }
}
