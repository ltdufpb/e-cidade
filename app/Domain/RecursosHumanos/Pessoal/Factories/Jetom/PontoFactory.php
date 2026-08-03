<?php

namespace App\Domain\RecursosHumanos\Pessoal\Factories\Jetom;

use Exception;
use ECidade\RecursosHumanos\Pessoal\Model\PontoFixo;
use ECidade\RecursosHumanos\Pessoal\Model\PontoSalario;

use ECidade\RecursosHumanos\Pessoal\Model\PontoComplementar;
use ECidade\RecursosHumanos\Pessoal\Repository\PontoFixoRepository;
use ECidade\RecursosHumanos\Pessoal\Repository\PontoSalarioRepository;
use ECidade\RecursosHumanos\Pessoal\Repository\PontoComplementarRepository;

use ECidade\RecursosHumanos\Pessoal\Interfaces\PontoModel;
use ECidade\RecursosHumanos\Pessoal\Interfaces\PontoRepository;

class PontoFactory
{
    const PONTO_SALARIO = 'S';
    const PONTO_FIXO = 'F';
    const PONTO_COMPLEMENTAR = 'C';

    /**
     * @param string $tipo
     * @return PontoRepository
     * @throws Exception
     */
    public static function getRepository($tipo)
    {
        return match ($tipo) {
            self::PONTO_SALARIO => new PontoSalarioRepository(),
            self::PONTO_FIXO => new PontoFixoRepository(),
            self::PONTO_COMPLEMENTAR => new PontoComplementarRepository(),
            default => throw new Exception('Tabela não implementada.'),
        };
    }

    /**
     * @param string $tipo
     * @return PontoModel
     * @throws Exception
     */
    public static function getModel($tipo)
    {
        return match ($tipo) {
            self::PONTO_SALARIO => new PontoSalario(),
            self::PONTO_FIXO => new PontoFixo(),
            self::PONTO_COMPLEMENTAR => new PontoComplementar(),
            default => throw new Exception("Nenhuma tabela de ponto foi selecionada!"),
        };
    }
}
