<?php

namespace ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Service;

use ECidade\Tributario\Library\Service as BaseService;
use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Repository\ConsultaProcesso as RepositoryConsultaProcesso;
use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Filter\ListagemProcessos as FiltroListagemProcessos;

final class Service extends BaseService
{
    public function __construct(private readonly RepositoryConsultaProcesso $consultaProcessosRepository)
    {
    }

    public function listarProcessos(FiltroListagemProcessos $filtro)
    {
        return $this->consultaProcessosRepository->listarProcessos($filtro);
    }
}
