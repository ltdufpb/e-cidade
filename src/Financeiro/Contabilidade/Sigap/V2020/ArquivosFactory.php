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

namespace ECidade\Financeiro\Contabilidade\Sigap\V2020;

use ECidade\Financeiro\Contabilidade\Sigap\ArquivosSigapFiscalInterface;
use ECidade\Financeiro\Contabilidade\Sigap\RgfAcompanhamentoRetornoAoLimitePessoalExtendido;
use Exception;
use Periodo;

/**
 * Class ArquivosFactory
 * @package ECidade\Financeiro\Orcamento\Sigap
 */
class ArquivosFactory
{
    public function __construct(private $ano)
    {
    }

    /**
     * @param $arquivo
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return ArquivosSigapFiscalInterface
     * @throws Exception
     */
    public function get($arquivo, Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return match ($arquivo) {
            'RREOBalancoOrcamentario' => new BalancoOrcamentario($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOBalancoFuncao' => new BalancoFuncao($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOReceitaCorrenteLiquida' => new DemonstrativoReceitaCorrenteLiquida($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREODespesaReceitaRPPS' => new RreoDespesaReceitaRPPS($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOResultadoPrimarioNominal' => new ResultadoPrimarioNominal($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREORestosPagar' => new RestosPagar($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOReceitasDespesasMDE' => new RREODemonstrativoReceitasDespesasMDE($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOOperacoesCreditoDespesasCapital', 'RREOProjecaoAtuarial', 'RREOAlienacaoAtivosAplicacaoRecursos', 'RREOReceitasDespesasSaude' => new RREOReceitasDespesasSaude($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREOParticipacaoPublicaPrivada' => new RREOParticipacaoPublicaPrivada($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RREODemonstrativoSimplificado' => new RreoDemonstrativoSimplificado($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFDespesaPessoalDetalhada' => new RgfDemonstrativoDespesaPessoal($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFDividaConsolidadaLiquida' => new DividaConsolidadaLiquida($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFGarantiasContraGarantias' => new RgfGarantiasContraGarantias($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFOperacaoCredito' => new RgfOperacoesDeCredito($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFDisponibilidadeCaixa' => new DisponibilidadeCaixaRestosPagar($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            'RGFDemonstrativoSimplificado' => new RgfDemonstrativoSimplificado($periodo, $codigoInstituicoes, $this->ano, $codigoTCE),
            default => throw new Exception("Classe {$arquivo} não implementada."),
        };
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param integer $codigoTCE
     * @return NotasExplicativas
     */
    public function getNotasExplicativas(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new NotasExplicativas($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return ArquivoFonte
     */
    public function getArquivodeFonte(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new ArquivoFonte($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return ArquivoPublicidade
     */
    public function getArquivodePublicidade(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new ArquivoPublicidade($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return RgfRetornoAoLimiteDivida
     */
    public function getArquivoRetornoAoLimiteDivida(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new RgfRetornoAoLimiteDivida($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return RgfAcompanhamentoRetornoAoLimiteDivida
     */
    public function getArquivoAcompanhamentoRetornoLimiteDivida(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new RgfAcompanhamentoRetornoAoLimiteDivida($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return RgfRetornoAoLimitePessoal
     */
    public function getArquivoRetornoAoLimitePessoal(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new RgfRetornoAoLimitePessoal($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $codigoInstituicoes
     * @param $codigoTCE
     * @return RgfAcompanhamentoRetornoAoLimitePessoal
     */
    public function getArquivoAcompRetornoLimitePessoal(Periodo $periodo, array $codigoInstituicoes, $codigoTCE)
    {
        return new RgfAcompanhamentoRetornoAoLimitePessoal($periodo, $codigoInstituicoes, $this->ano, $codigoTCE);
    }

    /**
     * @param Periodo $periodo
     * @param array $instituicoes
     * @param $codigoTCE
     * @return RgfAcompanhamentoRetornoAoLimitePessoalExtendido
     */
    public function getArquivoAcompRetornoLimitePessoalExtendido(Periodo $periodo, array $instituicoes, $codigoTCE)
    {
        return new RgfAcompanhamentoRetornoAoLimitePessoalExtendido($periodo, $instituicoes, $this->ano, $codigoTCE);
    }
}
