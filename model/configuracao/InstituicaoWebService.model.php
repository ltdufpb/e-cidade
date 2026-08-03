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

/**
 * Classe responsavel retornar os dados da instituição para o webservice
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 * @package webservices
 */

class InstituicaoWebservice {
  
  /**
   * Instancia da Prefeitura
   * @var Instituicao
   */
  protected $oInstituicao;
  
  /**
   * Código da Instituição
   * @var integer
   */
  protected $iCodigoInstituicao = null;
  
  /**
   * Boolean para identificar uma prefeitura
   * @var boolean
   */
  protected $lPrefeitura = true;
  
  /**
   * Arquivo Imagem do Logo da Instituição
   * @var string
   */
  protected $sImagemLogo;
  
  
  /**
   * Instancia o webservice
   * @param integer $iCodigoInstituicao Código da Instituição
   */
  public function __construct($iCodigoInstituicao) { 

    $this->oInstituicao = new Instituicao($iCodigoInstituicao);
  }
  
  /**
   * Seta Código da Instituição
   * @param integer $iCodigoInstituicao Código da Instituição
   */
  public function setCodigo($iCodigoInstituicao) {
  
    $this->iCodigoInstituicao = $iCodigoInstituicao; 
  }
  
  /**
   * Seta o tipo de instituição
   * @param integer Codigo do Tipo de Instituição
   */
  public function setPrefeitura($lPrefeitura) {
  
    $this->lPrefeitura = $lPrefeitura;
  }
  
  
  /**
   * Retorna os dados da instituição
   * @return stdClass
   */
  public function getDadosInstituicao() {
    
    if (!empty($this->iCodigoInstituicao) && !empty($this->iCodigoTipoInstituicao)) {
      throw new Exception('Nenhum parâmetro exigido foi informado.');
    }
    
    if (!empty($this->iCodigoInstituicao)) {
     
      $this->oInstituicao = new Instituicao($this->iCodigoInstituicao);
    } else {

      $oInstituicao = new Instituicao();
      $this->oInstituicao = $oInstituicao->getDadosPrefeitura();
    }
    
    $oRetorno = new stdClass();
    
    $oRetorno->sDescricao           = mb_convert_encoding($this->oInstituicao->getDescricao(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sDescricaoAbreviada  = mb_convert_encoding($this->oInstituicao->getDescricaoAbreviada(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sCnpj                = mb_convert_encoding($this->oInstituicao->getCNPJ(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sLogradouro          = mb_convert_encoding($this->oInstituicao->getLogradouro(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sMunicipio           = mb_convert_encoding($this->oInstituicao->getMunicipio(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sBairro              = mb_convert_encoding($this->oInstituicao->getBairro(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sTelefone            = mb_convert_encoding($this->oInstituicao->getTelefone(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sSite                = mb_convert_encoding($this->oInstituicao->getSite(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sEmail               = mb_convert_encoding($this->oInstituicao->getEmail(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sIbge                = mb_convert_encoding($this->oInstituicao->getCodigoIbge(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->iNumeroCgm           = mb_convert_encoding($this->oInstituicao->getNumeroCgm(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sNumero              = mb_convert_encoding($this->oInstituicao->getNumero(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sComplemento         = mb_convert_encoding($this->oInstituicao->getComplemento(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sUf                  = mb_convert_encoding($this->oInstituicao->getUf(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sCep                 = mb_convert_encoding($this->oInstituicao->getCep(), 'UTF-8', 'ISO-8859-1');
    $oRetorno->sFax                 = mb_convert_encoding($this->oInstituicao->getFax(), 'UTF-8', 'ISO-8859-1');
   
    $oRetorno->sLogoPrefeituraBaseEncode = NULL;
    
    if ($this->oInstituicao->getImagemLogo() != "") {
     
      $sCaminhoImagem   = 'imagens/files/'.$this->oInstituicao->getImagemLogo();
      $oArquivo         = fopen($sCaminhoImagem, 'r');
      $oArquivoConteudo = fread($oArquivo, filesize($sCaminhoImagem));
      
      $oRetorno->sLogoPrefeituraBaseEncode =  base64_encode($oArquivoConteudo);
    }
    
    return $oRetorno;
  }
}