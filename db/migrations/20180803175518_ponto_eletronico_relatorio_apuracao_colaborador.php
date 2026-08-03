<?php

use Classes\PostgresMigration;

class PontoEletronicoRelatorioApuracaoColaborador extends PostgresMigration
{
    function up()
    {
        $this->upDDL();
        $this->upDicionarioDados();
    }

    function down()
    {
        $this->downDicionarioDados();
        $this->downDDL();
    }

    function upDDL()
    {
        $this->table('pontoeletronicoarquivodata', ['schema'=>'recursoshumanos'])
            ->addColumn('rh197_espelho_ponto_cache',   'text',    ['null'=> true, 'default'=>null])
            ->addColumn('rh197_cache_valido',          'boolean', ['default'=>false])
            ->save();
    }

    function upDicionarioDados()
    {
        $tabela_db_syscampo   = $this->table('db_syscampo',      ['schema'=>'configuracoes']);
        $tabela_db_sysarqcamp = $this->table('db_sysarqcamp',    ['schema'=>'configuracoes']);

        $tabela_db_syscampo->insert(['codcam','nomecam','conteudo','descricao','valorinicial','rotulo','tamanho','nulo','maiusculo','autocompl','aceitatipo','tipoobj','rotulorel'], [
            [1009859,'rh197_rh197_espelho_ponto_cache','text','Coluna que guarda cache do objeto espelho ponto com total de horas para manter histórico.','', 'Cache do espelho ponto',1,'t','f','f',1,'text','Cache do espelho ponto'],
            [1009860,'rh197_cache_valido','bool','Informa se o cache está ou não válido.','f', 'Cache válido',1,'f','f','f',5,'text','Cache válido'],
        ]);

        $tabela_db_sysarqcamp->insert(['codarq','codcam','seqarq','codsequencia'], [
            [4014, 1009859,18,0],
            [4014, 1009860,19,0],
        ]);
    }
    
    function downDicionarioDados()
    {
        $this->execute("DELETE FROM db_sysarqcamp   WHERE codcam IN (1009859)");
        $this->execute("DELETE FROM db_syscampo     WHERE codcam IN (1009860)");
    }

    function downDDL()
    {
        $this->table('pontoeletronicoarquivodata', ['schema'=>'recursoshumanos'])
            ->removeColumn('rh197_espelho_ponto_cache')
            ->removeColumn('rh197_cache_valido')
            ->save();
    }
}
