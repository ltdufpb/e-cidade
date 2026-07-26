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

require_once(modification("model/contabilidade/planoconta/SubSistemaConta.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaCompensado.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaFinanceiroBanco.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaFinanceiroCaixa.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaFinanceiroExtraOrcamentaria.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaFinanceiro.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaPatrimonial.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaOrcamentario.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaNaoAplicado.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaDividaConsolidada.model.php"));
require_once(modification("model/contabilidade/planoconta/SistemaContaFinanceiroInterferencia.model.php"));


/**
 *
 * Strategy para encapsular os tipos de consistema
 * @author dbseller
 * @name SistemaConta
 * @package contabilidade
 * @subpackage planoconta
 *
 */
class SistemaConta
{

    /**
     * Instancia do sistema de Contas
     * @var ISistemaConta
     */
    private $oSistemaConta = null;

    public function __construct($iCodigoSistema)
    {
        $this->oSistemaConta = match ($iCodigoSistema) {
            1 => new SistemaContaFinanceiro(),
            2 => new SistemaContaPatrimonial(),
            3 => new SistemaContaOrcamentario(),
            4 => new SistemaContaCompensado(),
            5 => new SistemaContaFinanceiroCaixa(),
            6 => new SistemaContaFinanceiroBanco(),
            7 => new SistemaContaFinanceiroExtraOrcamentaria(),
            8 => new SistemaContaFinanceiroInterferencia(),
            9 => new SistemaContaDividaConsolidada(),
            0 => new SistemaContaNaoAplicado(),
            default => new SistemaContaNaoAplicado(),
        };
    }


    public function integrarDados(ContaPlano $oContaPlano)
    {
        $this->oSistemaConta->integrarDados($oContaPlano);
    }

    public function excluirDadosIntegrados(ContaPlano $oContaPlano)
    {
        $this->oSistemaConta->excluirDadosIntegrados($oContaPlano);
    }

    /**
     * Retorna o código do tipo Financeiro
     * @see ISistemaConta::getCodigoSistemaConta()
     */
    public function getCodigoSistemaConta()
    {
        return $this->oSistemaConta->getCodigoSistemaConta();
    }

    public function getDescricao()
    {
        return $this->oSistemaConta->getDescricao();
    }
}
