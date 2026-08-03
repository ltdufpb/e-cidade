<?php

class TabelaValoresRRARepository extends TabelaValoresRepository {

  #[\Override]
  public static function getInstancia() {

    if (!DBRegistry::get("TabelaValoresRRARepository")){
      DBRegistry::add("TabelaValoresRRARepository", new static());
    }

    return DBRegistry::get("TabelaValoresRRARepository");
  }

  #[\Override]
  public function getMaker($oTabela) {

    return function($oDadosTabela) use ($oTabela) {

      $oFaixa = new FaixaValorIRRF();
      $oFaixa->setInicio($oDadosTabela->db150_inicio);
      $oFaixa->setFim($oDadosTabela->db150_final);
      $oFaixa->setPercentual($oDadosTabela->rh175_percentual);
      $oFaixa->setDeducao($oDadosTabela->rh175_deducao);
      return $oTabela->addFaixa($oFaixa);
    };
  }

  #[\Override]
  protected function getTabela($iCodigo) {
    return new TabelaIRRFRRA($iCodigo);
  }
}
