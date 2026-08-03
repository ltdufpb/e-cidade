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

namespace ECidade\RecursosHumanos\Pessoal\Sagres;

use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\CodigoAgrupamentoFolhaPagamento;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\Cargos;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\CodigoVantagensDescontos;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\FolhaPagamento;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\HistoricoFuncionalSagres;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\Matricula;
use ECidade\RecursosHumanos\Pessoal\Sagres\Tipos\Servidores;
use Exception;

/**
 * Class ArquivosFactory
 * @package ECidade\RecursosHumanos\Pessoal\Sagres
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
            'Servidores' => new Servidores(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'Matricula' => new Matricula(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'Cargos' => new Cargos(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'HistoricoFuncional' => new HistoricoFuncionalSagres(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'CodigoVantagensDescontos' => new CodigoVantagensDescontos(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'FolhaPagamento' => new FolhaPagamento(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            'CodigoAgrupamentoFolhaPagamento' => new CodigoAgrupamentoFolhaPagamento(
                $params,
                $codigoInstituicoes,
                $this->ano,
                $codigoTCE
            ),
            default => throw new Exception("Classe {$arquivo} não implementada."),
        };
    }
}
