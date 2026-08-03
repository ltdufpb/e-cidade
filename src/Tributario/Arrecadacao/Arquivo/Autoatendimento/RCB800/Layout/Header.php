<?php

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB800\Layout;

use \ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\Layout\Header as HeaderPattern;

final class Header extends HeaderPattern
{
    public function __construct()
    {
        parent::__construct();

        $fields = [
             'NUMEROREMESSA' => [
                 'name'          => 'NUMERO_REMESSA'
                ,'description'   => 'Iniciar com 1 a cada Ano da Remessa.  Vide Manual'
                ,'size'          => 5
            ]
            ,'INICIOVIGENCIA' => [
                 'name'          => 'INICIO_VIGENCIA'
                ,'description'   => 'Data início para disponibilizar os débitos para pagamento maior que data de envio.'
                ,'size'          => 8
            ]
            ,'FIMVIGENCIA' => [
                 'name'          => 'FIM_VIGENCIA'
                ,'description'   => 'Data final de disponibilização dos débitos para pagamento.'
                ,'size'          => 8
            ]
            ,'CODIGOCLIENTEBANCO' => [
                 'name'          => 'CODIGO_CLIENTE_BANCO'
                ,'description'   => 'Informar mesmo código do cliente do cadastro do Convênio. Definido pelo Banco.'
                ,'size'          => 9
                ,'default'       => '104953679' /* PM Paty de Alferes */
            ]
            ,'RESERVADO' => [
                 'name'          => 'RESERVADO'
                ,'description'   => 'Campo reservado para o futuro.'
                ,'size'          => 379
                ,'default'       => ' '
            ]
            ,'SEQUENCIAL' => [
                 'name'          => 'SEQUENCIAL'
                ,'description'   => 'Número sequencial do registro dentro do arquivo. Obrigatoriamente igual a 1.'
                ,'size'          => 9
                ,'default'       => 1
            ]
        ];

        $this->fields = array_merge($this->fields, $fields);
    }
}
