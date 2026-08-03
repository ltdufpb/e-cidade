<?php
namespace ECidade\Patrimonial\Licitacao\ComprasPublicas\Model;

class ComprasPublicasProposta
{
  
    public function __construct(private $idItem, private $liclicitem, private $data, private $hora, private $idFornecedor, private $modelo, private $marca, private $fabricante, private $detalhamento, private $validadeProposta, private $valorUnitario, private $valorDesconto, private $valorTotal, private $valido)
    {
    }

    public function setData($data)
    {
        $this->$data = $data;
    }
  
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    }

    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;
    }

    public function setDesconto($valorDesconto)
    {
        $this->valorDesconto = $valorDesconto;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    public function getDesconto()
    {
        return $this->valorDesconto;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function getFornecedor()
    {
        return $this->idFornecedor;
    }

    public function getData()
    {
        return $this->data;
    }
}
