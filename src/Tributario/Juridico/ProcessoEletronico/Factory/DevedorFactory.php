<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

namespace ECidade\Tributario\Juridico\ProcessoEletronico\Factory;


use ECidade\Tributario\Juridico\ProcessoEletronico\Enum\TipoListaEnum;
use ECidade\Tributario\Juridico\ProcessoEletronico\Repository\DevedorRepository;

/**
 * Class DevedorFactory
 * @package ECidade\Tributario\Juridico\ProcessoEletronico\Factory
 */
class DevedorFactory
{
    /**
     * Metodo responsavel por criar o devedor de acordo com tipo
     *
     * @param $type
     * @param $origem
     * @return \ECidade\Tributario\Juridico\ProcessoEletronico\Domain\Devedor|null
     * @throws \BusinessException
     */
    public static function create($type, $origem)
    {
        $oDevedorRepository = new DevedorRepository();

        return match ($type) {
            TipoListaEnum::MATRICULA => $oDevedorRepository->getDevedorMatricula($origem),
            TipoListaEnum::CGM => $oDevedorRepository->getDevedor($origem),
            TipoListaEnum::INSCRICAO => $oDevedorRepository->getDevedorInscricao($origem),
            TipoListaEnum::AUTO_INFRACAO => $oDevedorRepository->getDevedorAuto($origem),
            default => $oDevedorRepository->getDevedor($origem),
        };
    }

}