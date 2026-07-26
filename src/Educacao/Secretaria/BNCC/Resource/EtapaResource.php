<?php


namespace ECidade\Educacao\Secretaria\BNCC\Resource;

use ECidade\Educacao\Secretaria\BNCC\Model\Etapa;

/**
 * Class EtapaResource
 * @package ECidade\Enum\Educacao\BNCC\Resource
 */
class EtapaResource
{
    /**
     * @param Etapa[] $etapas
     * @return array
     */
    public static function toArray(array $etapas)
    {
        $data = [];

        foreach ($etapas as $etapa) {
            $data[] = (object) [
                "codigo" => $etapa->getCodigo(),
                "etapa" => $etapa->getEtapa(),
                "ensino" => $etapa->getEnsino(),
            ];
        }
        return $data;
    }
}
