<?php

namespace ECidade\Tributario\Arrecadacao\Service;

use ECidade\Tributario\Arrecadacao\Model\ReciboAvulso as ReciboAvulsoModel;
use ECidade\Tributario\Arrecadacao\Repository\ReciboAvulso as ReciboAvulsoRepository;

use Exception;

class ReciboAvulso
{
    /**
     * ReciboAvulso constructor.
     * @param ReciboAvulsoRepository $repositorio
     */
    public function __construct(private readonly ReciboAvulsoRepository $repositorio)
    {
    }

    /**
     * @param ReciboAvulsoModel $reciboAvulsoModel
     * @throws Exception
     */
    public function save(ReciboAvulsoModel $reciboAvulsoModel)
    {
        $this->repositorio->save($reciboAvulsoModel);
    }
}
