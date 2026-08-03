<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Entity;

use ECidade\Tributario\Library\Entity;

final class UnicaIptu extends Entity
{
    const string CODARREIPTU = 'CODARREIPTU';
    const string VLRCALCIPTU = 'VLRCALCIPTU';
    const string VLRDESCUNICAIPTU1 = 'VLRDESCUNICAIPTU1';
    const string ALIQDESCUNICAIPTU1 = 'ALIQDESCUNICAIPTU1';
    const string VLRUNICAIPTU1 = 'VLRUNICAIPTU1';
    const string VLRDESCUNICAIPTU2 = 'VLRDESCUNICAIPTU2';
    const string ALIQDESCUNICAIPTU2 = 'ALIQDESCUNICAIPTU2';
    const string VLRUNICAIPTU2 = 'VLRUNICAIPTU2';
    const string VLRDESCUNICAIPTU3 = 'VLRDESCUNICAIPTU3';
    const string ALIQDESCUNICAIPTU3 = 'ALIQDESCUNICAIPTU3';
    const string VLRUNICAIPTU3 = 'VLRUNICAIPTU3';

    private $codigoArrecadacaoIptu;

    private $valorCalculo;

    private $valorDescontoUnicaIptu1;

    private $aliquotaDescontoUnicaIptu1;

    private $valorUnicaIptu1;

    private $valorDescontoUnicaIptu2;

    private $aliquotaDescontoUnicaIptu2;

    private $valorUnicaIptu2;

    private $valorDescontoUnicaIptu3;

    private $aliquotaDescontoUnicaIptu3;

    private $valorUnicaIptu3;

    public function setCodigoArrecadacaoIptu($codigoArrecadacaoIptu)
    {
        $this->codigoArrecadacaoIptu = $codigoArrecadacaoIptu;
    }

    public function setValorCalculo($valorCalculo)
    {
        $this->valorCalculo = $valorCalculo;
    }

    public function setValorDescontoUnicaIptu1($valorDescontoUnicaIptu1)
    {
        $this->valorDescontoUnicaIptu1 = $valorDescontoUnicaIptu1;
    }

    public function setAliquotaDescontoUnicaIptu1($aliquotaDescontoUnicaIptu1)
    {
        $this->aliquotaDescontoUnicaIptu1 = $aliquotaDescontoUnicaIptu1;
    }

    public function setValorUnicaIptu1($valorUnicaIptu1)
    {
        $this->valorUnicaIptu1 = $valorUnicaIptu1;
    }

    public function setValorDescontoUnicaIptu2($valorDescontoUnicaIptu2)
    {
        $this->valorDescontoUnicaIptu2 = $valorDescontoUnicaIptu2;
    }

    public function setAliquotaDescontoUnicaIptu2($aliquotaDescontoUnicaIptu2)
    {
        $this->aliquotaDescontoUnicaIptu2 = $aliquotaDescontoUnicaIptu2;
    }

    public function setValorUnicaIptu2($valorUnicaIptu2)
    {
        $this->valorUnicaIptu2 = $valorUnicaIptu2;
    }

    public function setValorDescontoUnicaIptu3($valorDescontoUnicaIptu3)
    {
        $this->valorDescontoUnicaIptu3 = $valorDescontoUnicaIptu3;
    }

    public function setAliquotaDescontoUnicaIptu3($aliquotaDescontoUnicaIptu3)
    {
        $this->aliquotaDescontoUnicaIptu3 = $aliquotaDescontoUnicaIptu3;
    }

    public function setValorUnicaIptu3($valorUnicaIptu3)
    {
        $this->valorUnicaIptu3 = $valorUnicaIptu3;
    }

    public function getCodigoArrecadacaoIptu()
    {
        return $this->codigoArrecadacaoIptu;
    }

    public function getValorCalculo()
    {
        return $this->valorCalculo;
    }

    public function getValorDescontoUnicaIptu1()
    {
        return $this->valorDescontoUnicaIptu1;
    }

    public function getAliquotaDescontoUnicaIptu1()
    {
        return $this->aliquotaDescontoUnicaIptu1;
    }

    public function getValorUnicaIptu1()
    {
        return $this->valorUnicaIptu1;
    }

    public function getValorDescontoUnicaIptu2()
    {
        return $this->valorDescontoUnicaIptu2;
    }

    public function getAliquotaDescontoUnicaIptu2()
    {
        return $this->aliquotaDescontoUnicaIptu2;
    }

    public function getValorUnicaIptu2()
    {
        return $this->valorUnicaIptu2;
    }

    public function getValorDescontoUnicaIptu3()
    {
        return $this->valorDescontoUnicaIptu3;
    }

    public function getAliquotaDescontoUnicaIptu3()
    {
        return $this->aliquotaDescontoUnicaIptu3;
    }

    public function getValorUnicaIptu3()
    {
        return $this->valorUnicaIptu3;
    }
}
