<?php

namespace App\Models;

class UserModel
{

  private int $id;
  private string $nome;
  private int $idade;

  public function __construct()
  {
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $value)
  {
    $this->id = $value;
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function setNome(string $value)
  {
    $this->nome = $value;
  }

  public function getIdade(): int
  {
    return $this->idade;
  }

  public function setIdade(int $value)
  {
    $this->idade = $value;
  }
}