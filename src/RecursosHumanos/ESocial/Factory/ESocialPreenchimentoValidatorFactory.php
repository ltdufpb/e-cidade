<?php

namespace ECidade\RecursosHumanos\ESocial\Factory;

use ECidade\RecursosHumanos\ESocial\Validators\ServidorPreenchimentoValidator;

class ESocialPreenchimentoValidatorFactory
{
    public static function getByIdentificador($tipo)
    {
        return match ($tipo) {
            's22002190v23' => new ServidorPreenchimentoValidator(),
            default => null,
        };
    }
}
