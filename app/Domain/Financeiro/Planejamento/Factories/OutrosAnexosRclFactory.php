<?php

namespace App\Domain\Financeiro\Planejamento\Factories;

use App\Domain\Financeiro\Planejamento\Relatorios\Anexos\Outros\PrevisaoRclLdo;
use App\Domain\Financeiro\Planejamento\Relatorios\Anexos\Outros\PrevisaoRclLoa;
use Exception;

class OutrosAnexosRclFactory
{
    /**
     * @param $exercicio
     * @return array
     */
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio();
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = self::getRota($exercicio);
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    /**
     * @param $exercicio
     * @return int
     */
    public static function getCodigoRelatorio($exercicio)
    {
        return match ($exercicio) {
            2022 => 267,
            default => 267,
        };
    }
        
    /**
     * getRota
     *
     * @param $exercicio
     * @return string
     */
    private static function getRota($exercicio)
    {
        return match ($exercicio) {
            2022 => 'financeiro/planejamento/relatorios/previsao-rcl-outros-anexos',
            default => 'financeiro/planejamento/relatorios/previsao-rcl-outros-anexos',
        };
    }

    /**
     * view default do relatório
     * @param $exercicio
     * @return string
     */
    public static function getProgramaRelatorio()
    {
        return 'pla2_planejamento_previsao_rcl001.php';
    }
    
    /**
     * Gera a instância compatível com o tipo de relatório recebido(LDO,LOA)
     *
     * @param string $tipo
     * @return PrevisaoRclLdo|PrevisaoRclLoa
     * @throws Exception
     */
    public static function getModeloRelatorio($tipo)
    {
        return match ($tipo) {
            'LDO' => new PrevisaoRclLdo(),
            'LOA' => new PrevisaoRclLoa(),
            default => throw new Exception('Tipo de planejamento não permitido para o relatório escolhido.'),
        };
    }
}
