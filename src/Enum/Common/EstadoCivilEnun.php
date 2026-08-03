<?php


namespace ECidade\Enum\Common;

use ECidade\Enum\Enum;
use Exception;

/**
 * Class EstadoCivilEnun
 * @package ECidade\Enum\Common
 */
class EstadoCivilEnun extends Enum
{
    const SOLTEIRO = 1;
    const CASADO = 2;
    const VIUVO = 3;
    const DIVORCIADO = 4;

    /**
     * @return string
     * @throws Exception
     */
    public function name()
    {
        $data = [
            self::SOLTEIRO => "Solteiro",
            self::CASADO => "Casado",
            self::VIUVO => "Viúvo",
            self::DIVORCIADO => "Divorciado",
        ];

        if (empty($data[$this->getValue()])) {
            throw new Exception('Zona de residência não encontrada.');
        }

        return $data[$this->getValue()];
    }

    /**
     * Retorna os valores com os nomes
     * @return array
     * @throws Exception
     */
    #[\Override]
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
}
