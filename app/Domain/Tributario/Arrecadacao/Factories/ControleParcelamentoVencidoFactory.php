<?php

namespace App\Domain\Tributario\Arrecadacao\Factories;

use App\Domain\Tributario\Arrecadacao\Services\AntecipaDataVencidaService;
use App\Domain\Tributario\Arrecadacao\Services\AntecipaVencimentoDataTermoService;
use App\Domain\Tributario\Arrecadacao\Services\AnulacaoParcelamento;

class ControleParcelamentoVencidoFactory
{
    const ANTECIPA_MAIOR_DATA_VENCIDA = 1;
    const ANTECIPA_MENOR_DATA_VENCIDA = 2;
    const ANTECIPA_VENCIMENTO_DATA_TERMO = 3;
    const ANULACAO_PARCELAMENTO = 4;

    /**
     *
     * @param integer $acao
     * @return App\Domain\Tributario\Arrecadacao\Contracts\AcaoControleParcelamento
     */
    public static function getAcaoService($acao)
    {
        return match ($acao) {
            self::ANTECIPA_MAIOR_DATA_VENCIDA => new AntecipaDataVencidaService(self::ANTECIPA_MAIOR_DATA_VENCIDA),
            self::ANTECIPA_MENOR_DATA_VENCIDA => new AntecipaDataVencidaService(self::ANTECIPA_MENOR_DATA_VENCIDA),
            self::ANTECIPA_VENCIMENTO_DATA_TERMO => new AntecipaVencimentoDataTermoService(self::ANTECIPA_VENCIMENTO_DATA_TERMO),
            self::ANULACAO_PARCELAMENTO => new AnulacaoParcelamento(self::ANULACAO_PARCELAMENTO),
            default => throw new \Exception('Erro ao processar ação. Regra de vencimento não cadastrada!'),
        };
    }
}
