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

session_start();

/**
 * Leva a intancia da Execuчуo do Programa para a pasta RAIZ do e-Cidade.
 */
global $_SESSION;
global $_SERVER;
global $_POST;
global $_GET;

$_POST            = [];
$_GET             = [];

ini_set("soap.wsdl_cache_enabled", "0");

require_once(modification("libs/db_conn.php"));

$_SESSION['DB_id_usuario'       ] = '1';
$_SESSION['DB_login'            ] = 'dbseller';
$_SESSION['DB_administrador'    ] = '1';
$_SESSION['DB_ip'               ] = '127.0.0.1';
$_SESSION['REQUEST_URI'         ] = '';
$_SESSION['DB_configuracao_ok'  ] = '';
$_SESSION['DB_acessado'         ] = '1325613';
$_SESSION['DB_base'             ] = $DB_BASE;
$_SESSION['DB_servidor'         ] = $DB_SERVIDOR;
$_SESSION['DB_porta'            ] = $DB_PORTA;
$_SESSION['DB_user'             ] = $DB_USUARIO;
$_SESSION['DB_senha'            ] = $DB_SENHA;
$_SESSION['DB_uol_hora'         ] = time();
$_SESSION['DB_totalmodulos'     ] = '55';
$_SESSION['DB_use_pcasp'        ] = 'f';
$_SESSION['DB_Area'             ] = '1';
$_SESSION['DB_modulo'           ] = '578';
$_SESSION['DB_nome_modulo'      ] = 'Configuraчѕes';
$_SESSION['DB_anousu'           ] =  date('Y', time());
$_SESSION['DB_datausu'          ] = time();//
$_SESSION['DB_coddepto'         ] = '1';
$_SESSION['DB_nomedepto'        ] = 'COINF';
$_SESSION['DB_itemmenu_acessado'] = '1576';
//$HTTP_SERVER_VARS['SERVER_NAME']           = $DB_SERVIDOR;
$_SERVER['SERVER_ADDR']           = '127.0.0.1';
//$HTTP_SERVER_VARS['SERVER_PORT']           = '80';
$_SERVER['REMOTE_ADDR']           = $_SERVER['REMOTE_ADDR'];//'127.0.0.1';
$_SERVER['DOCUMENT_ROOT']         = '/var/www';
$_SERVER['SERVER_ADMIN']          = 'webmaster@localhost';
$_SERVER['SCRIPT_FILENAME']       = __DIR__.'/requisicao.webservice.php';
$_SERVER['SCRIPT_NAME']           = __DIR__.'/requisicao.webservice.php';
$_SERVER['PHP_SELF']              = ECIDADE_REQUEST_ROOT.'/webservices/requisicao.webservice.php';
$_SERVER['REQUEST_URI']           = '';
//$HTTP_SERVER_VARS['HTTP_HOST']             = 'localhost';

/**
 * @todo: movido as requisicoes pois precisam das variaveis setadas da sessao
 */
require_once(modification("libs/db_app.utils.php"));
require_once(modification("libs/db_stdlib.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("libs/db_utils.php"));
require_once("libs/db_autoload.php");

$conn           = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA");
$rsStartSession = pg_query("select fc_startsession()");

$iInstituicao    = 1;
/**
 * Define DB_instit para Instituiчуo prefeitura
 * @todo  verificar possibilidade de utilizar via db_conecta
 */
$sSqlInstituicao = "select codigo from db_config where prefeitura is true";
if($conn){

  $rsInstituicao   = pg_query($sSqlInstituicao);
  if($rsInstituicao){
    $iInstituicao  = pg_fetch_result($rsInstituicao, 0, 'codigo');
  }
}
/**
 *
 */
$_SESSION['DB_instit'] = $iInstituicao;

$_SESSION                  = $_SESSION;
$_SERVER                   = $_SERVER;
$_POST                     = $_POST;
$_GET                      = $_GET;

require_once(modification("model/webservices/DBWebService.model.php"));

require_once(modification("libs/db_conecta.php"));
