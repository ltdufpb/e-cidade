<?php

namespace ECidade\Tributario\Agua\Calculo;

use ECidade\Tributario\Agua\Calculo\Estrutura\Estrutura;
use ECidade\Tributario\Agua\Calculo\Estrutura\FaixaConsumo;
use ECidade\Tributario\Agua\Calculo\Estrutura\ValorFixo;
use ECidade\Tributario\Agua\Calculo\Estrutura\Percentual;
use \AguaEstruturaTarifaria;

class EstruturaFactory {

  /**
   * Cria uma instância de Estrutura de Cálculo de acordo com o tipo de estrutura tarifária.
   *
   * @param  integer $iTipoEstruturaTarifaria Código do tipo de estrutura tarifária
   * @return Estrutura
   * @throws \Exception
   */
  public static function create($iTipoEstruturaTarifaria) {

    return match ($iTipoEstruturaTarifaria) {
        AguaEstruturaTarifaria::TIPO_FAIXA_CONSUMO => new FaixaConsumo,
        AguaEstruturaTarifaria::TIPO_PERCENTUAL => new Percentual,
        AguaEstruturaTarifaria::TIPO_VALOR_FIXO => new ValorFixo,
        default => throw new \Exception('Nenhuma Estrutura de Cálculo aplicável.'),
    };
  }
}
