<?php

namespace App\Domain\Saude\TFD\Factories;

use Exception;
use App\Domain\Saude\TFD\Relatorios\ViagensPorMotoristaCSV;
use App\Domain\Saude\TFD\Relatorios\ViagensPorMotoristaPDF;

class ViagensPorMotoristaFactory
{
    const PDF = 1;
    const CSV = 2;

    /**
     * Retorna o relatório de acordo com o tipo passado por parametro(1 = PDF, 2 = CSV)
     * @param integer $tipo
     * @param array $dados
     * @throws Exception
     * @return ViagensPorMotoristaCSV|ViagensPorMotoristaPDF
     */
    public static function getRelatorio($tipo, array $dados)
    {
        return match ($tipo) {
            self::PDF => new ViagensPorMotoristaPDF($dados),
            self::CSV => new ViagensPorMotoristaCSV($dados),
            default => throw new Exception('Erro ao gerar Relatório! Selecione um tipo válido.'),
        };
    }
}
