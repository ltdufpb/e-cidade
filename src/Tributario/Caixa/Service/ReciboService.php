<?php

namespace ECidade\Tributario\Caixa\Service;

use ECidade\Tributario\Arrecadacao\CobrancaRegistrada\Service\CobrancaRegistradaService;
use ECidade\Tributario\Caixa\Model\Dbreciboweb;
use ECidade\Tributario\Caixa\Model\Recibopagaboleto;
use ECidade\Tributario\Caixa\Entity\Recibo;
use ECidade\Tributario\Caixa\Repository\Sequence\NumpreSequenceRepository;
use ECidade\Tributario\Caixa\Repository\DbrecibowebRepository;
use ECidade\Tributario\Caixa\Repository\RecibopagaboletoRepository;
use ECidade\Tributario\Caixa\Service\Procedure\ReciboProcedure;
use ECidade\Tributario\Caixa\Service\ConvenioService;
use ECidade\Tributario\Caixa\Service\RegraEmissaoService;
use ECidade\Tributario\Caixa\Service\ReciboFillService;
use ECidade\Tributario\Library\Service;
use ECidade\Tributario\Library\Session;

final class ReciboService extends Service
{
    public function __construct(private readonly Session $session, private readonly ReciboProcedure $reciboProcedure, private readonly RegraEmissaoService $regraEmissaoService, private readonly ConvenioService $convenioService, private readonly NumpreSequenceRepository $numpreSequenceRepository, private readonly DbrecibowebRepository $dbrecibowebRepository, private readonly RecibopagaboletoRepository $recibopagaboletoRepository, private readonly ReciboFillService $reciboFillService, private readonly CobrancaRegistradaService $cobrancaRegistradaService)
    {
    }

    public function execute(Recibo $recibo)
    {
        $regraEmissao = $this->regraEmissaoService->execute($recibo);

        $numpre = $this->numpreSequenceRepository->next();

        $recibo->setNumpre($numpre);

        foreach ($recibo->getDebitos() as $debito) {
            $dbreciboweb = new Dbreciboweb();

            $dbreciboweb->setNumpren($numpre);
            $dbreciboweb->setNumpre($debito->getNumpre());
            $dbreciboweb->setCodbco($regraEmissao->getBanco());
            $dbreciboweb->setCodage($regraEmissao->getAgencia());
            $dbreciboweb->setNumbco($regraEmissao->getConvenioCobranca());
            $dbreciboweb->setTipo($recibo->getTipo());
            $dbreciboweb->setDesconto($recibo->getDesconto());
            $dbreciboweb->setOrigem(1);

            foreach ($debito->getParcelas() as $parcela) {
                $dbreciboweb->setNumpar($parcela->getNumero());

                $this->dbrecibowebRepository->insert($dbreciboweb);
            }
        }

        $this->reciboProcedure->execute($recibo);

        $recibopagaboleto = new Recibopagaboleto();

        $recibopagaboleto->setNumnov($numpre);
        $recibopagaboleto->setData($this->session->getData());
        $recibopagaboleto->setHora($this->session->getHora());
        $recibopagaboleto->setUsuario($this->session->getUsuarioId());

        $this->recibopagaboletoRepository->insert($recibopagaboleto);

        $recibo = $this->reciboFillService->execute($recibo);

        $recibo = $this->convenioService->execute($recibo, $regraEmissao);

        $this->cobrancaRegistradaService->execute($recibo, $regraEmissao);

        return $recibo;
    }
}
