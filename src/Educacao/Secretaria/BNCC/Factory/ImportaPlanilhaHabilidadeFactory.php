<?php

namespace ECidade\Educacao\Secretaria\BNCC\Factory;

use ECidade\Educacao\Secretaria\BNCC\Interfaces\PlanilhaHabilidadeInterface;
use ECidade\Educacao\Secretaria\BNCC\Service\PlanilhaHabilidadeEnsinoFundamentalService;
use ECidade\Educacao\Secretaria\BNCC\Service\PlanilhaHabilidadeEnsinoInfantilService;
use ECidade\Educacao\Secretaria\BNCC\Service\PlanilhaHabilidadeReferencialGuacho;
use ECidade\Enum\Educacao\BNCC\EnsinoEnum;
use Exception;

/**
 * Class ImportaPlanilhaHabilidadeFactory
 */
class ImportaPlanilhaHabilidadeFactory
{
    /**
     * @param $tipo
     * @return PlanilhaHabilidadeInterface
     * @throws Exception
     */
    public static function porTipo($tipo)
    {
        return match ($tipo) {
            EnsinoEnum::ENSINO_INFANTIL => new PlanilhaHabilidadeEnsinoInfantilService(),
            EnsinoEnum::ENSINO_FUNDAMENTAL => new PlanilhaHabilidadeEnsinoFundamentalService(),
            'EF_REFERENCIAL_GAUCHO' => new PlanilhaHabilidadeReferencialGuacho(EnsinoEnum::ENSINO_FUNDAMENTAL),
            'EI_REFERENCIAL_GAUCHO' => new PlanilhaHabilidadeReferencialGuacho(EnsinoEnum::ENSINO_INFANTIL),
            'EM_REFERENCIAL_GAUCHO' => new PlanilhaHabilidadeReferencialGuacho(EnsinoEnum::ENSINO_MEDIO),
            default => throw new Exception('Tipo não implementado.'),
        };
    }
}
