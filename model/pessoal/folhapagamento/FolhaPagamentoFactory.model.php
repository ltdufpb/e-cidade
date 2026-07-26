<?php 
/**
 * Fabrica de Objetos de Folha de pagamento
 *
 * @author Rafael Nery <rafael.nery@dbseller.com.br>
 * @package Pessoal
 * @subpackage Folha de Pagamento
 * @version $Id: FolhaPagamentoFactory.model.php,v 1.2 2015/05/12 12:55:05 dbrenan Exp $
 */
abstract class FolhaPagamentoFactory {
  /**
   * Contrói um Objeto pelo código 
   * 
   * @param  [type] $iSequencialFolhaPagamento [description]
   * @return [type]                            [description]
   */
  public static function construirPeloCodigo( $iSequencialFolhaPagamento ) {

    $oDaoFolhaPagamento = new cl_rhfolhapagamento();
    $sSQL               = $oDaoFolhaPagamento->sql_query_file($iSequencialFolhaPagamento);
    
    if ( !$rsFolhaPagamento = db_query($sSQL) ) {
      throw new DBException("Erro ao buscar os dados da Folha de Pagamento.");
    }

    if ( pg_num_rows($rsFolhaPagamento) == 0 ) {
      throw new BusinessException("Nenhuma folha de pagamento encontrada para o código informado");
    }
    
    $oDados = db_utils::fieldsMemory($rsFolhaPagamento, 0);
    return match ($oDados->rh141_tipofolha) {
        FolhaPagamento::TIPO_FOLHA_SALARIO => new FolhaPagamentoSalario($iSequencialFolhaPagamento),
        FolhaPagamento::TIPO_FOLHA_RESCISAO => new FolhaPagamentoRescisao($iSequencialFolhaPagamento),
        FolhaPagamento::TIPO_FOLHA_COMPLEMENTAR => new FolhaPagamentoComplementar($iSequencialFolhaPagamento),
        FolhaPagamento::TIPO_FOLHA_ADIANTAMENTO => new FolhaPagamentoAdiantamento($iSequencialFolhaPagamento),
        FolhaPagamento::TIPO_FOLHA_13o_SALARIO => new FolhaPagamento13o($iSequencialFolhaPagamento),
        FolhaPagamento::TIPO_FOLHA_SUPLEMENTAR => new FolhaPagamentoSuplementar($iSequencialFolhaPagamento),
        default => throw new BusinessException("Tipo de Folha de Pagamento Inválido"),
    };
  }

  /**
   * Retorna um objeto da Folha de Pagamentod de acordo com o tipo da folha de pagamento informado por parâmetro.
   *
   * @param  integer  $iTipoFolhaPagamento
   * @return  FolhaPagamento
   */
  public static function construirPeloTipo( $iTipoFolhaPagamento ) {

    return match ($iTipoFolhaPagamento) {
        FolhaPagamento::TIPO_FOLHA_SALARIO => new FolhaPagamentoSalario(),
        FolhaPagamento::TIPO_FOLHA_RESCISAO => new FolhaPagamentoRescisao(),
        FolhaPagamento::TIPO_FOLHA_COMPLEMENTAR => new FolhaPagamentoComplementar(),
        FolhaPagamento::TIPO_FOLHA_ADIANTAMENTO => new FolhaPagamentoAdiantamento(),
        FolhaPagamento::TIPO_FOLHA_13o_SALARIO => new FolhaPagamento13o(),
        FolhaPagamento::TIPO_FOLHA_SUPLEMENTAR => new FolhaPagamentoSuplementar(),
        default => throw new BusinessException("Tipo de Folha de Pagamento Inválido"),
    };
  }
}
