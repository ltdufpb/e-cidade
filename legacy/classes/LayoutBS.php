<?php

class LayoutBS
{

    /*
        CABEÇALHO
    */
    public $cabec101 = null;
    public $cabec102 = null;
    public $cabec103 = null;
    public $cabec104 = null;
    public $cabec105 = null;
    public $cabec106 = null;
    public $cabec107 = null;
    public $cabec108 = null;
    public $cabec109 = null;
    public $cabec110 = null;
    public $cabec111 = null;
    public $cabec112 = null;
    public $cabec113 = null;
    public $cabec114 = null;
    public $cabec115 = null;
    public $cabec116 = null;
    public $cabec117 = null;
    public $cabec118 = null;
    public $cabec119 = null;
    public $cabec120 = null;
    public $cabec121 = null;
    public $cabec122 = null;
    public $cabec123 = null;
    public $cabec124 = null;
    public $cabec125 = null;
    public $cabec126 = null;
    public $cabec127 = null;

    public $cabec201 = null;
    public $cabec202 = null;
    public $cabec203 = null;
    public $cabec204 = null;
    public $cabec205 = null;
    public $cabec206 = null;
    public $cabec207 = null;
    public $cabec208 = null;
    public $cabec209 = null;
    public $cabec210 = null;
    public $cabec211 = null;
    public $cabec212 = null;
    public $cabec213 = null;
    public $cabec214 = null;
    public $cabec215 = null;
    public $cabec216 = null;
    public $cabec217 = null;
    public $cabec218 = null;
    public $cabec219 = null;
    public $cabec220 = null;
    public $cabec221 = null;
    public $cabec222 = null;
    public $cabec223 = null;
    public $cabec224 = null;
    public $cabec225 = null;
    public $cabec226 = null;
    public $cabec227 = null;

    /*
          FINAL CABEÇALHO
    */


    /*
            CORPO
    */
    public $detalhe01 = null;
    public $detalhe02 = null;
    public $detalhe03 = null;
    public $detalhe04 = null;
    public $detalhe05 = null;
    public $detalhe06 = null;
    public $detalhe07 = null;
    public $detalhe08 = null;
    public $detalhe09 = null;
    public $detalhe10 = null;
    public $detalhe11 = null;
    public $detalhe12 = null;
    public $detalhe13 = null;
    public $detalhe14 = null;
    public $detalhe15 = null;
    public $detalhe16 = null;
    public $detalhe17 = null;
    public $detalhe18 = null;
    public $detalhe19 = null;
    public $detalhe20 = null;
    public $detalhe21 = null;
    public $detalhe22 = null;
    public $detalhe23 = null;
    public $detalhe24 = null;
    public $detalhe25 = null;
    public $detalhe26 = null;
    public $detalhe27 = null;
    public $detalhe28 = null;
    public $detalhe29 = null;
    public $detalhe30 = null;


    /*
            TRAILLER
    */
    public $roda101 = null;
    public $roda102 = null;
    public $roda103 = null;
    public $roda104 = null;
    public $roda105 = null;
    public $roda106 = null;
    public $roda107 = null;
    public $roda108 = null;
    public $roda109 = null;
    public $roda110 = null;
    public $roda111 = null;
    public $roda112 = null;
    public $roda113 = null;
    public $roda114 = null;
    public $roda115 = null;

    public $roda201 = null;
    public $roda202 = null;
    public $roda203 = null;
    public $roda204 = null;
    public $roda205 = null;
    public $roda206 = null;
    public $roda207 = null;
    public $roda208 = null;
    public $roda209 = null;
    public $roda210 = null;
    public $roda211 = null;
    public $roda212 = null;
    public $roda213 = null;
    public $roda214 = null;
    public $roda215 = null;


    /*
      FINAL CORPO
    */


    public $arquivo = null;


    public $nomearq = '/tmp/modelo.txt';

    function gera_cabecalho()
    {
        $this->arquivo = fopen($this->nomearq, "w");
        fputs($this->arquivo,
            $this->cabec101
            . $this->cabec102
            . $this->cabec103
            . $this->cabec104
            . $this->cabec105
            . $this->cabec106
            . $this->cabec107
            . $this->cabec108
            . $this->cabec109
            . $this->cabec110
            . $this->cabec111
            . $this->cabec112
            . $this->cabec113
            . $this->cabec114
            . $this->cabec115
            . $this->cabec116
            . $this->cabec117
            . $this->cabec118
            . $this->cabec119
            . $this->cabec120
            . $this->cabec121
            . $this->cabec122
            . $this->cabec123
            . $this->cabec124
            . $this->cabec125
            . $this->cabec126
            . $this->cabec127
            . "\r\n"
        //.chr(13).chr(10) 

        );
    }

    function gera_cabecalho02()
    {
        //segundo cabeçalho
        fputs($this->arquivo,
            $this->cabec201
            . $this->cabec202
            . $this->cabec203
            . $this->cabec204
            . $this->cabec205
            . $this->cabec206
            . $this->cabec207
            . $this->cabec208
            . $this->cabec209
            . $this->cabec210
            . $this->cabec211
            . $this->cabec212
            . $this->cabec213
            . $this->cabec214
            . $this->cabec215
            . $this->cabec216
            . $this->cabec217
            . $this->cabec218
            . $this->cabec219
            . $this->cabec220
            . $this->cabec221
            . $this->cabec222
            . $this->cabec223
            . $this->cabec224
            . $this->cabec225
            . $this->cabec226
            . $this->cabec227
            . "\r\n"
        // .chr(13).chr(10) 

        );

        //fclose($fd1);  
    }

    function gera_corpo()
    {
        fputs($this->arquivo,
            $this->detalhe01
            . $this->detalhe02
            . $this->detalhe03
            . $this->detalhe04
            . $this->detalhe05
            . $this->detalhe06
            . $this->detalhe07
            . $this->detalhe08
            . $this->detalhe09
            . $this->detalhe10
            . $this->detalhe11
            . $this->detalhe12
            . $this->detalhe13
            . $this->detalhe14
            . $this->detalhe15
            . $this->detalhe16
            . $this->detalhe17
            . $this->detalhe18
            . $this->detalhe19
            . $this->detalhe20
            . $this->detalhe21
            . $this->detalhe22
            . $this->detalhe23
            . $this->detalhe24
            . $this->detalhe25
            . $this->detalhe26
            . $this->detalhe27
            . $this->detalhe28
            . $this->detalhe29
            . $this->detalhe30
            . "\r\n"
        //.chr(13).chr(10) 
        );
    }

    function gera_trailer1()
    {
        fputs($this->arquivo,
            $this->roda101
            . $this->roda102
            . $this->roda103
            . $this->roda104
            . $this->roda105
            . $this->roda106
            . $this->roda107
            . $this->roda108
            . $this->roda109
            . $this->roda110
            . $this->roda111
            . $this->roda112
            . $this->roda113
            . $this->roda114
            . $this->roda115
            //.chr(13).chr(10)
            . "\r\n"
        );
    }

    function gera_trailer2()
    {
        fputs($this->arquivo,
            $this->roda201
            . $this->roda202
            . $this->roda203
            . $this->roda204
            . $this->roda205
            . $this->roda206
            . $this->roda207
            . $this->roda208
            . $this->roda209
            . $this->roda210
            . $this->roda211
            . $this->roda212
            . $this->roda213
            . $this->roda214
            . $this->roda215
            //.chr(13).chr(10)
            . "\r\n"
        );
    }

    function gera()
    {
        fclose($this->arquivo);
    }


}
