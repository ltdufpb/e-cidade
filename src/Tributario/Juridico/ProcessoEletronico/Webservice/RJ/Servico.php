<?php
namespace ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ;


/**
 * Servico class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class Servico extends \SoapClient {

  private static $classmap = [

                                    'tipoParte' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoParte::class,
                                    'tipoPessoa' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoPessoa::class,
                                    'tipoDocumentoIdentificacao' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoDocumentoIdentificacao::class,
                                    'modalidadeDocumentoIdentificador' => 'modalidadeDocumentoIdentificador',
                                    'tipoEndereco' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\tipoEndereco::class,
                                    'tipoCabecalhoProcesso' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoCabecalhoProcesso::class,
                                    'tipoPoloProcessual' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoPoloProcessual::class,
                                    'tipoAssuntoProcessual' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoAssuntoProcessual::class,
                                    'tipoAssuntoLocal' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoAssuntoLocal::class,
                                    'tipoDocumento' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoDocumento::class,
                                    'tipoEntregarManifestacaoProcessual' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoEntregarManifestacaoProcessual::class,
                                    'tipoEntregarManifestacaoProcessualResposta' => \ECidade\Tributario\Juridico\ProcessoEletronico\Webservice\RJ\TipoEntregarManifestacaoProcessualResposta::class,

                                   ];

  public function __construct($wsdl = "http://wwwh1.tjrj.jus.br/HMNI/Servico.svc?wsdl", $options = ['trace' => 0,'features' => SOAP_SINGLE_ELEMENT_ARRAYS, 'encoding'=>'utf-8']) {
//  public function Servico($wsdl = "https://webserverseguro.tjrj.jus.br/MNI/Servico.svc?wsdl", $options = array('trace' => 1,'features' => SOAP_SINGLE_ELEMENT_ARRAYS, 'encoding'=>'utf-8')) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param tipoConsultarAvisosPendentes $consultarAvisosPendentes
   * @return tipoConsultarAvisosPendentesResposta
   */
  public function consultarAvisosPendentes(tipoConsultarAvisosPendentes $consultarAvisosPendentes) {
    return $this->__soapCall('consultarAvisosPendentes', [$consultarAvisosPendentes],       [
            //'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
            'soapaction' => ''
           ]
      );
  }

  /**
   *  
   *
   * @param tipoConsultarTeorComunicacao $consultarTeorComunicacao
   * @return tipoConsultarTeorComunicacaoResposta
   */
  public function consultarTeorComunicacao(tipoConsultarTeorComunicacao $consultarTeorComunicacao) {
    return $this->__soapCall('consultarTeorComunicacao', [$consultarTeorComunicacao],       [
            'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
            'soapaction' => ''
           ]
      );
  }

  /**
   *  
   *
   * @param tipoConsultarProcesso $consultarProcesso
   * @return tipoConsultarProcessoResposta
   */
  public function consultarProcesso(tipoConsultarProcesso $consultarProcesso) {
    return $this->__soapCall('consultarProcesso', [$consultarProcesso],       [
            'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
            'soapaction' => ''
           ]
      );
  }

  /**
   *  
   *
   * @param tipoEntregarManifestacaoProcessual $entregarManifestacaoProcessual
   * @return TipoEntregarManifestacaoProcessualResposta
   */
  public function entregarManifestacaoProcessual(TipoEntregarManifestacaoProcessual $entregarManifestacaoProcessual) {

      $res = $this->__getLastRequest();
      file_put_contents('tmp/envio.xml', $res);
      try {
          $retorno = $this->__soapCall('entregarManifestacaoProcessual', [$entregarManifestacaoProcessual], [
                'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
                'soapaction' => ''
          ]);

          $res = $this->__getLastRequest();
          file_put_contents('tmp/envio.xml', $res);
      } catch (\Exception $e) {
          $res = $this->__getLastRequest();
          file_put_contents('tmp/envio.xml', $res);
          throw $e;
      }
    return $retorno;

  }

  /**
   *  
   *
   * @param tipoConsultarAlteracao $consultarAlteracao
   * @return tipoConsultarAlteracaoResposta
   */
  public function consultarAlteracao(tipoConsultarAlteracao $consultarAlteracao) {
    return $this->__soapCall('consultarAlteracao', [$consultarAlteracao],       [
            'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
            'soapaction' => ''
           ]
      );
  }

  /**
   *  
   *
   * @param tipoConfirmarRecebimento $confirmarRecebimento
   * @return tipoConfirmarRecebimentoResposta
   */
  public function confirmarRecebimento(tipoConfirmarRecebimento $confirmarRecebimento) {
    return $this->__soapCall('confirmarRecebimento', [$confirmarRecebimento],       [
            'uri' => 'http://www.cnj.jus.br/servico-intercomunicacao-2.2.2/',
            'soapaction' => ''
           ]
      );
  }

}

?>
