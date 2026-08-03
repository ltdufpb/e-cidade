<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use App\Domain\Financeiro\Contabilidade\Contracts\AnexosFactoryInterface;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoSeis\AnexoSeisService;

class AnexoSeisFactory extends AnexosFactory implements AnexosFactoryInterface
{
    /**
     * @param $exercicio
     * @return array
     */
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio($exercicio);
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = 'financeiro/contabilidade/relatorio/rreo/anexo-6';
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    /**
     * @param $exercicio
     * @return int
     */
    public static function getCodigoRelatorio($exercicio)
    {
        return match ($exercicio) {
            default => 264,
        };
    }

    /**
     * @param $exercicio
     * @return string
     */
    #[\Override]
    public static function getProgramaRelatorio($exercicio)
    {
        return 'pla2_anexos_rreo001.php';
    }

    /**
     * @param $exercicio
     * @param $filtros
     * @return AnexoSeisService
     */
    public static function getService($exercicio, $filtros)
    {
        return match ($exercicio) {
            default => new AnexoSeisService($filtros),
        };
    }
}
