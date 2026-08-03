<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use Exception;

class AnexoUmRgfFactory extends AnexosFactory
{
    const OPCAO_MODELO = 'modelo_anexo_1_rgf';

    /**
     * @param $exercicio
     * @return array
     * @throws Exception
     */
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio($exercicio);
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = self::getRota($exercicio);
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    /**
     * @param $exercicio
     * @return int
     * @throws Exception
     */
    public static function getCodigoRelatorio($exercicio)
    {
        $opcao = static::getOpcao($exercicio, static::OPCAO_MODELO);

        return match ($opcao->getValor()) {
            'in13' => static::getCodigoRelatorioInRS($exercicio),
            'mdf' => static::getCodigoRelatorioMDF($exercicio),
            default => throw new Exception("Não foi implementado o modelo para configuração atual."),
        };
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioMDF($exercicio)
    {
        return match ($exercicio) {
            2021 => 260,
            default => 260,
        };
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioInRS($exercicio)
    {
        return match ($exercicio) {
            2021 => 261,
            default => 261,
        };
    }

    private static function getRota($exercicio)
    {
        $opcao = static::getOpcao($exercicio, static::OPCAO_MODELO);

        return match ($opcao->getValor()) {
            'in13' => 'financeiro/contabilidade/relatorio/rgf/anexo-1-in-rs',
            'mdf' => 'financeiro/contabilidade/relatorio/rgf/anexo-1-mdf',
            default => throw new Exception("Não foi implementado o modelo para configuração atual."),
        };
    }
}
