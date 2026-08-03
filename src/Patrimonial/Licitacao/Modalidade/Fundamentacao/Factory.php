<?php
/**
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
namespace ECidade\Patrimonial\Licitacao\Modalidade\Fundamentacao;

use \ParameterException;

/**
 * Factory que cria a modalidade com as suas fundamentações pelo código
 */
class Factory
{
    public function getModalidadeDepara($iModalidade)
    {
        return match ($iModalidade) {
            29 => new PRI(),
            30 => new CNV(),
            31 => new TMP(),
            32 => new CNC(),
            33 => new PRP(),
            34 => new PRE(),
            35 => new RIN(),
            48 => new CNS(),
            49 => new RDC(),
            50 => new RPO(),
            28, 51, 52 => new PRD(),
            53 => new CHP(),
            54 => new CPC(),
            55 => new LEI(),
            56 => new MAI(),
            57 => new ESE(),
            58 => new EST(),
            59 => new LEE(),
            60 => new RDE(),
            62 => new PDE(),
            61 => new CPP(),
            63 => new CCP(),
            64 => new CCE(),
            65 => new PCE(),
            66 => new PCP(),
            default => throw new ParameterException("A Modalidade informada não tem Fundamentações."),
        };
    }
}
