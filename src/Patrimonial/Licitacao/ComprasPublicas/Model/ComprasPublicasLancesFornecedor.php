<?php

namespace ECidade\Patrimonial\Licitacao\ComprasPublicas\Model;

use cl_liclicitemlances;
use stdClass;

use Exception;

class ComprasPublicasLancesFornecedor
{
    
    public function __construct(private $idItem, private $liclicitem, private $data, private $hora, private $fornecedor, private $valido, private $cancelado, private $justificativa, private $vlrun, private $vlrtot, private $vlrdesc = 0)
    {
    }
    
    public function getValorTotal()
    {
        return $this->vlrtot;
    }

    public function getValorUnitario()
    {
        return $this->vlrun;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function getValorDesconto()
    {
        return $this->vlrdesc;
    }

    public function save()
    {

        $liclicitemlance                    = new cl_liclicitemlances();
        $liclicitemlance->l49_liclicitem    = $this->liclicitem;
        $liclicitemlance->l49_data          = $this->data;
        $liclicitemlance->l49_hora          = $this->hora;
        $liclicitemlance->l49_fornecedor    = $this->fornecedor;
        $liclicitemlance->l49_valido        = $this->valido == false ? 'f' : 't';
        $liclicitemlance->l49_cancelado     = $this->cancelado == false ? 'f' : 't';
        $liclicitemlance->l49_justificativa = $this->justificativa;
        $liclicitemlance->l49_vlrun         = $this->vlrun;
        $liclicitemlance->l49_vlrtot        = $this->vlrtot;
        $liclicitemlance->l49_vlrdesc       = $this->vlrdesc;
        $liclicitemlance->incluir(null);
        if ($liclicitemlance->erro_status == 0) {
            throw new Exception($liclicitemlance->erro_msg);
        }
    }
}
