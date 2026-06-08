<?php


namespace ECidade\Enum\Educacao\Escola;

use Override;
use ECidade\Enum\Educacao\BNCC\EnsinoEnum;
use ECidade\Enum\Enum;
use Exception;

/**
 * Class TipoEnsinoEnum
 * @package ECidade\Enum\Educacao\Escola
 */
class TipoEnsinoEnum extends Enum
{
    const ENSINO_INFANTIL = 1;
    const ENSINO_FUNDAMENTAL = 2;
    const ENSINO_MEDIO = 3;
    const ENSINO_PROFISSIONAL = 4;

    /**
     * @return string
     * @throws Exception
     */
    public function name()
    {
        $data = [
            self::ENSINO_INFANTIL => "Educação Infantil",
            self::ENSINO_FUNDAMENTAL => "Ensino Fundamental",
            self::ENSINO_MEDIO => "Ensino Médio",
            self::ENSINO_PROFISSIONAL => "Ensino Profissional",
        ];

        if (empty($data[$this->getValue()])) {
            throw new Exception('Tipo de ensino não encontrada.');
        }

        return $data[$this->getValue()];
    }

    /**
     * Retorna os valores com os nomes
     * @return array
     * @throws Exception
     */
    #[Override]
    public static function toArrayWithNames()
    {
        $tipos = self::values();
        $return = [];
        foreach ($tipos as $tipo) {
            $return[] = [
                'value' => $tipo->value(),
                'name' => $tipo->name()
            ];
        }

        return $return;
    }

    /**
     * @return EnsinoEnum
     * @throws Exception
     */
    public function getEnsinoBncc()
    {
        return match ($this->value) {
            self::ENSINO_INFANTIL => new EnsinoEnum(EnsinoEnum::ENSINO_INFANTIL),
            self::ENSINO_FUNDAMENTAL => new EnsinoEnum(EnsinoEnum::ENSINO_FUNDAMENTAL),
            self::ENSINO_MEDIO => new EnsinoEnum(EnsinoEnum::ENSINO_MEDIO),
            default => throw new Exception("Ensino não mapeado."),
        };
    }

    public function isInfantil()
    {
        return $this->value === self::ENSINO_INFANTIL;
    }
}
