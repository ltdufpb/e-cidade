<?php

namespace App\Domain\Educacao\Escola\Resources;

class CalendarioResource
{
    /**
     * @param array $calendarios
     * @return array
     */
    public static function toArray(array $calendarios)
    {
        $data = [];
        foreach ($calendarios as $calendario) {
            $data[] = (object) [
                'id' => $calendario->ed52_i_codigo,
                'descricao' => trim((string) $calendario->ed52_c_descr)
            ];
        }
        return $data;
    }
}
