<?php

namespace ECidade\Tributario\Issqn\Acao\Transicao\Entity;

use BusinessException;
use ParameterException;
use Exception;
use ECidade\Configuracao\Workflow\Interfaces\Acao as AcaoInterface;
use ECidade\Tributario\Arrecadacao\CadTipo;
use ECidade\Tributario\Caixa\Entity\Collection\DebitoCollection;
use ECidade\Tributario\Caixa\Service\ReciboDocumentoService;
use ECidade\Tributario\Issqn\Repository\InscricaoDebitoRepository;
use ECidade\Tributario\Issqn\Repository\IssbaseRepository;
use ECidade\Tributario\Caixa\Service\ReciboService;
use ECidade\Tributario\Caixa\Repository\ArretipoRepository;
use ECidade\Tributario\Caixa\Entity\Recibo;
use ECidade\Tributario\Caixa\Enum\Cadtipomod;

final class GerarBoleto extends AcaoBase implements AcaoInterface
{
    /**
     * @var DebitoCollection
     */
    private $debitos;

    public function __construct(
        $processo,
        IssbaseRepository $issbaseRepository,
        private readonly ReciboService $reciboService,
        private readonly ArretipoRepository $arretipoRepository,
        private readonly InscricaoDebitoRepository $inscricaoDebitoRepository,
        private readonly ReciboDocumentoService $reciboDocumentoService
    ) {
        parent::__construct($processo, $issbaseRepository);
    }

    /**
     * @throws BusinessException
     * @throws ParameterException
     */
    public function validate()
    {
        $issbase = $this->getIssbase();
        $debitosCollection = $this->inscricaoDebitoRepository->findByIssbaseAndCadtipo($issbase, CadTipo::ALVARA);

        if ($debitosCollection->count() == 0) {
            throw new BusinessException("Esta inscrição não possui debitos válidos para a emissão de recibo.");
        }

        $this->debitos = $debitosCollection;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run()
    {
        $arretipo = $this->arretipoRepository->find($this->debitos->get(0)->getTipo());
        $primeiraParcela = $this->debitos->get(0)->getParcelas()->getByIndex(0);

        $recibo = new Recibo();

        foreach ($this->debitos->getAll() as $debito) {
            $recibo->addDebito($debito);
        }

        $recibo->setOrigem(Cadtipomod::RECIBO_DA_CGF);
        $recibo->setTerceiroDigito($arretipo->getTercdigrecnormal());
        $recibo->setVencimento($primeiraParcela->getVencimento());
        /**
        * @todo Validar tipo
        */
        $recibo->setTipo(5);

        $recibo = $this->reciboService->execute($recibo);

        $reciboPath = $this->reciboDocumentoService->execute($recibo);

        return $reciboPath;
    }
}
