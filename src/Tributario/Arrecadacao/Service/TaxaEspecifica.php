<?php

namespace ECidade\Tributario\Arrecadacao\Service;

use ECidade\Tributario\Arrecadacao\Model\TaxaEspecifica as TaxaEspecificaModel;
use ECidade\Tributario\Arrecadacao\Repository\TaxaEspecifica as TaxaEspecificaRepository;
use Exception;

/**
 * Class TaxaEspecifica
 * @package ECidade\Tributario\Arrecadacao\Service
 */
class TaxaEspecifica
{
    /**
     * TaxaEspecifica constructor.
     * @param TaxaEspecificaRepository $repositorio
     */
    public function __construct(private readonly TaxaEspecificaRepository $repositorio)
    {
    }

    /**
     * @param $codigoSubReceita
     * @return TaxaEspecificaModel
     * @throws Exception
     */
    public function getByCodigoSubReceita($codigoSubReceita)
    {
        if (empty($codigoSubReceita)) {
            throw new Exception('Código não informado.');
        }

        return $this->repositorio->getByCodigoSubReceita($codigoSubReceita);
    }

    /**
     * @param TaxaEspecificaModel $taxaEspecificaModel
     * @return float
     * @throws Exception
     */
    public function calculaInflator(TaxaEspecificaModel $taxaEspecificaModel)
    {
        return $this->repositorio->calculaInflator($taxaEspecificaModel);
    }
}
