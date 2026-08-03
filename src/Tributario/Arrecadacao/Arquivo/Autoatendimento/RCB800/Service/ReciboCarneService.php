<?php

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB800\Service;

use ECidade\Tributario\Library\Service;
use ECidade\Tributario\Caixa\Entity\Debito;
use ECidade\Tributario\Caixa\Entity\Collection\ReciboCollection;
use ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB800\Service\ReciboService;

final class ReciboCarneService extends Service
{
    public function __construct(private readonly ReciboService $reciboService)
    {
    }

    public function execute(Debito $debito, $datavigfinal)
    {
        $carnes = [];
        $recibos = new ReciboCollection();

        $parcelas = $debito->getParcelas();

        foreach ($parcelas as $parcela) {
            $debitoRecibo = new Debito();
            $debitoRecibo->setTipo($debito->getTipo());
            $debitoRecibo->setNumpre($debito->getNumpre());
            $debitoRecibo->addParcela($parcela);

            $recibo = $this->reciboService->execute($debitoRecibo, $datavigfinal);

            $recibos->add($recibo);
        }

        return $recibos;
    }
}
