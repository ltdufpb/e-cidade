<?php

namespace ECidade\Tributario\Caixa\Service;

use ECidade\Tributario\Library\Service;
use ECidade\Tributario\Caixa\Entity\Recibo;
use ECidade\Tributario\Caixa\Repository\RecibopagaRepository;
use ECidade\Tributario\Caixa\Repository\RecibocodbarRepository;
use ECidade\Tributario\Caixa\Cast\RecibopagaCollectionCast;

final class ReciboFillService extends Service
{
    public function __construct(private readonly RecibopagaRepository $recibopagaRepository, private readonly RecibopagaCollectionCast $recibopagaCollectionCast)
    {
    }

    public function execute(Recibo $recibo)
    {
        $recibopagaCollection = $this->recibopagaRepository->findAllByNumnov($recibo->getNumpre());
        
        $debitos = $this->recibopagaCollectionCast->toDebitoCollection($recibopagaCollection);
        
        $recibo->setDebitos($debitos);

        return $recibo;
    }
}
