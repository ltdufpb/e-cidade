<?php


namespace ECidade\Enum\Educacao\Escola;

use ECidade\Enum\Enum;
use Exception;

/**
 * Class NacionalidadeEnum
 * @package ECidade\Enum\Educacao\Escola
 */
class NacionalidadeEnum extends Enum
{
    const BRASILEIRO = 1;
    /**
     * Brasileira no Exterior ou Naturalizado
     */
    const NATURALIZADO = 2;
    const ESTRANGEIRO = 3;

    /**
     * @return string
     * @throws Exception
     */
    public function name()
    {
        $data = [
            self::BRASILEIRO => "Brasileira",
            self::NATURALIZADO => "Brasileira no Exterior ou Naturalizado",
            self::ESTRANGEIRO => "Estrangeira",
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
