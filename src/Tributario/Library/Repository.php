<?php

namespace ECidade\Tributario\Library;

use ECidade\Tributario\Library\DataBaseRepository;
use ECidade\Tributario\Library\DataBase;

abstract class Repository extends DataBaseRepository
{
    public function __construct(DataBase $dataBase, protected $dao)
    {
        parent::__construct($dataBase);
    }

    public function getDao()
    {
        return $this->dao;
    }
}
