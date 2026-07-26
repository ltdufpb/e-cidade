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

/**
 * Class Julgamento
 * Classe para controle do tipo de julgamento do LicitaCon.
 * @package ECidade\Patrimonial\Licitacao\Licitacon
 */
class Julgamento {

	const TIPO_JULGAMENTO_SIGLA_POR_ITEM = 'I';
	const TIPO_JULGAMENTO_SIGLA_GLOBAL   = 'G';
	const TIPO_JULGAMENTO_SIGLA_POR_LOTE = 'L';

	/**
     * Julgamento constructor.
     *
     * @param $iCodigo
     * @param int $iCodigo
     */
    public function __construct(private $iCodigo)
    {
    }

	/**
	 * Retorna a sigla para o tipo de julgamento informado.
	 *
	 * @return null|string
	 */
	public function getSigla() {

		return match ($this->iCodigo) {
            \licitacao::TIPO_JULGAMENTO_GLOBAL => self::TIPO_JULGAMENTO_SIGLA_GLOBAL,
            \licitacao::TIPO_JULGAMENTO_POR_LOTE => self::TIPO_JULGAMENTO_SIGLA_POR_LOTE,
            \licitacao::TIPO_JULGAMENTO_POR_ITEM => self::TIPO_JULGAMENTO_SIGLA_POR_ITEM,
            default => null,
        };
	}

	/**
	 * Diz se o tipo de julgamento é global.
	 * @return bool
	 */
	public function isGlobal() {
		return $this->getSigla() == self::TIPO_JULGAMENTO_SIGLA_GLOBAL;
	}

	/**
	 * Diz se o tipo de julgamento é por lote.
	 * @return bool
	 */
	public function isLote() {
		return $this->getSigla() == self::TIPO_JULGAMENTO_SIGLA_POR_LOTE;
	}

	/**
	 * Diz se o tipo de julgamento é por item.
	 * @return bool
	 */
	public function isItem() {
		return $this->getSigla() == self::TIPO_JULGAMENTO_SIGLA_POR_ITEM;
	}
}