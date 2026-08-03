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

require_once modification('libs/db_utils.php');

use ECidade\V3\Extension\Registry;
use ECidade\V3\Datasource\Database;

$parametros = JSON::requestParameters();

$retorno = new stdClass();
$retorno->status = 1;
$retorno->mensagem = '';

try{

    switch ($parametros->exec){

        case 'setCookieDatabase':

            setcookie("DB_base", (string) $parametros->base, ['expires' => 0, 'path' => "/"]);
            setcookie("DB_servidor", (string) $parametros->servidor, ['expires' => 0, 'path' => "/"]);
            setcookie("DB_porta", (string) $parametros->port, ['expires' => 0, 'path' => "/"]);

            break;

        case 'destroyCookieDatabase':

            setcookie("DB_base", '', ['expires' => 0, 'path' => "/"]);
            setcookie("DB_servidor", '', ['expires' => 0, 'path' => "/"]);
            setcookie("DB_porta", '', ['expires' => time() - 3600, 'path' => "/"]);

            break;

        default:
            throw new Exception("Opção inválida!");

    }

} catch (Exception $erro){

    db_fim_transacao(true);
    $retorno->status = 2;
    $retorno->mensagem = $erro->getMessage();
}

$retorno->erro = $retorno->status == 2;
echo JSON::create()->stringify($retorno);
