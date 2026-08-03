<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

namespace ECidade\Financeiro\Contabilidade\Sagres\V2022;

use Exception;

/**
 * Class ArquivosFactory
 * @package ECidade\Financeiro\Orcamento\Sagres
 */
class ArquivosFactory
{
    public function __construct(private $ano)
    {
    }

    /**
     * @param $arquivo
     * @param object $params
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @throws Exception
     */
    public function get($arquivo, $params, array $codigoInstituicoes, $codigoTCE)
    {
        return match ($arquivo) {
            'UnidadeOrcamentaria' => new UnidadeOrcamentaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Programas' => new Programas($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Acao' => new Acao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Dotacao' => new Dotacao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'AtualizacaoOrcamentaria' => new AtualizacaoOrcamentaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'DecretoseOficios' => new DecretoseOficios($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'ReceitaPrevista' => new ReceitaPrevista($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Empenhos' => new Empenhos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Estorno' => new Estornos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Liquidacao' => new Liquidacao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoLiquidacao' => new EstornoLiquidacao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Pagamentos' => new Pagamentos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoPagamento' => new EstornoPagamento($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Retencao' => new Retencao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoRetencao' => new EstornoRetencao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'ReceitaOrcamentaria' => new ReceitaOrcamentaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'TransfRecebida' => new TransfRecebida($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'TransfConcedida' => new TransfConcedida($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'ReceitaExtra' => new ReceitaExtra($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'DespesaExtra' => new DespesaExtra($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoReceitaExtra' => new EstornoReceitaExtra($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoDespesaExtra' => new EstornoDespesaExtra($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'CadastroContaBancaria' => new CadastroContaBancaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RelacionamentoCCorrenteFontePagadora' => new RelacionamentoCCorrenteFontePagadora(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'SaldoInicial' => new SaldoInicial($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'SaldoMensal' => new SaldoMensal($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'ConciliacaoBancaria' => new ConciliacaoBancaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PagamentosRestos' => new PagamentosRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoPagamentoRestos' => new EstornoPagamentoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'CancelamentoRestos' => new CancelamentoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'LiquidacaoRestos' => new LiquidacaoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoLiquidacaoRestos' => new EstornoLiquidacaoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RetencaoRestos' => new RetencaoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'EstornoRetencaoRestos' => new EstornoRetencaoRestos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Fornecedores' => new Fornecedores($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'Ordenador' => new Ordenador($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RelacionamentoEmpenhoObra' => new RelacionamentoEmpenhoObra($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RelacionamentoEmpenhoLicitacao' => new RelacionamentoEmpenhoLicitacao(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'RelacionamentoLiquidacaoCodigoAgrupamentoFolhaPagamento' => new RelacionamentoLiquidacaoCodigoAgrupamentoFolhaPagamento(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'RestosInscritos' => new RestosInscritos($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PloaAcao' => new PloaAcao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PloaDotacao' => new PloaDotacao($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PloaPrograma' => new PloaPrograma($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PloaReceitaPrevista' => new PloaReceitaPrevista($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'PloaUnidadeOrcamentaria' => new PloaUnidadeOrcamentaria($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RelacionamentoEmpenhoTipoMeta' => new RelacionamentoEmpenhoTipoMeta(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'SaldoMensalCoConciliado' => new SaldoMensalCoConciliado($params, $codigoInstituicoes, $this->ano, $codigoTCE),
            default => throw new Exception("Classe {$arquivo} não implementada."),
        };
    }
}
