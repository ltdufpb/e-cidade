<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Entity;

use ECidade\Tributario\Library\Entity;

final class Unica extends Entity
{
    const string TOTAL_UNICAS              = 'TOTALUNICAS';
    const string OPERACAO_UNICA            = 'OPERACAOUNICA';
    const string VENCIMENTO_UNICA          = 'VENCIMENTOUNICA';
    const string PERCENTUAL_DESCONTO_UNICA = 'PERCENTUALDESCONTOUNICA';
    const string VALOR_HISTORICO_UNICA     = 'VALORHISTORICOUNICA';
    const string VALOR_CORRIGIDO_UNICA     = 'VALORCORRIGIDOUNICA';
    const string JUROS_UNICA               = 'JUROSUNICA';
    const string MULTA_UNICA               = 'MULTAUNICA';
    const string DESCONTO_UNICA            = 'DESCONTOUNICA';
    const string TOTAL_UNICA               = 'TOTALUNICA';
    const string TOTAL_LIQUIDO_UNICA       = 'TOTALLIQUIDOUNICA';
    const string CODIGO_ARRECADACAO        = 'CODIGOARRECADACAO';
    const string BARRAS_UNICA              = 'BARRASUNICA';

    private $dataOperacao;

    private $dataVencimento;

    private $porcentagem;

    private $valorHistorico;

    private $valorCorrigido;

    private $juros;

    private $multa;

    private $desconto;

    private $total;

    private $totalDesconto;

    private $numpre;

    private $codigoBarra;

    public function setDataOperacao($dataOperacao)
    {
        $this->dataOperacao = $dataOperacao;
    }

    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
    }

    public function setPorcentagem($porcentagem)
    {
        $this->porcentagem = $porcentagem;
    }

    public function setValorHistorico($valorHistorico)
    {
        $this->valorHistorico = $valorHistorico;
    }

    public function setValorCorrigido($valorCorrigido)
    {
        $this->valorCorrigido = $valorCorrigido;
    }

    public function setJuros($juros)
    {
        $this->juros = $juros;
    }

    public function setMulta($multa)
    {
        $this->multa = $multa;
    }

    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setTotalDesconto($totalDesconto)
    {
        $this->totalDesconto = $totalDesconto;
    }

    public function setNumpre($numpre)
    {
        $this->numpre = $numpre;
    }

    public function setCodigoBarra($codigoBarra)
    {
        $this->codigoBarra = $codigoBarra;
    }

    public function getDataOperacao()
    {
        return $this->dataOperacao;
    }

    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    public function getPorcentagem()
    {
        return $this->porcentagem;
    }

    public function getValorHistorico()
    {
        return $this->valorHistorico;
    }

    public function getValorCorrigido()
    {
        return $this->valorCorrigido;
    }

    public function getJuros()
    {
        return $this->juros;
    }

    public function getMulta()
    {
        return $this->multa;
    }

    public function getDesconto()
    {
        return $this->desconto;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getTotalDesconto()
    {
        return $this->totalDesconto;
    }

    public function getNumpre()
    {
        return $this->numpre;
    }

    public function getCodigoBarra()
    {
        return $this->codigoBarra;
    }
}
