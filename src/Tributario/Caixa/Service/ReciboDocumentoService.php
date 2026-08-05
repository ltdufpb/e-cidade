<?php
namespace ECidade\Tributario\Caixa\Service;

use Exception;
use ECidade\Tributario\Arrecadacao\Custas\Relatorio\RelatorioRecibo;
use ECidade\Tributario\Caixa\Cast\ReciboCast;
use ECidade\Tributario\Caixa\Entity\Recibo;
use ECidade\Tributario\Library\Service;

final class ReciboDocumentoService extends Service
{
    public function __construct(private readonly ReciboCast $reciboCast)
    {
    }

    /**
     * @param Recibo $recibo
     * @return string
     * @throws Exception
     */
    public function execute(Recibo $recibo)
    {
        $reciboModel = $this->reciboCast->toModel($recibo);

        $relatorioRecibo = new RelatorioRecibo();
        $reciboPath = $relatorioRecibo->imprimir([$reciboModel]);

        return $reciboPath;
    }
}
