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


namespace ECidade\Patrimonial\Licitacao\Licitacon;

use SituacaoLicitacao;

/**
 * Class Situacao
 * Classe para centralizar as regras da situação, utilizados em diversos lugares do LicitaCon.
 * @package ECidade\Patrimonial\Licitacao\Licitacon
 */
class Situacao {

	const SIGLA_SITUACAO_EM_ANDAMENTO = null;
	const SIGLA_SITUACAO_JULGADA      = null;
	const SIGLA_SITUACAO_REVOGADA     = 'R';
	const SIGLA_SITUACAO_DESERTA      = 'D';
	const SIGLA_SITUACAO_FRACASSADA   = 'F';
	const SIGLA_SITUACAO_ANULADA      = null;
	const SIGLA_SITUACAO_ADJUDICADO   = 'A';
	const SIGLA_SITUACAO_CONCLUIDA    = 'C';
	const SIGLA_SITUACAO_HOMOLOGADA   = 'H';

	/**
	 * Situacao constructor.
	 *
	 * @param int $iCodigo
	 */
	public function __construct(private $iCodigo)
    {
    }

	/**
	 * @return int
	 */
	public function getCodigo() {
		return $this->iCodigo;
	}

	/**
	 * Retorna a sigla da situalçaoi do licitacon.
	 *
	 * @return null|string
	 */
	public function getSigla() {

		return match ($this->iCodigo) {
            SituacaoLicitacao::SITUACAO_ANULADA => self::SIGLA_SITUACAO_ANULADA,
            SituacaoLicitacao::SITUACAO_DESERTA => self::SIGLA_SITUACAO_DESERTA,
            SituacaoLicitacao::SITUACAO_EM_ANDAMENTO => self::SIGLA_SITUACAO_EM_ANDAMENTO,
            SituacaoLicitacao::SITUACAO_FRACASSADA => self::SIGLA_SITUACAO_FRACASSADA,
            SituacaoLicitacao::SITUACAO_ADJUDICADA => self::SIGLA_SITUACAO_ADJUDICADO,
            SituacaoLicitacao::SITUACAO_HOMOLOGADA => self::SIGLA_SITUACAO_HOMOLOGADA,
            SituacaoLicitacao::SITUACAO_JULGADA => self::SIGLA_SITUACAO_JULGADA,
            SituacaoLicitacao::SITUACAO_REVOGADA => self::SIGLA_SITUACAO_REVOGADA,
            default => null,
        };
	}

	/**
	 * Diz se a situação é anulada.
	 * @return bool
	 */
	public function isAnulada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_ANULADA;
	}

	/**
	 * Diz se a situação é deserta.
	 * @return bool
	 */
	public function isDeserta() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_DESERTA;
	}

	/**
	 * Diz se a situação é em andamento.
	 * @return bool
	 */
	public function isEmAndamento() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_EM_ANDAMENTO;
	}

	/**
	 * Diz se a situação é fracasssada.
	 * @return bool
	 */
	public function isFracassada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_FRACASSADA;
	}

	/**
	 * Diz se a situação é adjudicada.
	 * @return bool
	 */
	public function isAdjudicada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_ADJUDICADA;
	}

	/**
	 * Diz se a situação é homologada.
	 * @return bool
	 */
	public function isHomologada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_HOMOLOGADA;
	}

	/**
	 * Diz se a situação é julgada.
	 * @return bool
	 */
	public function isJulgada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_JULGADA;
	}

	/**
	 * Diz se a situação é revogada.
	 * @return bool
	 */
	public function isRevogada() {
		return $this->getCodigo() == SituacaoLicitacao::SITUACAO_REVOGADA;
	}


}