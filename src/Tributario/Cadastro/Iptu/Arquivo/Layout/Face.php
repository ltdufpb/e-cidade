<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class Face extends Layout
{
    public function __construct()
    {
        $this->fields = [
             'OUTRASINFORMACOES' => [
                 'name'          => 'FACEOUTROS'
                ,'description'   => 'OUTRAS INFORMACOES DA FACE'
                ,'size'          => 40 
            ]
            ,'CODIGOCGM'         => [
                 'name'          => 'NUMCGMNOME'
                ,'description'   => 'CODIGO DO CGM DO NOME A SER IMPRESSO NO CARNE'
                ,'size'          => 10 
            ]
            ,'FRACAOLOTE'        => [
                 'name'          => 'FRACAODOLOTE'
                ,'description'   => 'FRACAO DO LOTE UTILIZADA NO CALCULO'
                ,'size'          => 10 
            ]
            ,'CEPIMOVEL'         => [
                 'name'          => 'CEPDOIMOVEL'
                ,'description'   => 'CEP DO IMOVEL'
                ,'size'          => 8 
            ]
            ,'MUNICIPIOIMOVEL'   => [
                 'name'          => 'MUNICDOIMOVEL'
                ,'description'   => 'MUNICIPIO DO IMOVEL'
                ,'size'          => 40 
            ]
            ,'UFIMOVEL'          => [
                 'name'          => 'UFDOIMOVEL'
                ,'description'   => 'UF DO IMOVEL'
                ,'size'          => 2 
            ]
            ,'MENSAGEMDEBITOSANOSANTERIORES' => [
                 'name'          => 'MSGDEBANOSANT'
                ,'description'   => 'MENSAGEM CASO A MATRICULA TENHA DEBITOS EM ANOS ANTERIORES'
                ,'size'          => 100 
            ]
            ,'NOMEBAIRRO'        => [
                 'name'          => 'BAIRRONOME'
                ,'description'   => 'BAIRRO DO CGM DO PROPRIETARIO'
                ,'size'          => 40 
            ]
            ,'CODIGOISENCAO'     => [
                 'name'          => 'CODISEN'
                ,'description'   => 'CODIGO DA ISENCAO'
                ,'size'          => 10 
            ]
            ,'CODIGOTIPOISENCAO' => [
                 'name'          => 'TIPOISEN'
                ,'description'   => 'CODIGO DO TIPO DE ISENCAO'
                ,'size'          => 5 
            ]
        ];
    }
}


