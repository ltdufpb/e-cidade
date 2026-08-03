<?php


namespace ECidade\Enum\Educacao\BNCC;

use ECidade\Enum\Educacao\Escola\TipoEnsinoEnum;
use ECidade\Enum\Enum;
use Exception;

/**
 * Class EnsinoEnum
 * @package ECidade\Enum\Educacao\BNCC
 */
class EnsinoEnum extends Enum
{
    const ENSINO_INFANTIL = 'EI';
    const ENSINO_FUNDAMENTAL = 'EF';
    const ENSINO_MEDIO = 'EM';

    /**
     * @return string
     * @throws Exception
     */
    public function name()
    {
        $data = [
            self::ENSINO_INFANTIL => "Ensino Infantil",
            self::ENSINO_FUNDAMENTAL => "Ensino Fundamental",
            self::ENSINO_MEDIO => "Ensino Médio",
        ];

        if (empty($data[$this->getValue()])) {
            throw new Exception('Ensino não encontrado.');
        }

        return $data[$this->getValue()];
    }

    /**
     * @return TipoEnsinoEnum
     * @throws Exception
     */
    public function getTipoEnsino()
    {
        return match ($this->value) {
            self::ENSINO_INFANTIL => new TipoEnsinoEnum(TipoEnsinoEnum::ENSINO_INFANTIL),
            self::ENSINO_FUNDAMENTAL => new TipoEnsinoEnum(TipoEnsinoEnum::ENSINO_FUNDAMENTAL),
            self::ENSINO_MEDIO => new TipoEnsinoEnum(TipoEnsinoEnum::ENSINO_MEDIO),
            default => throw new Exception("Ensino não mapeado."),
        };
    }
}
