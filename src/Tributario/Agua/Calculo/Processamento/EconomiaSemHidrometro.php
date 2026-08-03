<?php

namespace ECidade\Tributario\Agua\Calculo\Processamento;

use AguaEstruturaTarifaria;

class EconomiaSemHidrometro extends Economia {

  /**
   * @return array
   */
  #[\Override]
  public function processar() {

    $aEstruturas = $this->oCategoriaConsumo->getEstruturas();

    $oEstrutura = current(array_filter($aEstruturas, fn(AguaEstruturaTarifaria $oEstrutura) => $oEstrutura->getCodigoTipoEstrutura() == AguaEstruturaTarifaria::TIPO_FAIXA_CONSUMO &&
    $oEstrutura->getValorInicial() == 0));

    if ($oEstrutura) {
      $this->setConsumo($oEstrutura->getValorFinal());
    }

    return parent::processar();
  }
}
