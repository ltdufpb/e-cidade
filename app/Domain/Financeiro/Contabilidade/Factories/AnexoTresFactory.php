<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use App\Domain\Financeiro\Contabilidade\Contracts\AnexosFactoryInterface;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresInRsService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresMdf2022Service;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresMdfService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresService;
use Exception;

class AnexoTresFactory extends AnexosFactory implements AnexosFactoryInterface
{
    const OPCAO_MODELO = 'modelo_rreo_anexo3';

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
        return match (self::getModelo($exercicio)) {
            'in13' => static::getCodigoRelatorioInRS($exercicio),
            'mdf' => static::getCodigoRelatorioMDF($exercicio),
            default => throw new Exception("Não foi implementado o modelo para configuração atual."),
        };
    }

    #[\Override]
    public static function getProgramaRelatorio($exercicio)
    {
        return 'pla2_anexos_rreo_consolida001.php';
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioMDF($exercicio)
    {
        return match ($exercicio) {
            2021 => 259,
            2022 => 262,
            default => 262,
        };
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioInRS($exercicio)
    {
        return match ($exercicio) {
            2021 => 258,
            default => 258,
        };
    }

    private static function getRota($exercicio)
    {
        return match (self::getModelo($exercicio)) {
            'in13' => 'financeiro/contabilidade/relatorio/rreo/anexo-3-in-rs',
            'mdf' => 'financeiro/contabilidade/relatorio/rreo/anexo-3-mdf',
            default => throw new Exception("Não foi implementado o modelo para configuração atual."),
        };
    }

    /**
     * @param $exercicio
     * @param $filtros
     * @return AnexoTresMdf2022Service|AnexoTresMdfService|AnexoTresService
     * @throws Exception
     */
    public static function getService($exercicio, $filtros)
    {
        $modelo = self::getModelo($exercicio);
        switch ($modelo) {
            case 'in13':
                return self::getServiceIn($exercicio, $filtros);
            case 'mdf':
                return self::getServiceMdf($exercicio, $filtros);
        }
    }

    /**
     * Retorna o service responsável pelo processamento do modelo MDF
     * @throws Exception
     * @return AnexoTresService
     */
    public static function getServiceMdf($exercicio, $filtros)
    {
        return match ($exercicio) {
            2021 => new AnexoTresMdfService($filtros),
            default => new AnexoTresMdf2022Service($filtros),
        };
    }

    /**
     * @param $exercicio
     * @param $filtros
     * @return AnexoTresService
     * @throws Exception
     */
    public static function getServiceIn($exercicio, $filtros)
    {
        return new AnexoTresInRsService($filtros);
    }

    /**
     * O Anexo III processa apenas períodos bimestrais e mensais
     *
     * Outros relatórios que precisem acessar os dados da RCL, mas possuem períodos incompatíveis, devem usar esse
     * método para converter períodos Semestral e Quadrimestral o equivalente mensal
     *
     * @param $codigo
     * @return int
     * @throws Exception
     */
    public static function transformPeriodo($codigo)
    {
        if (in_array($codigo, [6, 7, 8, 9, 10, 11, 17,  18,  19,  20,  21,  22,  23,  24,  25,  26, 27, 28])) {
            return $codigo;
        }
        return match ($codigo) {
            //1º SEMESTRE
            12 => 22,
            //3º QUADRIMESTRE
            13, 16 => 28,
            //1º QUADRIMESTRE
            14 => 20,
            //2º QUADRIMESTRE
            15 => 24,
            default => throw new \Exception("Período não mapeado"),
        };
    }
}
