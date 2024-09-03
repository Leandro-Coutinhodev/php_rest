<?php

namespace App\Utils;

abstract class ConstantsUtil
{

  public const MSG_RETORNO_SEM_RETORNO = 'Nenhum dado retornado!';
  public const MSG_RETORNO_NAO_AFETADO = 'Nenhuma linha afetada!';

  public const MSG_RETORNO_DELETADO_SUCESSO = 'Excluído com sucesso!';
  public const MSG_RETORNOI_DELETADO_ERRO = 'Erro ao excluir';
  public const MSG_RETORNO_SALVO_SUCESSO = 'Salvo com sucesso!';
  public const MSG_RETORNO_ATUALIZADO_SUCESSO = 'Atualizado com sucesso!';

  public const MSG_ERRO_CONSTANTES_DB = 'Constantes não definidas(TABLE, ID, COLUMNS)';

}