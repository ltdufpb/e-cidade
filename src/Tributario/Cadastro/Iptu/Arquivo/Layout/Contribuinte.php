<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class Contribuinte extends Layout
{
    public function __construct()
    {
        $this->fields = [
            'NOME' => [
                 'name'        => 'NOME'
                ,'description' => 'NOME A SER IMPRESSO NO CARNE'
                ,'size'        => 40
            ]
            ,'PROMITENTE' => [
                 'name'        => 'PROMITENTE'
                ,'description' => 'PROMITENTE COMPRADOR POR CONTRATO'
                ,'size'        => 40
            ]
            ,'PROPRIETARIO' => [
                 'name'        => 'PROPRIETARIOESCRITURA'
                ,'description' => 'PROPRIETARIO DA ESCRITURA'
                ,'size'        => 40
            ]
            ,'PROPRIETARIOENDERECO' => [
                 'name'        => 'ENDNOME'
                ,'description' => 'ENDERECO DO CGM DO PROPRIETARIO'
                ,'size'        => 40
            ]
            ,'PROPRIETARIONUMERO' => [
                 'name'        => 'NUMIMONOME'
                ,'description' => 'NUMERO DO IMOVEL DO CGM DO PROPRIETARIO'
                ,'size'        => 10
            ]
            ,'PROPRIETARIOCOMPLEMENTO' => [
                 'name'        => 'COMPLIMONOME'
                ,'description' => 'COMPLEMENTO DO CGM DO PROPRIETARIO'
                ,'size'        => 20
            ]
            ,'PROPRIETARIOMUNICIPIO' => [
                 'name'        => 'MUNICNOME'
                ,'description' => 'MUNICIPIO DO CGM DO PROPRIETARIO'
                ,'size'        => 20
            ]
            ,'PROPRIETARIOCEP' => [
                 'name'        => 'CEPNOME'
                ,'description' => 'CEP DO CGM DO PROPRIETARIO'
                ,'size'        => 8
            ]
            ,'PROPRIETARIOUF' => [
                 'name'        => 'UFNOME'
                ,'description' => 'UF DO CGM DO PROPRIETARIO'
                ,'size'        => 2
            ]
            ,'PROPRIETARIOCNPJCPF' => [
                 'name'        => 'CNPJCPFNOME'
                ,'description' => 'CNPJ/CPF DO CGM DO PROPRIETARIO'
                ,'size'        => 20
            ]
            ,'IMOVELCODIGOLOGRADOURO' => [
                 'name'        => 'CODLOGIMO'
                ,'description' => 'CODIGO DO LOGRADOURO DO IMOVEL'
                ,'size'        => 6
            ]
            ,'IMOVELTIPOLOGRADOURO' => [
                 'name'        => 'TIPOLOGIMO'
                ,'description' => 'TIPO DO LOGRADOURO DO IMOVEL'
                ,'size'        => 20
            ]
            ,'IMOVELNOMELOGRADOURO' => [
                 'name'        => 'DESCRLOGIMO'
                ,'description' => 'NOME DO LOGRADOURO PRINCIPAL DO IMOVEL'
                ,'size'        => 50
            ]
            ,'IMOVELNUMERO' => [
                 'name'        => 'NUMIMOIMO'
                ,'description' => 'NUMERO DO IMOVEL'
                ,'size'        => 10
            ]
            ,'IMOVELCOMPLEMENTO' => [
                 'name'        => 'COMPLIMOIMO'
                ,'description' => 'COMPLEMENTO DO IMOVEL'
                ,'size'        => 20
            ]
            ,'IMOVELBAIRRO' => [
                 'name'        => 'BAIIMO'
                ,'description' => 'BAIRRO DO IMOVEL'
                ,'size'        => 40
            ]
            ,'ENTREGALOGRADOURO' => [
                 'name'        => 'LOGRADENDENT'
                ,'description' => 'DESCRICAO DO LOGRADOURO DO ENDERECO DE ENTREGA'
                ,'size'        => 50
            ]
            ,'ENTREGANUMERO' => [
                 'name'        => 'NUMIMOENDENT'
                ,'description' => 'NUMERO DO ENDERECO DE ENTREGA'
                ,'size'        => 10
            ]
            ,'ENTREGACOMPLEMENTO' => [
                 'name'        => 'COMPLENDENT'
                ,'description' => 'COMPLEMENTO DO ENDERECO DE ENTREGA'
                ,'size'        => 20
            ]
            ,'ENTREGABAIRRO' => [
                 'name'        => 'BAIENDENT'
                ,'description' => 'BAIRRO DO ENDERECO DE ENTREGA'
                ,'size'        => 40
            ]
            ,'ENTREGACIDADE' => [
                 'name'        => 'CIDENDENT'
                ,'description' => 'CIDADE DO ENDERECO DE ENTREGA'
                ,'size'        => 40
            ]
            ,'ENTREGAUF' => [
                 'name'        => 'UFENDENT'
                ,'description' => 'UF DO ENDERECO DE ENTREGA'
                ,'size'        => 2
            ]
            ,'ENTREGACEP' => [
                 'name'        => 'CEPENDENT'
                ,'description' => 'CEP DO ENDERECO DE ENTREGA'
                ,'size'        => 10
            ]
            ,'ENTREGACAIXAPOSTAL' => [
                 'name'        => 'CXPENDENT'
                ,'description' => 'CAIXA POSTAL DO ENDERECO DE ENTREGA'
                ,'size'        => 10
            ]
            ,'ENTREGADESTINATARIO' => [
                 'name'        => 'DESTENDENT'
                ,'description' => 'DESTINATARIO DO ENDERECO DE ENTREGA'
                ,'size'        => 40
            ]
        ];
    }
}
