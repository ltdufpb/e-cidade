<?php

namespace ECidade\Tributario\Caixa\Entity\Repository;

use ECidade\Tributario\Library\DataBaseRepository;
use ECidade\Tributario\Caixa\Repository\ListaRepository as ListaModelRepository;
use ECidade\Tributario\Caixa\Cast\ListaCast;

final class ListaRepository extends DataBaseRepository 
{
    public function __construct(private readonly ListaModelRepository $listaRepository, private readonly ListaCast $listaCast)
    {
    }

    public function find($codigo)
    {
        $listaModel = $this->listaRepository->find($codigo);

        return $this->listaCast->toEntity($listaModel);
    }
}