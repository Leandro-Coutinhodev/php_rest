<?php

namespace Core\Repository;

use Core\Adapter\Request;
use Core\DB\Connection;
use DI\Attribute\Inject;
use Exception;
use PDO;
use PDOException;
use Support\Utils\ConstantsUtil;

class DBRepository
{
  protected PDO $DB;
  protected string $table;
  protected string $pk;
  protected array $columns;

  public function __construct(string $table, string $pk, array $columns)
  {

    $this->DB = (new Connection())->getConnection();
    $this->table = $table;
    $this->pk = $pk;
    $this->columns = $columns;
  }

  public function save(object $object)
  {
    if ($this->table && $this->columns) {
      $columns = implode(', ', $this->columns);
      $valparams = ':' . implode(', :', $this->columns);

      $Sql = "INSERT INTO " . $this->table . " ({$columns}) VALUES ({$valparams});";
      $this->DB->beginTransaction();

      try {
        $stmt = $this->DB->prepare($Sql);
        foreach ($this->columns as $column) {
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
    if ($this->table) {
      $Sql = 'SELECT * FROM ' . $this->table . ';';

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
    if ($this->table && $this->pk) {
      $Sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pk . ' = :id;';
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
        Request::response([
          'retorno' => ConstantsUtil::MSG_RETORNO_NAO_AFETADO
        ]);
      }
    } else {
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }
  }

  public function delete(int $id)
  {
    if ($this->table && $this->pk) {
      $Sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->pk . ' = :id;';
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
        Request::response([
          'retorno' => ConstantsUtil::MSG_RETORNO_DELETADO_SUCESSO
        ]);
      } else {
        Request::response([
          'retorno' => ConstantsUtil::MSG_RETORNOI_DELETADO_ERRO
        ]);
      }
    } else {
      throw new Exception(ConstantsUtil::MSG_ERROR_CONSTANTS_DB);
    }
  }

  public function update(int $id, object $object)
  {
    if ($this->table && $this->pk && $this->columns) {
      $columnValue = '';
      foreach ($this->columns as $column) {
        $columnValue .= $column . ' = :' . $column . ', ';
      }
      $columnValue = rtrim($columnValue, ', ');

      $Sql = "UPDATE " . $this->table . " SET {$columnValue} WHERE " . $this->pk . " = :id";

      $this->DB->beginTransaction();
      try {
        $stmt = $this->DB->prepare($Sql);
        foreach ($this->columns as $column) {
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
