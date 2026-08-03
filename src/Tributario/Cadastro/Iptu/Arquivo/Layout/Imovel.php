<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

final class Imovel extends Layout
{
    public function __construct ()
    {
        $this->fields = [
            'TIPOIMOVELCODIGO' => [
                'name'         => 'ESPECIE'
                ,'description' => 'CODIGO DO TIPO DO IMOVEL - 1 = TERRITORIAL E 2 = PREDIAL'
                ,'size'        => 1
            ]
            ,'TIPOIMOVELDESCRICAO' => [
                'name'         => 'TIPOIMOVEL'
                ,'description' => 'EXPRESSAO DO TIPO DO IMOVEL - TERRITORIAL OU PREDIAL'
                ,'size'        => 11
            ]
            ,'MATRICULA' => [
                'name'         => 'MATRICULA'
                ,'description' => 'MATRICULA'
                ,'size'        => 10
            ]
            ,'EXERCICIO' => [
                'name'         => 'EXERCICIO'
                ,'description' => 'EXERCÍCIO DO CALCULO'
                ,'size'        => 4
            ]
            ,'NOTIFICACAO' => [
                'name'         => 'NOTIFICACAO'
                ,'description' => 'NOTIFICACAO'
                ,'size'        => 10
            ]
            ,'ZONAENTREGA' => [
                'name'         => 'ZONAENTREGA'
                ,'description' => 'ZONA DE ENTREGA'
                ,'size'        => 5
            ]
            ,'ZONAFISCALLOTE' => [
                'name'         => 'ZONAFISCALLOTE'
                ,'description' => 'ZONA FISCAL DA TABELA LOTE'
                ,'size'        => 5
            ]
            ,'SETORFISCAL' => [
                'name'         => 'SETORFISCAL'
                ,'description' => 'SETOR FISCAL'
                ,'size'        => 5
            ]
            ,'SETORCARTOGRAFICA' => [
                'name'         => 'SETORCARTO'
                ,'description' => 'SETOR CARTOGRAFICO (DO SETOR/QUADRA/LOTE)'
                ,'size'        => 4
            ]
            ,'QUADRACARTOGRAFICA' => [
                'name'         => 'QUADRACARTO'
                ,'description' => 'QUADRA CARTOGRAFICA'
                ,'size'        => 4
            ]
            ,'LOTECARTOGRAFICA' => [
                'name'         => 'LOTECARTO'
                ,'description' => 'LOTE CARTOGRAFICA'
                ,'size'        => 4
            ]
            ,'SUBLOTE' => [
                'name'         => 'SUBLOTELOC'
                ,'description' => 'SUBLOTE'
                ,'size'        => 4
            ]
        ];
    }
}
