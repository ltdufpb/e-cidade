<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use App\Domain\Financeiro\Contabilidade\Contracts\AnexosFactoryInterface;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoQuatro\AnexoQuatro2022Service;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoQuatro\AnexoQuatroService;

class AnexoQuatroFactory extends AnexosFactory implements AnexosFactoryInterface
{
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio($exercicio);
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = 'financeiro/contabilidade/relatorio/rreo/anexo-4';
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    public static function getCodigoRelatorio($exercicio)
    {
        return match ($exercicio) {
            2021 => 244,
            2022 => 263,
            default => 244,
        };
    }

    #[\Override]
    public static function getProgramaRelatorio($exercicio)
    {
        return 'pla2_anexos_rreo_consolida001.php';
    }


    public static function getService($exercicio, $filtros)
    {
        return match ($exercicio) {
            2021 => new AnexoQuatroService($filtros),
            default => new AnexoQuatro2022Service($filtros),
        };
    }
}
