<?php

namespace App\Domain\Patrimonial\Patrimonio\Factories;

use Exception;
use App\Domain\Patrimonial\Patrimonio\Builders\EtiquetaModelo01Builder;
use App\Domain\Patrimonial\Patrimonio\Builders\EtiquetaModelo02Builder;

class EtiquetaFactory
{
    const MODELO01 = 1;
    const MODELO02 = 2;

    public static function getEtiqueta($tipo)
    {
        return match ($tipo) {
            self::MODELO01 => new EtiquetaModelo01Builder(),
            self::MODELO02 => new EtiquetaModelo02Builder(),
            default => throw new Exception('Erro ao gerar Relatório! Selecione um tipo válido.'),
        };
    }
}
