<?php

namespace ECidade\Tributario\Cadastro\Entity\Repository;

use ECidade\Tributario\Library\DataBase;
use ECidade\Tributario\Library\DataBaseRepository;
use ECidade\Tributario\Cadastro\Repository\IptubaseRepository;
use ECidade\Tributario\Cadastro\Entity\Collection\MatriculaCollection;

class MatriculaRepository extends DataBaseRepository
{
    public function __construct(DataBase $dataBase, private readonly IptubaseRepository $iptubaseRepository)
    {
        parent::__construct($dataBase);
    }

    public function findAll($sql)
    {
        $iptubases = $this->iptubaseRepository->findAllFromSQL($sql);

        return new MatriculaCollection($iptubases);
    }
}
