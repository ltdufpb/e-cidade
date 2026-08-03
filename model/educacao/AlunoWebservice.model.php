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
 * dac para webservices de aluno
 * Atua como um facade para a classe de Aluno.
 * as informações Retornadas são dos dados de Documentação, matriculas e notas dos alunos
 * @author dbseller
 *
 */
class AlunoWebservice {

  private $iCodigoAluno = null;
  private $oAluno       = null;
  private $oDadosAluno  = null;
  public function __construct($iCodigoAluno) {

    $this->oAluno = new Aluno($iCodigoAluno);
    $this->oDadosAluno = new stdClass();
  }

  /**
   * Retorna todos os Dados do aluno como um StdClass
   */
  public function getDados() {

    $oDadosAluno                               = new stdClass();
    $oDadosAluno->codigo_aluno                 = $this->oAluno->getCodigoAluno();
    $oDadosAluno->codigo_inep                  = $this->oAluno->getCodigoInep();
    $oDadosAluno->nome_aluno                   = mb_convert_encoding($this->oAluno->getNome(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->data_nascimento_aluno        = $this->oAluno->getDataNascimento();

    $oNaturalidade = $this->oAluno->getNaturalidade();
    $oDadosAluno->uf_naturalidade_aluno        = null;
    $oDadosAluno->municipio_naturalidade_aluno = null;

    if ( !is_null($oNaturalidade->getCodigo()) ) {
      $oDadosAluno->municipio_naturalidade_aluno = mb_convert_encoding($this->oAluno->getNaturalidade()->getNome(), 'UTF-8', 'ISO-8859-1');
      $oDadosAluno->uf_naturalidade_aluno        = $this->oAluno->getNaturalidade()->getUF()->getUF();
    }

    $oDadosAluno->nacionalidade_aluno          = '';
    $oDadosAluno->pais_aluno                   = mb_convert_encoding($this->oAluno->getPaisNaturalidade()->getDescricao(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->endereco_residencia_aluno    = mb_convert_encoding($this->oAluno->getEnderecoResidencia(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->numero_residencia_aluno      = mb_convert_encoding($this->oAluno->getNumeroResidencia(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->bairro_residencia_aluno      = mb_convert_encoding($this->oAluno->getBairroResidencia(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->complemento_residencia_aluno = mb_convert_encoding($this->oAluno->getComplementoResidencia(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->zona_residencia_aluno        = mb_convert_encoding($this->oAluno->getZonaResidencia(), 'UTF-8', 'ISO-8859-1');

    $oMunicipio = $this->oAluno->getMunicipioResidencia();
    $oDadosAluno->municipio_residencia_aluno   = null;
    $oDadosAluno->uf_residencia_aluno          = null;
    if ( !is_null($oMunicipio) ) {

      $oDadosAluno->municipio_residencia_aluno = mb_convert_encoding($oMunicipio->getNome(), 'UTF-8', 'ISO-8859-1');
      $oDadosAluno->uf_residencia_aluno        = mb_convert_encoding($oMunicipio->getUF()->getUF(), 'UTF-8', 'ISO-8859-1');
    }

    $oDadosAluno->cep_residencia_aluno         = $this->oAluno->getCepResidencia();
    $oDadosAluno->sexo_aluno                   = mb_convert_encoding($this->oAluno->getSexo() == "M"?"MASCULINO":"FEMININO", 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->raca_aluno                   = mb_convert_encoding($this->oAluno->getRaca(), 'UTF-8', 'ISO-8859-1');
    $sEstadoCivil                              = '';
    switch ($this->oAluno->getEstadoCivil()) {

      case 1:

        $sEstadoCivil = 'SOLTEIRO';
        break;

      case 2:

        $sEstadoCivil = 'CASADO';
        break;

      case 3:

        $sEstadoCivil = 'VIUVO';
        break;

      case 3:

        $sEstadoCivil = 'DIVORCIADO';
        break;
    }

    $sNacionalidade = 'NÃO INFORMADA';
    switch ($this->oAluno->getNacionalidade()) {

      case Aluno::NACIONALIDADE_BRASILEIRA:

        $sNacionalidade = 'BRASILEIRA';
        break;

      case Aluno::NACIONALIDADE_ESTRANGEIRA:

        $sNacionalidade = 'ESTRANGEIRA';
        break;

      case Aluno::NACIONALIDADE_NATURALIZADA:

        $sNacionalidade = 'BRASILEIRA NO EXTERIOR OU NATURALIZADO';
        break;

    }
    $oDadosAluno->nacionalidade_aluno    = mb_convert_encoding($sNacionalidade, 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->estado_civil_aluno     = $sEstadoCivil;
    $oDadosAluno->telefone_aluno         = mb_convert_encoding($this->oAluno->getNumeroTelefone(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->telefone_celular_aluno = mb_convert_encoding($this->oAluno->getNumeroCelular(), 'UTF-8', 'ISO-8859-1');
    $oDadosAluno->foto_aluno             = '';
    $oDadosAluno->none_foto_aluno        = '';
    $oDadosAluno->idade_aluno            = $this->oAluno->getIdadeNaData(date('Y-m-d'));

    db_inicio_transacao();
    $sCaminhoFoto = $this->oAluno->getFoto();
    db_fim_transacao();


    if ($sCaminhoFoto && file_exists($sCaminhoFoto)) {

      $oDadosAluno->none_foto_aluno  = $sCaminhoFoto;
      $oDadosAluno->foto_aluno       = base64_encode(file_get_contents($sCaminhoFoto));
    }

    $oDadosAluno->matriculas   = $this->getMatriculas();
    $oDadosAluno->outros_dados = $this->getOutrosDados();
    $oDadosAluno->documentos   = $this->getDocumentos();

    $oDadosEscola = new stdClass();

    /**
     * Busca os dados da escola do aluno referente a sua ultima matrícula
     */
    $oMatricula = MatriculaRepository::getUltimaMatriculaAluno( $this->oAluno );

    if ( !empty( $oMatricula ) ) {

      $oEscola                            = $oMatricula->getTurma()->getEscola();
      $oDadosEscola->sNome                = mb_convert_encoding($oEscola->getNome(), 'UTF-8', 'ISO-8859-1');

      $aDiretores = $oEscola->getDiretor();

      for( $iContador = 0; $iContador < count($aDiretores); $iContador++ )  {

        $aDiretores[$iContador]->sNome     = mb_convert_encoding($aDiretores[$iContador]->sNome, 'UTF-8', 'ISO-8859-1');
        $aDiretores[$iContador]->sAtoLegal = mb_convert_encoding($aDiretores[$iContador]->sAtoLegal, 'UTF-8', 'ISO-8859-1');
        $aDiretores[$iContador]->sTurno    = mb_convert_encoding($aDiretores[$iContador]->sTurno, 'UTF-8', 'ISO-8859-1');
      }

      $oDadosEscola->aDiretores           = $aDiretores;
      $oDadosEscola->sUrl                 = mb_convert_encoding($oEscola->getHomePage(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sEndereco            = mb_convert_encoding($oEscola->getEndereco(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->iNumeroEndereco      = $oEscola->getNumeroEndereco();
      $oDadosEscola->sComplementoEndereco = mb_convert_encoding($oEscola->getComplementoEndereco(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sBairro              = mb_convert_encoding($oEscola->getBairro(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sMunicipio           = mb_convert_encoding($oEscola->getMunicipio(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sUf                  = mb_convert_encoding($oEscola->getUf(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sEstado              = mb_convert_encoding($oEscola->getEstado(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sCep                 = mb_convert_encoding($oEscola->getCep(), 'UTF-8', 'ISO-8859-1');
      $oDadosEscola->sEmail               = mb_convert_encoding($oEscola->getEmail(), 'UTF-8', 'ISO-8859-1');

      $aTelefones = $oEscola->getTelefones();

      for( $iContador = 0; $iContador < count($aTelefones); $iContador++ )  {

        $aTelefones[$iContador]->sObservacao   = mb_convert_encoding($aTelefones[$iContador]->sObservacao, 'UTF-8', 'ISO-8859-1');
        $aTelefones[$iContador]->sTipoTelefone = mb_convert_encoding($aTelefones[$iContador]->sTipoTelefone, 'UTF-8', 'ISO-8859-1');
      }

      $oDadosEscola->aTelefones = $aTelefones;
    }

    $oDadosAluno->oEscola = $oDadosEscola;

    return $oDadosAluno;
  }


  /**
   * Retorna todas as Matriculas de um Aluno
   */
  public function getMatriculas() {

    $aMatriculas = [];
    foreach ($this->oAluno->getMatriculas() as $oMatriculaAluno) {

      $oMatricula                   = new stdClass();
      $oMatricula->etapa_matricula  = mb_convert_encoding($oMatriculaAluno->getEtapaDeOrigem()->getNome(), 'UTF-8', 'ISO-8859-1');
      $oMatricula->codigo_matricula = $oMatriculaAluno->getCodigo();
      $oMatricula->ano_matricula    = $oMatriculaAluno->getTurma()->getCalendario()->getAnoExecucao();
      $aMatriculas[]                = $oMatricula;
    }

    uasort($aMatriculas, ordernarMatriculas(...));
    return $aMatriculas;
  }

  /**
   * REtorna outros dados do aluno
   */
  protected function getOutrosDados() {

    $oOutrosDados                                   = new stdClass();
    $oOutrosDados->filiacao_aluno                   = '';
    $oOutrosDados->pai_aluno                        = '';
    $oOutrosDados->mae_aluno                        = '';
    $oOutrosDados->responsavel_aluno                = '';
    $oOutrosDados->email_responsavel_aluno          = '';
    $oOutrosDados->celular_responsavel_aluno        = '';
    $oOutrosDados->bolsa_familia_aluno              = '';
    $oOutrosDados->numero_nis_aluno                 = '';
    $oOutrosDados->transporte_publico_aluno         = '';
    $oOutrosDados->poder_publico_transporte         = '';
    $oOutrosDados->email_aluno                      = '';
    $oOutrosDados->profissao_aluno                  = '';
    $oOutrosDados->escolarizacao_outro_espaco_aluno = '';
    $oOutrosDados->data_cadastramento_aluno         = '';
    $oOutrosDados->ultima_alteracao_aluno           = '';
    $oOutrosDados->observacao_aluno                 = '';
    $oOutrosDados->contato_aluno                    = '';
    $oOutrosDados->local_procedencia                = '';
    $oOutrosDados->data_procedencia                 = '';
    $oDaoAluno       = new cl_aluno;
    $sSqlOutrosDados = $oDaoAluno->sql_query_file($this->oAluno->getCodigoAluno());
    $rsOutrosDados   = $oDaoAluno->sql_record($sSqlOutrosDados);
    if ($rsOutrosDados && $oDaoAluno->numrows > 0) {

      $oDadosAluno = db_utils::fieldsMemory($rsOutrosDados, 0);

      $sEscolarizacaoOutroEspaco = '';
      $sEscolarizacaoOutroEspaco = match ($oDadosAluno->ed47_c_atenddifer) {
          "1" => "EM HOSPITAL",
          '2' => "EM DOMICÍLIO",
          default => "NÃO RECEBE",
      };
      $sTipoTransportePublico = 'NÃO INFORMADO';
      switch ($oDadosAluno->ed47_c_transporte) {

        case '1':

          $sTipoTransportePublico = 'ESTADUAL';
          break;

        case '2':

          $sTipoTransportePublico = "MUNICIPAL";
          break;
      }
      $oOutrosDados->filiacao_aluno            = mb_convert_encoding($oDadosAluno->ed47_i_filiacao == "0"
                                                                          ? "NÃO DECLARADO/IGNORADO" : "PAI E/OU MÃE", 'UTF-8', 'ISO-8859-1'
                                                            );
      $oOutrosDados->pai_aluno                 = mb_convert_encoding($oDadosAluno->ed47_v_pai, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->mae_aluno                 = mb_convert_encoding($oDadosAluno->ed47_v_mae, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->responsavel_aluno         = mb_convert_encoding($oDadosAluno->ed47_c_nomeresp, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->email_responsavel_aluno   = mb_convert_encoding($oDadosAluno->ed47_c_emailresp, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->celular_responsavel_aluno = mb_convert_encoding($oDadosAluno->ed47_celularresponsavel, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->bolsa_familia_aluno       = mb_convert_encoding($oDadosAluno->ed47_c_bolsafamilia == 'S' ? 'SIM' : 'NÃO', 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->numero_nis_aluno          = $oDadosAluno->ed47_c_nis;

      $oOutrosDados->transporte_publico_aluno  = mb_convert_encoding($oDadosAluno->ed47_i_transpublico == "0" ? "NÃO UTILIZA"
                                                                                                      : "UTILIZA", 'UTF-8', 'ISO-8859-1'
                                                            );

      $oOutrosDados->poder_publico_transporte         = mb_convert_encoding($sTipoTransportePublico, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->email_aluno                      = mb_convert_encoding($oDadosAluno->ed47_v_email, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->profissao_aluno                  = mb_convert_encoding($oDadosAluno->ed47_v_profis, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->escolarizacao_outro_espaco_aluno = mb_convert_encoding($sEscolarizacaoOutroEspaco, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->data_cadastramento_aluno         = $oDadosAluno->ed47_d_cadast;
      $oOutrosDados->ultima_alteracao_aluno           = $oDadosAluno->ed47_d_ultalt;
      $oOutrosDados->observacao_aluno                 = mb_convert_encoding($oDadosAluno->ed47_t_obs, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->contato_aluno                    = mb_convert_encoding($oDadosAluno->ed47_v_contato, 'UTF-8', 'ISO-8859-1');


      $oOutrosDados->transportes_utilizados = [];
      $oDaoAlunoTransportes                 = new cl_alunocensotipotransporte();
      $sWhereTransportes                    = "ed311_aluno = {$this->oAluno->getCodigoAluno()}";
      $sSqlTransportes                      = $oDaoAlunoTransportes->sql_query_tipo_transporte(null,
                                                                                               "ed312_descricao",
                                                                                               "ed312_descricao",
                                                                                               $sWhereTransportes
                                                                                              );
      $rsTransportes = $oDaoAlunoTransportes->sql_record($sSqlTransportes);
      if ($rsTransportes && $oDaoAlunoTransportes->numrows > 0) {

        for ($iTransporte = 0; $iTransporte < $oDaoAlunoTransportes->numrows; $iTransporte++) {

          $sDescricaoTransporte = db_utils::fieldsMemory($rsTransportes, $iTransporte)->ed312_descricao;

          $oOutrosDados->transportes_utilizados[] = mb_convert_encoding($sDescricaoTransporte, 'ISO-8859-1');
        }
      }
    }

    $oDaoPrimeiraMatricula = new cl_alunoprimat();
    $sWhereProcedencia     = "ed76_i_aluno = {$this->oAluno->getCodigoAluno()}";
    $sCamposProcendencia   = "case when ed76_c_tipo = 'M' then escola.ed18_c_nome else ed82_c_nome end as nome_escola,";
    $sCamposProcendencia  .= "ed76_d_data";
    $sSqlProcedencia       = $oDaoPrimeiraMatricula->sql_query(null, $sCamposProcendencia, null, $sWhereProcedencia);
    $rsProcedencia        = $oDaoPrimeiraMatricula->sql_record($sSqlProcedencia);
    if ($rsProcedencia && $oDaoPrimeiraMatricula->numrows > 0) {

      $oDadosProcedencia               = db_utils::fieldsMemory($rsProcedencia, 0);
      $oOutrosDados->local_procedencia = mb_convert_encoding($oDadosProcedencia->nome_escola, 'UTF-8', 'ISO-8859-1');
      $oOutrosDados->data_procedencia  = mb_convert_encoding($oDadosProcedencia->ed76_d_data, 'UTF-8', 'ISO-8859-1');
    }
    return $oOutrosDados;
  }

  /**
   * retorna os documentos do cidadao
   */
  protected function getDocumentos() {

    $oDocumentos                                     = new stdClass();
    $oDocumentos->certidao_nascimento                = new stdClass();
    $oDocumentos->certidao_nascimento->tipo_certidao = '';
    $oDocumentos->certidao_nascimento->numero_termo  = '';
    $oDocumentos->certidao_nascimento->livro         = '';
    $oDocumentos->certidao_nascimento->folha         = '';
    $oDocumentos->certidao_nascimento->data_emissao  = '';
    $oDocumentos->certidao_nascimento->cartorio      = '';
    $oDocumentos->certidao_nascimento->municipio     = '';
    $oDocumentos->certidao_nascimento->uf            = '';
    $oDocumentos->certidao_nascimento->matricula     = '';


    $oDocumentos->identidade                 = new stdClass();
    $oDocumentos->identidade->numero         = '';
    $oDocumentos->identidade->complemento    = '';
    $oDocumentos->identidade->uf_emissao     = '';
    $oDocumentos->identidade->orgao_emissor  = '';
    $oDocumentos->identidade->data_expedicao = '';

    $oDocumentos->cnh                  = new stdClass();
    $oDocumentos->cnh->numero          = '';
    $oDocumentos->cnh->categoria       = '';
    $oDocumentos->cnh->data_emissao    = '';
    $oDocumentos->cnh->primeira_cnh    = '';
    $oDocumentos->cnh->data_vencimento = '';

    $oDocumentos->cpf        = '';
    $oDocumentos->passaporte = '';
    $oDaoAluno      = new cl_aluno;

    $sSqlDocumentos = $oDaoAluno->sql_query_file($this->oAluno->getCodigoAluno());
    $rsDocumentos   = $oDaoAluno->sql_record($sSqlDocumentos);
    if ($rsDocumentos && $oDaoAluno->numrows > 0) {

      $oDadosDocumento = db_utils::fieldsMemory($rsDocumentos, 0);
      $sTipoCertidao = "Não Informado";
      switch ($oDadosDocumento->ed47_c_certidaotipo) {

        case 'C':

          $sTipoCertidao = "CASAMENTO";
          break;
        case 'N':

          $sTipoCertidao = "NASCIMENTO";
          break;
      }
      $sCartorio          = '';
      $sMatricula         = "Não Informado ";
      if ($oDadosDocumento->ed47_i_censocartorio != "") {

        $oCartorio = CensoCartorioRepository::getCensoCartorioByCodigo($oDadosDocumento->ed47_i_censocartorio);
        $sCartorio = $oCartorio->getNome();

      }
      if ($oDadosDocumento->ed47_i_censomuniccert != "") {

        $oMunicipioCartorio = CensoMunicipioRepository::getMunicipioByCodigo($oDadosDocumento->ed47_i_censomuniccert);
        $oDocumentos->certidao_nascimento->municipio     = mb_convert_encoding($oMunicipioCartorio->getNome(), 'UTF-8', 'ISO-8859-1');
        $oDocumentos->certidao_nascimento->uf            = mb_convert_encoding($oMunicipioCartorio->getUF()->getUF(), 'UTF-8', 'ISO-8859-1');
      }

      $oDocumentos->certidao_nascimento->tipo_certidao = mb_convert_encoding($sTipoCertidao, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->certidao_nascimento->numero_termo  = mb_convert_encoding($oDadosDocumento->ed47_c_certidaonum, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->certidao_nascimento->livro         = mb_convert_encoding($oDadosDocumento->ed47_c_certidaolivro, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->certidao_nascimento->folha         = mb_convert_encoding($oDadosDocumento->ed47_c_certidaofolha, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->certidao_nascimento->data_emissao  = mb_convert_encoding($oDadosDocumento->ed47_c_certidaodata, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->certidao_nascimento->cartorio      = mb_convert_encoding($sCartorio, 'UTF-8', 'ISO-8859-1');
      if (!empty($oDadosDocumento->ed47_certidaomatricula)) {

        $sMatricula  = substr((string) $oDadosDocumento->ed47_certidaomatricula, 0, 6)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 6, 2)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 8, 2)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 10, 4)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 14, 1)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 15, 5)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 20, 3)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 23, 7)." ";
        $sMatricula .= substr((string) $oDadosDocumento->ed47_certidaomatricula, 30, 2);
      }
      $oDocumentos->certidao_nascimento->matricula = mb_convert_encoding($sMatricula, 'UTF-8', 'ISO-8859-1');

      /**
       * Dados da carteira de identidade
       */
      $sUfIdentidade = '';
      if (!empty($oDadosDocumento->ed47_i_censoufident)) {
        $sUfIdentidade = CensoUFRepository::getEstadoPorCodigo($oDadosDocumento->ed47_i_censoufident)->getUF();
      }
      $oDocumentos->identidade->numero         = mb_convert_encoding($oDadosDocumento->ed47_v_ident, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->identidade->complemento    = mb_convert_encoding($oDadosDocumento->ed47_v_identcompl, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->identidade->uf_emissao     = mb_convert_encoding($sUfIdentidade, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->identidade->data_expedicao = mb_convert_encoding($oDadosDocumento->ed47_d_identdtexp, 'UTF-8', 'ISO-8859-1');
      if (!empty($oDadosDocumento->ed47_i_censoorgemissrg)) {

        $oEmissor = new CensoOrgaoEmissorRG($oDadosDocumento->ed47_i_censoorgemissrg);
        $oDocumentos->identidade->orgao_emissor  = mb_convert_encoding($oEmissor->getNome(), 'UTF-8', 'ISO-8859-1');
      }


      /**
       * Dados da CNH
       */
      $oDocumentos->cnh->numero          = mb_convert_encoding($oDadosDocumento->ed47_v_cnh, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->cnh->categoria       = mb_convert_encoding($oDadosDocumento->ed47_v_categoria, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->cnh->data_emissao    = mb_convert_encoding($oDadosDocumento->ed47_d_dtemissao, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->cnh->primeira_cnh    = mb_convert_encoding($oDadosDocumento->ed47_d_dthabilitacao, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->cnh->data_vencimento = mb_convert_encoding($oDadosDocumento->ed47_d_dtvencimento, 'UTF-8', 'ISO-8859-1');

      /**
       * cpf e passaporte
       */
      $oDocumentos->cpf        = mb_convert_encoding($oDadosDocumento->ed47_v_cpf, 'UTF-8', 'ISO-8859-1');
      $oDocumentos->passaporte = mb_convert_encoding($oDadosDocumento->ed47_c_passaporte, 'UTF-8', 'ISO-8859-1');
    }
    return $oDocumentos;
  }
}

/**
 * Ordena as matriculas pelo ano decrescente
 * @param unknown $oMatriculaAtual
 * @param unknown $oProximaMatricula
 * @return number
 */
function ordernarMatriculas($oMatriculaAtual, $oProximaMatricula)
{
    return $oProximaMatricula->ano_matricula <=> $oMatriculaAtual->ano_matricula;
}