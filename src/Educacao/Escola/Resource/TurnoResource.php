<?php

namespace ECidade\Educacao\Escola\Resource;

/**
 * Class TurnoResource
 * @package ECidade\Educacao\Escola\Resource
 */
class TurnoResource
{
    /**
     * @param array $turnos
     * @return array
     */
    public static function toArray(array $turnos)
    {
        $data = [];

        /** @var \Turno $turno */
        foreach ($turnos as $turno) {
            $data[] = (object) [
                "codigo" => $turno->getCodigoTurno(),
                "descricao" => $turno->getDescricao(),
                "ordem" => $turno->getOrdem(),
            ];
        }
        return $data;
    }
}
