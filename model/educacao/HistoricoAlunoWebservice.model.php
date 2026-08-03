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
 * Classe que prove os dados do historico do aluno para os webservices do portal do aluno
 * @author dbseller
 *
 */
class HistoricoAlunoWebservice {
  
  
  /**
   * Instancia do aluno
   * @var Aluno
   */
  protected $oAluno;
  
  /**
   * Instancia o webservice
   * @param integer $iCodigoAluno Codigo do aluno
   */
  public function __construct($iAluno) {
    
    $this->oAluno = new Aluno($iAluno);
    
  }
  
  /**
   * Retorna os historicos do aluno
   * @return stdClass
   */
  public function getHistoricos() {
    
    $oDaoHistorico = new cl_historico();
    $iCodigoAluno  = $this->oAluno->getCodigoAluno();
    $sSqlHistorico = $oDaoHistorico->sql_query_file(null, "ed61_i_codigo",
                                                    "ed61_i_codigo",
                                                    "ed61_i_aluno = {$iCodigoAluno}"
                                                   );
    $rsHistoricos            = $oDaoHistorico->sql_record($sSqlHistorico);
    $iTotalLinhas            = $oDaoHistorico->numrows;
    $oHistoricoDados         = new stdClass();
    $oHistoricoDados->etapas = [];
    $oHistoricoDados->linhas = $iTotalLinhas;
    $oHistoricoDados->query  = $sSqlHistorico;
    if ($rsHistoricos && $iTotalLinhas > 0) {
      
      for ($i = 0; $i < $iTotalLinhas; $i++) {
        
        $iCodigoHistorico = db_utils::fieldsMemory($rsHistoricos, $i)->ed61_i_codigo;
        $oHistorico = new HistoricoAluno($iCodigoHistorico);
        $oHistorico->setAluno($this->oAluno);
        foreach ($this->getEtapasHistorico($oHistorico) as $oEtapa) {
           $oHistoricoDados->etapas[] = $oEtapa;
        }
      }
    }
    
    uasort($oHistoricoDados->etapas, $this->ordenarEtapas(...));
    return $oHistoricoDados;
  }
  
  /**
   * Retorna as etapas do historico do aluno
   * @param HistoricoAluno $oHistorico Instancia do historico
   * @return stdClass
   */
  protected function getEtapasHistorico(HistoricoAluno $oHistorico) {
    
    $aEtapas = [];
    foreach ($oHistorico->getEtapas() as $oEtapa) {
      
      /**
       * ignoramos etapas reprovadas, ou etapas que o aluno está com aprovacao parcial
       */
      if ($oEtapa->getResultadoAno() == "R" || $oEtapa->getResultadoAno() == "P") {
        continue;
      }
      $iAno            = $oEtapa->getAnoCurso();
      $iEnsino         = $oEtapa->getEtapa()->getEnsino()->getCodigo();
      $sTermoResultado = DBEducacaoTermo::getTermoEncerramento($iEnsino, $oEtapa->getResultadoAno(), $iAno);
      
      $oEtapaRetorno                    = new stdClass();
      $oEtapaRetorno->etapa             = mb_convert_encoding($oEtapa->getEtapa()->getNome(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->curso             = mb_convert_encoding($oHistorico->getCursoHistorico()->getNome(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->escola_etapa      = mb_convert_encoding($oEtapa->getEscola()->getNome(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->ano_etapa         = mb_convert_encoding($oEtapa->getAnoCurso(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->minimo_aprovacao  = mb_convert_encoding($oEtapa->getMininoParaAprovacao(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->resultado_etapa   = mb_convert_encoding($sTermoResultado[0]->sDescricao, 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->ordem_etapa       = mb_convert_encoding($oEtapa->getEtapa()->getOrdem(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->situacao_etapa    = mb_convert_encoding($oEtapa->getSituacaoEtapa(), 'UTF-8', 'ISO-8859-1');
      $oEtapaRetorno->disciplinas_etapa = $this->getDisciplinasDaEtapa($oEtapa);
      $oEtapaRetorno->dias_letivos      = $oEtapa->getDiasLetivos();
      $oEtapaRetorno->carga_horaria     = $oEtapa->getCargaHoraria();
      $aEtapas[] = $oEtapaRetorno;
    }
    return $aEtapas;
  }
  
  /**
   * Retorna as disciplinas cursadas na etapa
   * @param HistoricoEtapa $oEtapa
   * @return multitype:stdClass
   */
  protected function getDisciplinasDaEtapa (HistoricoEtapa $oEtapa) {
    
    $aDisciplinas = [];
    $iAno            = $oEtapa->getAnoCurso();
    $iEnsino         = $oEtapa->getEtapa()->getEnsino()->getCodigo();
    foreach ($oEtapa->getDisciplinas() as $oDisciplinaHistorico) {

      $sTermoResultado = DBEducacaoTermo::getTermoEncerramento(
                                                               $iEnsino,
                                                               $oDisciplinaHistorico->getResultadoFinal(),
                                                               $iAno
                                                               );
      
      $oDisciplina                            = new stdClass();
      $oDisciplina->nome_disciplina           = mb_convert_encoding($oDisciplinaHistorico->getDisciplina()->getNomeDisciplina(), 'UTF-8', 'ISO-8859-1');
      $oDisciplina->resultado_disciplina      = mb_convert_encoding($sTermoResultado[0]->sDescricao, 'UTF-8', 'ISO-8859-1');
      $oDisciplina->aproveitamento_disciplina = mb_convert_encoding($oDisciplinaHistorico->getResultadoObtido(), 'UTF-8', 'ISO-8859-1');
      $oDisciplina->situacao_disciplina       = mb_convert_encoding($oDisciplinaHistorico->getSituacaoDisciplina(), 'UTF-8', 'ISO-8859-1');
      $oDisciplina->carga_horaria             = mb_convert_encoding($oDisciplinaHistorico->getCargaHoraria(), 'UTF-8', 'ISO-8859-1');
      $oDisciplina->ordem_disciplina          = mb_convert_encoding($oDisciplinaHistorico->getOrdem(), 'UTF-8', 'ISO-8859-1');
      $aDisciplinas[] = $oDisciplina;
    }
    return $aDisciplinas;
  }
  
  /**
   * Metodo para ordenar as etapas corretamente
   * @param stdClass $oEtapaAtual Dados com a etapa Atual
   * @param unknown $oProximaEtapa Dados com a proxima etapa
   * @return number
   */
  protected function ordenarEtapas($oEtapaAtual, $oProximaEtapa) {
    
    return ($oEtapaAtual->ordem_etapa < $oProximaEtapa->ordem_etapa) ? -1 : 1;
  }
}