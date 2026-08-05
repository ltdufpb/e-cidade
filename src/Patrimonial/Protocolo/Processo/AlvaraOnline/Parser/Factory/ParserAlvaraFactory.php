<?php

namespace ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Factory;

use Exception;
use App\Domain\Tributario\ISSQN\Services\Redesim\InclusaoEmpresa\AtendimentoInclusaoInscricaoJsonService;
use BusinessException;
use ParameterException;
use ECidade\Tributario\Issqn\ParametrosProcessoEletronicoBag;
use ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Entity\AlvaraMei as ParserAlvaraMei;
use ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Entity\AlvaraEmpresa as ParserAlvaraEmpresa;
use ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Entity\AlvaraAutonomo as ParserAlvaraAutonomo;

use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity\AlvaraMei
as ParserAlvaraMeiProcessoEletronico;
use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity\AlvaraEmpresa
as ParserAlvaraEmpresaProcessoEletronico;
use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity\AlvaraAutonomo
as ParserAlvaraAutonomoProcessoEletronico;

class ParserAlvaraFactory
{
    public function __construct(public $collectionAtividades)
    {
    }

    public static function getInstance($collectionAtividades)
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static($collectionAtividades);
        }

        return $instance;
    }

    /**
     * @param $filtroProcessos
     * @return ParserAlvaraAutonomo|ParserAlvaraEmpresa|ParserAlvaraMei
     * @throws BusinessException
     * @throws ParameterException
     * @throws Exception
     */
    public function create($filtroProcessos, ParametrosProcessoEletronicoBag $parameterBag)
    {
        return match ($filtroProcessos->getCodigoTipoProcesso()) {
            $parameterBag->getAlvaraAutonomo() => new ParserAlvaraAutonomo($this->collectionAtividades),
            $parameterBag->getAlvaraAutonomoProcessoEletronico() => new ParserAlvaraAutonomoProcessoEletronico($this->collectionAtividades),
            $parameterBag->getAlvaraEmpresa() => new ParserAlvaraEmpresa($this->collectionAtividades),
            $parameterBag->getAlvaraEmpresaProcessoEletronico(), AtendimentoInclusaoInscricaoJsonService::getTipoProcesso() => new ParserAlvaraEmpresaProcessoEletronico($this->collectionAtividades),
            $parameterBag->getAlvaraMei() => new ParserAlvaraMei($this->collectionAtividades),
            $parameterBag->getAlvaraMeiProcessoEletronico() => new ParserAlvaraMeiProcessoEletronico($this->collectionAtividades),
            default => throw new BusinessException("Não foi possí­vel identificar o tipo de parser a carregar."),
        };
    }
}
