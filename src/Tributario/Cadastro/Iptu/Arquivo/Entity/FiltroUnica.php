<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Entity;

use \DateTime;
use ECidade\Tributario\Library\Entity;

final class FiltroUnica extends Entity
{
    public function __construct(private DateTime $data, private $porcentagem)
    {
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setPorcentagem($porcentagem)
    {
        $this->porcentagem = $porcentagem;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getPorcentagem()
    {
        return $this->porcentagem;
    }
}
