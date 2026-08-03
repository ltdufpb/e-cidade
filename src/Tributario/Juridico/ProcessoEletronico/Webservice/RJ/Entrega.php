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
namespace ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ;
use ECidade\Tributario\Juridico\ProcessoEletronico\Documento as DocumentoModel;
use ECidade\Tributario\Juridico\ProcessoEletronico\Repository\Documento;
use ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoEntregarManifestacaoProcessual;
use ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\Usuario;

/**
 * Manipulacao de XMLs no padrao do C.R.A
 */
class Entrega
{
    private $usuario;


    /**
     * Monta o xml de envio da remessa
     * @param  array $aDadosRemessa Dados a serem enviados na remesssa
     * @return mixed
     * @throws \DBException
     */

    public function entregarManifestacaoProcessual($aDadosRemessa = null)
    {

        $oOrigem = $aDadosRemessa;


        /**
         * Instancia os objetos do XSD
         */

        $oEntregar     = new TipoEntregarManifestacaoProcessual();
        $oDadosBasicos = new TipoCabecalhoProcesso();
        $oPessoa = new TipoPessoa();
        $oPessoaEndereco = new TipoEndereco();
        $oAssunto = new TipoAssuntoProcessual();
        $oAssuntoLocal = new TipoAssuntoLocal();
        $oDocumento = new TipoDocumento();


        /**
         * MANIFESTAÇÃO PROCESSUAL
         */

        $oEntregar->idManifestante = $this->getUsuario()->getUsuario();
        $oEntregar->senhaManifestante = $this->getUsuario()->getSenha();
        $oEntregar->numeroProcesso = '';

        /**
         * DADOS BÁSICOS > OUTRO PARAMETRO
         */

        $aOutroParametros = [];
        foreach ($oOrigem->certidoes as $certidao) {

            $aOutroParametros = array_merge($aOutroParametros, [

            [
                'nome' => 'DADOS_CDA',
                'valor' => $certidao->numero_certidao . '_' .
                    $certidao->ano_exercicio . '_' .
                    $certidao->moeda_divida . '_' .
                    $certidao->valor_divida.'_'.$certidao->ufir_divida

            ],
            ['nome' => 'NOME_DEVEDOR', 'valor'           => mb_convert_encoding($oOrigem->nome_devedor, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'NUMERO_INSCRICAO', 'valor'       => mb_convert_encoding($oOrigem->numero_inscricao, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'NATUREZA_DIVIDA', 'valor'        => mb_convert_encoding($oOrigem->natureza_divida, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'TIPO_LOGRADOURO', 'valor'        => mb_convert_encoding($oOrigem->tipo_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'NOME_LOGRADOURO', 'valor'        => mb_convert_encoding($oOrigem->nome_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'NUMERO_LOGRADOURO', 'valor'      => ($oOrigem->numero_logradouro)],
            ['nome' => 'COMPLEMENTO_LOGRADOURO', 'valor' => mb_convert_encoding($oOrigem->complemento_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'BAIRRO_LOGRADOURO', 'valor'      => mb_convert_encoding($oOrigem->bairro_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'CIDADE_LOGRADOURO', 'valor'      => mb_convert_encoding($oOrigem->cidade_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'UF_LOGRADOURO', 'valor'          => mb_convert_encoding($oOrigem->uf_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'CEP_LOGRADOURO', 'valor'         => mb_convert_encoding($oOrigem->cep_logradouro, 'UTF-8', 'ISO-8859-1')],
            ['nome' => 'BASE_LEGAL', 'valor'             => mb_convert_encoding($certidao->base_legal, 'UTF-8', 'ISO-8859-1')]
            ]);

        }

        /**
         * DADOS BASICOS > PESSOA
         */

        $oPessoa->outroNome = ''; // string
        $oPessoa->documento = '';
        $oPessoa->pessoaRelacionada = false;
        $oPessoa->pessoaVinculada = '';                                    // tipoPessoa ( precisa ???? )
        $oPessoa->tipoPessoa = mb_convert_encoding($oOrigem->tipo_pessoa, 'UTF-8', 'ISO-8859-1'); // tipoQualificacaoPessoa
        $oPessoa->numeroDocumentoPrincipal = mb_convert_encoding($oOrigem->cpf, 'UTF-8', 'ISO-8859-1');                         // string
        $oPessoa->cidadeNatural = mb_convert_encoding($oOrigem->cidade_natural, 'UTF-8', 'ISO-8859-1'); // string
        $oPessoa->nacionalidade = 'BR';  // string
        $oPessoa->estadoNatural = '';                                    // string
        $oPessoa->dataObito = '';                                    // string
        $oPessoa->sexo = mb_convert_encoding($oOrigem->sexo, 'UTF-8', 'ISO-8859-1');            // modalidadeGeneroPessoa
        $oPessoa->nome = mb_convert_encoding($oOrigem->nome, 'UTF-8', 'ISO-8859-1');           // string
        $oPessoa->nomeGenitor = mb_convert_encoding($oOrigem->nome_genitor, 'UTF-8', 'ISO-8859-1');   // string
        $oPessoa->dataNascimento = mb_convert_encoding($oOrigem->data_nascimento, 'UTF-8', 'ISO-8859-1');// string
        $oPessoa->nomeGenitora = mb_convert_encoding($oOrigem->nome_genitora, 'UTF-8', 'ISO-8859-1');  // string

        /**
         * DADOS BASICOS > PESSOA > ENDERECO
         */

        $oPessoaEndereco->logradouro = mb_convert_encoding($oOrigem->logradouro, 'UTF-8', 'ISO-8859-1');  // string
        $oPessoaEndereco->numero = mb_convert_encoding($oOrigem->numero_end, 'UTF-8', 'ISO-8859-1');  // string
        $oPessoaEndereco->complemento = mb_convert_encoding($oOrigem->complemento, 'UTF-8', 'ISO-8859-1'); // string
        $oPessoaEndereco->bairro = mb_convert_encoding($oOrigem->bairro, 'UTF-8', 'ISO-8859-1');      // string
        $oPessoaEndereco->cidade = mb_convert_encoding($oOrigem->munic, 'UTF-8', 'ISO-8859-1');       // string
        $oPessoaEndereco->estado = mb_convert_encoding($oOrigem->uf, 'UTF-8', 'ISO-8859-1');          // string
        $oPessoaEndereco->pais = mb_convert_encoding($oOrigem->pais, 'UTF-8', 'ISO-8859-1');        // string
        $oPessoaEndereco->cep = mb_convert_encoding($oOrigem->cep, 'UTF-8', 'ISO-8859-1');         // string
        $oPessoa->endereco = $oPessoaEndereco;                              // tipoEndereco

        /**
         * DADOS BASICOS > POLO
         */

        // Objeto polo separado por AT (Polo Ativo) e PA (Polo Passivo)

        // AT (Polo Ativo)
        $oPoloAt = new TipoPoloProcessual();
        $oPoloAt->polo = 'AT';

        $oPoloParteAt = new TipoParte();

        $oPartePessoaAt = new TipoPessoa();
        $oPartePessoaAt->nome = mb_convert_encoding($oOrigem->nome_at, 'UTF-8', 'ISO-8859-1');
        $oPartePessoaAt->numeroDocumentoPrincipal = $oOrigem->cpf_at;
        $oPartePessoaAt->tipoPessoa = mb_convert_encoding($oOrigem->tipo_pessoa_at, 'UTF-8', 'ISO-8859-1');

        $oPessoaDocumentoAt = new TipoDocumentoIdentificacao();
        $oPessoaDocumentoAt->codigoDocumento = $oOrigem->cpf_at;
        $oPessoaDocumentoAt->emissorDocumento = 'SRFB';
        $oPessoaDocumentoAt->nome = mb_convert_encoding($oOrigem->nome_at, 'UTF-8', 'ISO-8859-1');
        $oPessoaDocumentoAt->tipoDocumento = '';

        $oPartePessoaAt->documento = $oPessoaDocumentoAt;

        $oPessoaEnderecoAt = new TipoEndereco();
        $oPessoaEnderecoAt->cep = $oOrigem->cep_at;
        $oPessoaEnderecoAt->logradouro = mb_convert_encoding($oOrigem->logradouro_at, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoAt->numero = $oOrigem->numero_end_at;
        $oPessoaEnderecoAt->bairro = mb_convert_encoding($oOrigem->bairro_at, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoAt->cidade = mb_convert_encoding($oOrigem->munic_at, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoAt->estado = mb_convert_encoding($oOrigem->uf_at, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoAt->pais = 'BR';

        $oPartePessoaAt->endereco = $oPessoaEnderecoAt;

        $oPoloParteAt->pessoa = $oPartePessoaAt;

        /*
        /**
         * @todo verificar o que fazer com os dados do advogado.
         */
        $oPessoaAdvogadoAt = new TipoRepresentanteProcessual();
        $oPessoaAdvogadoAt->intimacao = false;
        $oPessoaAdvogadoAt->nome = mb_convert_encoding(mb_strtoupper((string) $oOrigem->nome_advog), 'UTF-8', 'ISO-8859-1');
        $oPessoaAdvogadoAt->numeroDocumentoPrincipal = $oOrigem->matricula_advogado;
        $oPessoaAdvogadoAt->tipoRepresentante = 'A';
        $oPessoaAdvogadoAt->inscricao =$oOrigem->oab_advog;

        $oAdvogadoEnderecoAt = new TipoEndereco();
        $oAdvogadoEnderecoAt->cep = $oOrigem->cep_advog;
        $oAdvogadoEnderecoAt->logradouro = mb_convert_encoding($oOrigem->logradouro_advog, 'UTF-8', 'ISO-8859-1');
        $oAdvogadoEnderecoAt->numero = $oOrigem->numero_advog;
        $oAdvogadoEnderecoAt->bairro = mb_convert_encoding($oOrigem->bairro_advog, 'UTF-8', 'ISO-8859-1');
        $oAdvogadoEnderecoAt->cidade = mb_convert_encoding($oOrigem->cidade_advog, 'UTF-8', 'ISO-8859-1');
        $oAdvogadoEnderecoAt->estado = $oOrigem->uf_advog;
        $oAdvogadoEnderecoAt->pais = 'BR';

        $oPessoaAdvogadoAt->endereco = $oAdvogadoEnderecoAt;

        $oPoloParteAt->advogado = $oPessoaAdvogadoAt;

        $oPoloAt->parte = $oPoloParteAt;

        // PA (Polo Passivo)
        $oPoloPa = new tipoPoloProcessual();
        $oPoloPa->polo = 'PA';

        $oPoloPartePa = new TipoParte();

        $oPartePessoaPa = new TipoPessoa();
        $oPartePessoaPa->nome = mb_convert_encoding($oOrigem->nome, 'UTF-8', 'ISO-8859-1');
        $oPartePessoaPa->sexo = $oOrigem->sexo;
        $oPartePessoaPa->numeroDocumentoPrincipal = $oOrigem->cpf;
        $oPartePessoaPa->tipoPessoa = mb_convert_encoding($oOrigem->tipo_pessoa, 'UTF-8', 'ISO-8859-1');

        $oPessoaEnderecoPa = new TipoEndereco();
        $oPessoaEnderecoPa->cep = $oOrigem->cep;
        $oPessoaEnderecoPa->logradouro = mb_convert_encoding($oOrigem->logradouro, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoPa->numero = $oOrigem->numero_end;
        $oPessoaEnderecoPa->bairro = mb_convert_encoding($oOrigem->bairro, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoPa->cidade = mb_convert_encoding($oOrigem->munic, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoPa->estado = mb_convert_encoding($oOrigem->uf, 'UTF-8', 'ISO-8859-1');
        $oPessoaEnderecoPa->pais = 'BR';

        $oPartePessoaPa->endereco = $oPessoaEnderecoPa;

        $oPoloPartePa->pessoa = $oPartePessoaPa;

        $oPoloPa->parte = $oPoloPartePa;

        $aPolo = [$oPoloAt, $oPoloPa];

        $oDadosBasicos->polo = $aPolo;

        /**
         * DADOS BASICOS > ASSUNTO
         */

        $oDadosBasicos->assunto = $oAssunto;                                        // tipoAssuntoProcessual
        $oAssunto->assuntoLocal = $oAssuntoLocal;                               // tipoAssuntoLocal
        $oAssuntoLocal->assuntoLocalPai = mb_convert_encoding($oOrigem->assunto_local_pai, 'UTF-8', 'ISO-8859-1');
        $oAssuntoLocal->descricao = mb_convert_encoding($oOrigem->descricao, 'UTF-8', 'ISO-8859-1');
        $oAssuntoLocal->codigoPaiNacional = mb_convert_encoding($oOrigem->codigo_pai_nacional, 'UTF-8', 'ISO-8859-1');
        $oAssuntoLocal->codigoAssunto = mb_convert_encoding($oOrigem->codigo_assunto, 'UTF-8', 'ISO-8859-1');

        $oAssunto->codigoNacional = mb_convert_encoding($oOrigem->codigo_nacional, 'UTF-8', 'ISO-8859-1');
        $oAssunto->principal = 'true'; //utf8_encode($oOrigem->principal);

        /*
         */

        $oDadosBasicos->magistradoAtuante = mb_convert_encoding($oOrigem->magistrado_atuante, 'UTF-8', 'ISO-8859-1');
        $oDadosBasicos->processoVinculado = '';
        $oDadosBasicos->prioridade = '';
        $oDadosBasicos->outroParametro = $aOutroParametros;
        $oDadosBasicos->orgaoJulgador = '';
        $oDadosBasicos->valorCausa = $oOrigem->valor_causa;
        $oDadosBasicos->outrosnumeros = '';                                       // string
        $oDadosBasicos->intervencaoMP = false;                                    //utf8_encode($oOrigem->intervencao_mp); // boolean
        $oDadosBasicos->nivelSigilo = "0";      // int
        $oDadosBasicos->dataAjuizamento = '';  // string
        $oDadosBasicos->tamanhoProcesso = null;  //utf8_encode($oOrigem->tamanho_processo); // int
        $oDadosBasicos->competencia = ($oOrigem->competencia);       // int
        $oDadosBasicos->numero = '00000000000000000000';                   //utf8_encode($oOrigem->numero); // string
        $oDadosBasicos->codigoLocalidade = ($oOrigem->codigo_localidade); // string
        $oDadosBasicos->classeProcessual = ($oOrigem->classe_processual); // int


        $oEntregar->dadosBasicos = $oDadosBasicos;  // tipoCabecalhoProcesso

        /**
         * MANIFESTACAO PROCESSUAL > DOCUMENTO
         */

        /**
         * Converte Documento em Binário e Busca o tamanho do Documento
         */
        $documentoCda = Documento::getInicialPorProcessoEletronico($oOrigem->codigo_processo_eletronico);

        $docBin    = base64_decode($documentoCda->getConteudo());
        $hash = hash('sha256', $docBin);
        $descricao = $documentoCda->getNome();
        $mimetype = 'application/pdf';

        $aOutroParametroDocumento = '';

        $documentos = Documento::getPorProcessoEletronico($oOrigem->codigo_processo_eletronico);
        foreach ($documentos as  $i => $documento) {

          if ($documento->getTipo() == \ECidade\Tributario\Juridico\ProcessoEletronico\Documento::INICIAL) {
              continue;
          }
          $aDocumentosVinculados[] = self::montaDocumento($documento);
        }

        $oDocumento->outroParametro = $aOutroParametroDocumento; // array
        $oDocumento->any = ''; // <anyXML> ????
        $oDocumento->documentoVinculado = $aDocumentosVinculados; // tipoDocumento ( idDocumentoVinculado ???? )
        $oDocumento->movimento = ''; // int
        $oDocumento->conteudo = $docBin;
        $oDocumento->nivelSigilo = 0; // int
        $oDocumento->hash = $hash; // string
        $oDocumento->tipoDocumentoLocal = 14; // string
        $oDocumento->idDocumentoVinculado = ''; // string
        $oDocumento->tipoDocumento = 58; // string
        $oDocumento->descricao = $descricao; // string
        $oDocumento->idDocumento = ''; // string
        $oDocumento->mimetype = $mimetype; // string
        $oDocumento->dataHora = date('YmdHis'); // string

        $oEntregar->documento = $oDocumento; // tipoDocumento
        $oEntregar->dataEnvio = $oOrigem->data_envio;

        $aParametros = [['nome' => 'MOTIVO_GRERJ_AUSENTE', 'valor' => '9']];

        $oEntregar->parametros = $aParametros; // array
        $oRetorno = $this->removeVazio($oEntregar);

        return $oRetorno;
    }

    public static function montaDocumento(DocumentoModel $documento)
    {
        $docBin    = base64_decode($documento->getConteudo());
        $hash      = hash('sha256', $docBin);
        $descricao = $documento->getNome();
        $mimetype  = 'application/pdf';

        $oDocumento = new \stdClass();

        $oDocumento->any = ''; // <anyXML> ????
        $oDocumento->movimento = ''; // int
        $oDocumento->conteudo = $docBin;
        $oDocumento->nivelSigilo = 0; // int
        $oDocumento->hash = $hash; // string
        $oDocumento->tipoDocumentoLocal = 14; // string
        $oDocumento->idDocumentoVinculado = ''; // string
        $oDocumento->tipoDocumento = 58; // string
        $oDocumento->descricao = $descricao; // string
        $oDocumento->idDocumento = ''; // string
        $oDocumento->mimetype = $mimetype; // string
        $oDocumento->dataHora = date('YmdHis'); // string
        return $oDocumento;

    }

    public function removeVazio($dados)
    {

        $return = $dados;
        foreach ($dados as $key => $value) {
            if (empty($value) || is_null($value)) {

                if (!is_int($value)) {
                    if (is_object($dados)) {

                        unset($return->$key);
                    } elseif (is_array($dados)) {

                        unset($return[$key]);
                    }

                    continue;
                }

            } else {
                if (is_object($value) || is_array($value)) {

                    if (is_object($dados)) {

                        $arr = (array)$this->removeVazio($value);
                        if (empty($arr)) {
                            unset($return->$key);
                            continue;
                        }

                        $return->$key = $this->removeVazio($value);

                    } elseif (is_array($dados)) {

                        $return[$key] = $this->removeVazio($value);
                    }
                } else {

                    if (is_object($dados)) {

                        $return->$key = $value;

                    } elseif (is_array($dados)) {

                        $return[$key] = $value;
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Usuario para envio do processo
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

}
