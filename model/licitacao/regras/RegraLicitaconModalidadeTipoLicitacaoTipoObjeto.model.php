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

class RegraLicitaconModalidadeTipoLicitacaoTipoObjeto extends RegraLicitacon
{

    protected $sMensagem = "A combinação entre Modalidade, Critério de Julgamento e Tipo de Objeto não é válida.\n\nVerifique as combinações possíveis entre as modalidades, os critérios de julgamentos e os tipos de objeto disponíveis no LicitaCon no Apêndice C.";

    /**
     * @var array
     */
    protected $aRegrasApendiceC = [
        'CPP' => [
            'NSA' => ['COM']
        ],
        'CPC' => [
            'NSA' => ['OUS', 'SAU']
        ],
        'CHP' => [
            'MTC' => ['CSE', 'COM', 'OUS', 'CON', 'INF', 'SAU'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OUS', 'SAU', 'INF', 'CON'],
            'MTX' => ['COM', 'CSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['CSE', 'COM', 'OUS', 'CON', 'INF', 'SAU'],
            'MLO' => ['CON']
        ],
        'CCE' => [
            'MDE' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU'],
            'MOO' => ['COL', 'PER'],
            'MOQ' => ['COL', 'PER'],
            'MOT' => ['COL', 'PER'],
            'MRE' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MCA' => ['OUS', 'SAU'],
            'MPP' => ['COL', 'PER'],
            'MTC' => ['CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MPR' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'PPP', 'SAU'],
            'MTX' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MVT' => ['COL', 'PPP', 'PER'],
            'MTO' => ['COL', 'PER'],
            'MTT' => ['COL', 'PPP', 'PER'],
            'TPR' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'PPP', 'SAU']
        ],
        'CCP' => [
            'MDE' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU'],
            'MOO' => ['COL', 'PER'],
            'MOQ' => ['COL', 'PER'],
            'MOT' => ['COL', 'PER'],
            'MRE' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MCA' => ['OUS', 'SAU'],
            'MPP' => ['COL', 'PER'],
            'MTC' => ['CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MPR' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'PPP', 'SAU'],
            'MTX' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU'],
            'MVT' => ['COL', 'PPP', 'PER'],
            'MTO' => ['COL', 'PER'],
            'MTT' => ['COL', 'PPP', 'PER'],
            'TPR' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'PPP', 'SAU']
        ],
        'CNC' => [
            'MDE' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'INF', 'SAU'],
            'MLO' => ['ALB', 'CON', 'PER', 'OUS', 'PRI', 'SAU'],
            'MOQ' => ['CON', 'PER', 'COL'],
            'MOT' => ['CON', 'PER', 'COL'],
            'MOO' => ['CON', 'PER', 'COL'],
            'MPP' => ['CON', 'PER', 'COL'],
            'MTC' => ['ALB', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'CON', 'INF', 'PPP', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTO' => ['CON', 'PER', 'COL'],
            'MTT' => ['CON', 'PER', 'COL', 'PPP'],
            'MVT' => ['CON', 'PER', 'COL', 'PPP'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU', 'CON', 'PPP']
        ],
        'CNS' => [
            'MCA' => ['OUS', 'SAU'],
            'MTC' => ['OSE', 'OUS', 'SAU'],
            'NSA' => ['OUS', 'OSE', 'SAU']
        ],
        'CNV' => [
            'MLO' => ['PER'],
            'MOQ' => ['PER'],
            'MOT' => ['PER'],
            'MOO' => ['PER'],
            'MPP' => ['PER'],
            'MTC' => ['CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MPR' => ['CSE', 'CON', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTO' => ['PER'],
            'MTT' => ['PER'],
            'MVT' => ['PER'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'ESE' => [
            'MDE' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'SAU'],
            'MOP' => ['ALB', 'CON', 'OUS', 'PER'],
            'MRE' => ['OSE'],
            'MCA' => ['OUS', 'SAU'],
            'MDB' => ['ALB'],
            'MTC' => ['OUS', 'OSE', 'CSE', 'INF', 'SAU'],
            'MPR' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'LOC', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'SAU']
        ],
        'EST' => [
            'MDE' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'SAU'],
            'MOP' => ['ALB', 'CON', 'OUS', 'PER'],
            'MRE' => ['OSE'],
            'MCA' => ['OUS', 'SAU'],
            'MDB' => ['ALB'],
            'MTC' => ['OUS', 'OSE', 'CSE', 'INF', 'SAU'],
            'MPR' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['OUS', 'OSE', 'CSE', 'COM', 'INF', 'SAU']
        ],
        'LEE' => [
            'MLO' => ['ALB']
        ],
        'LEI' => [
            'MLO' => ['ALB', 'PRI']
        ],
        'MAI' => [
            'NSA' => ['OSE', 'OUS', 'SAU']
        ],
        'PRE' => [
            'MDE' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'INF', 'SAU'],
            'MLO' => ['ALB', 'CON', 'OUS', 'PER', 'SAU'],
            'MOO' => ['CON', 'PER'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'PER', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'PCE' => [
            'MDE' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU'],
            'MLO' => ['CON', 'OUS', 'PER', 'SAU'],
            'MPR' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU', 'PER'],
            'MTX' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU']
        ],
        'PCP' => [
            'MDE' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU'],
            'MLO' => ['CON', 'OUS', 'PER', 'SAU'],
            'MPR' => ['COM', 'CSE', 'INF', 'LOC', 'OSE', 'OUS', 'SAU', 'PER'],
            'MTX' => ['COM', 'CSE', 'INF', 'OSE', 'OUS', 'SAU']
        ],
        'PRP' => [
            'MDE' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'INF', 'SAU'],
            'MLO' => ['ALB', 'CON', 'OUS', 'PER', 'SAU'],
            'MOO' => ['CON', 'PER'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'PER', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'PDE' => [
            'MDE' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'INF', 'SAU'],
            'MLO' => ['ALB', 'CON', 'OUS', 'PER', 'SAU'],
            'MOO' => ['CON', 'PER'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'PER', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'PRD' => [
            'NSA' => ['ALB', 'CSE', 'COM', 'CON', 'LOC', 'OSE', 'OUS', 'PER', 'INF', 'SAU']
        ],
        'PRI' => [
            'NSA' => ['ALB', 'CSE', 'COM', 'OSE', 'OUS', 'LOC', 'CON', 'INF', 'PER', 'SAU']
        ],
        'RDE' => [
            'MDE' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MOP' => ['ALB'],
            'MCA' => ['OUS', 'SAU'],
            'MTC' => ['OSE', 'OUS', 'SAU'],
            'MPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'RDC' => [
            'MDE' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MOP' => ['ALB'],
            'MCA' => ['OUS', 'SAU'],
            'MTC' => ['OSE', 'OUS', 'SAU'],
            'MPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'RPO' => [
            'NSA' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'RIN' => [
            'MLO' => ['ALB'],
            'MTC' => ['CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ],
        'TMP' => [
            'MLO' => ['PER'],
            'MOQ' => ['PER'],
            'MOT' => ['PER'],
            'MOO' => ['PER'],
            'MPP' => ['PER'],
            'MTC' => ['CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MPR' => ['CSE', 'COM', 'LOC', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTX' => ['COM', 'CSE', 'OSE', 'OUS', 'INF', 'SAU'],
            'MTO' => ['PER'],
            'MTT' => ['PER'],
            'MVT' => ['PER'],
            'TPR' => ['CSE', 'COM', 'OSE', 'OUS', 'INF', 'SAU']
        ]
    ];

    protected function getRegras()
    {
        return $this->aRegrasApendiceC;
    }

    public function regra()
    {
        $sModalidade = $this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal();
        $sTipoLicitacao = null;
        $sTipoObjeto = null;
        $aRegras = $this->getRegras();

        if (isset($this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_LICITACAO])) {
            $sTipoLicitacao = $this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_LICITACAO];
        }

        if (isset($this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_OBJETO])) {
            $sTipoObjeto = $this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_OBJETO];
        }

        if (empty($sTipoObjeto)) {
            $this->sMensagem = "O campo Tipo de Objeto é de preenchimento obrigatório.";
            return false;
        }

        if (empty($sTipoLicitacao)) {
            $this->sMensagem = "O campo Critério de Julgamento é de preenchimento obrigatório.";
            return false;
        }

        if (!isset($aRegras[$sModalidade]) || !isset($aRegras[$sModalidade][$sTipoLicitacao])) {
            return false;
        }

        if (!in_array($sTipoObjeto, $aRegras[$sModalidade][$sTipoLicitacao])) {
            return false;
        }

        return true;
    }
}
