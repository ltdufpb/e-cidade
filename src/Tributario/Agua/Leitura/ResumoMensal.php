<?php

namespace ECidade\Tributario\Agua\Leitura;

use AguaLeitura;
use DBDate;

class ResumoMensal {

  /**
   * @var AguaLeitura[]
   */
  private $aLeituras;

  /**
   * @param integer $iMes
   * @param integer $iAno
   */
  public function __construct(private $iMes, private $iAno)
  {
  }

  /**
   * @return int
   */
  public function getMes() {
    return $this->iMes;
  }

  /**
   * @return int
   */
  public function getAno() {
    return $this->iAno;
  }

  /**
   * @param AguaLeitura $oLeitura
   */
  public function adicionarLeitura(AguaLeitura $oLeitura) {
    $this->aLeituras[] = $oLeitura;
  }

  /**
   * @return DBDate
   */
  public function getDataLeitura() {

    return DBDate::createFromTimestamp(max(array_map(fn(AguaLeitura $oLeitura) => $oLeitura->getDataLeitura() ? $oLeitura->getDataLeitura()->getTimeStamp() : 0, $this->aLeituras)));
  }

  /**
   * @return int|null
   */
  public function getRegra() {

    $iRegra = $this->aLeituras ? $this->aLeituras[0]->getSituacaoLeitura()->getRegra() : null;
    foreach ($this->aLeituras as $oLeitura) {

      $iRegra = $oLeitura->getSituacaoLeitura()->getRegra();
      if ($oLeitura->getSituacaoLeitura()->getRegra() == AguaLeitura::REGRA_NORMAL) {
        $iRegra = AguaLeitura::REGRA_NORMAL;
        break;
      }
    }
    return $iRegra;
  }

  /**
   * @return int
   */
  public function getConsumo() {

    return array_sum(array_map(fn(AguaLeitura $oLeitura) => $oLeitura->getConsumo(), $this->aLeituras));
  }

  /**
   * @return int
   */
  public function getLeitura() {

    return min(array_map(fn(AguaLeitura $oLeitura) => $oLeitura->getLeitura(), $this->aLeituras));
  }
}
