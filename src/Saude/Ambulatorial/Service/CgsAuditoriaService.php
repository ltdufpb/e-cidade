<?php

namespace ECidade\Saude\Ambulatorial\Service;

use ECidade\Saude\Ambulatorial\Repository\CgsAuditoriaRepository;

class CgsAuditoriaService
{
    private $CgsAuditoriaRepository;

    public function __construct(private $numCgs, private $paramCgs)
    {

        $this->CgsAuditoriaRepository = new CgsAuditoriaRepository();
    }

    public function salvar()
    {

        if ($this->naoAuditar()) {
            return null;
        }

        $this->CgsAuditoriaRepository->salvar($this->numCgs);
    }

    public function naoAuditar()
    {
        return ($this->auditoriaExists() && $this->isAlteracao());
    }

    public function auditoriaExists()
    {
        return CgsAuditoriaRepository::getUltimoRegistroByCgs($this->numCgs) ? true : false;
    }

    public function isAlteracao()
    {
        return $this->paramCgs !== null ? true : false;
    }
}
