<?php

namespace ECidade\RecursosHumanos\ESocial\Integracao;

use ECidade\RecursosHumanos\ESocial\ESocialContextException;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;
use \ECidade\V3\Extension\Registry;
use \ECidade\Core\Config;
use DBHttpRequest;

/**
 * Classe responsável pelo envio dos dados do eSocial para a API do e-cidade
 */
class ESocial
{
    /**
     * Classe para requisição HTTP
     *
     * @var DBHttpRequest
     */
    private $httpRequest;

    /**
     * Dados a ser enviados
     *
     * @var array|\stdClass
     */
    private $dados;

    /**
     * @param string $recurso
     */
    public function __construct(/**
     * Configuração da aplicação
     */
    private readonly Config $config, /**
     * Recurso para envio dos dados
     */
    private $recurso)
    {
        $this->validaConfiguracao();

        $dadosAPI = $this->config->get('app.api');
        $httpRequest = new DBHttpRequest(Registry::get('app.config'));
        $httpRequest->addOptions([
            'baseUrl' => $dadosAPI['esocial']['url'] ,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
        $this->httpRequest = $httpRequest;

        $httpRequest->addOptions([
            'headers' => [
                'X-Access-Token' => $this->login()
            ]
        ]);
    }

    /**
     * Seta os dados a ser enviados
     *
     * @param \stdClass[] $dados
     */
    public function setDados($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Realiza a requisição enviando os dados para API
     *
     * @param string $method
     * @throws ESocialContextExceptionException
     * @return null|\stdClass
     */
    public function request($method = "POST")
    {
        $data = json_encode($this->dados);

        $this->httpRequest->send($this->recurso, $method, [
            'body' => $data
        ]);

        $result = json_decode($this->httpRequest->getBody());
        $code = $this->httpRequest->getResponseCode();

        if ($code >= 400) {
            $exception = new ESocialContextException($result->message, $code);
            $exception->setContext($result);
            throw $exception;
        }
        return $result;
    }

    /**
     * Retorna o código de resposta HTTP da requisição
     *
     * @return integer
     */
    public function getResponseCode()
    {
        return $this->httpRequest->getResponseCode();
    }

    /**
     * Valida se foi configurado o acesso a API.
     * @throws ESocialContextExceptionException
     * @return void
     */
    private function validaConfiguracao()
    {
        $dadosAPI = $this->config->get('app.api');
        if (empty($dadosAPI['esocial']['url']) ||
            empty($dadosAPI['esocial']['login']) ||
            empty($dadosAPI['esocial']['password'])) {
            throw new ESocialContextException("Entre em contato com o administrador do sistema para configurar acesso ao eSocial.");
        }
        return true;
    }

    /**
     * Efetua o login na API do eSocial
     *
     * @return string
     */
    private function login()
    {
        $dadosAPI = $this->config->get('app.api');
        unset($dadosAPI['esocial']['url']);

        try {
            $this->httpRequest->send('/auth/login', 'POST', [
                'body' => \json_encode((object) $dadosAPI['esocial'])
            ]);
        } catch (\Exception) {
            throw new ESocialContextException("Erro ao conectar na API do eSocial.");
        }

        $result = json_decode($this->httpRequest->getBody());
        $code = $this->httpRequest->getResponseCode();

        if (!isset($result->access_token)) {
            throw new ESocialContextException("Erro ao efetuar login na API.", $code);
        }

        return $result->access_token;
    }
}
