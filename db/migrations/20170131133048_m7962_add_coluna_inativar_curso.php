<?php

use Classes\PostgresMigration;

class M7962AddColunaInativarCurso extends PostgresMigration
{
    public function up()
    {
        $this->dicionario();
        $this->ddl();
    }

    private function dicionario()
    {
        // campos
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues  = [
            [22347,'ed29_ativo','bool','Ativa/Inativa o curso','t', 'Situação',1,'f','f','f',5,'text','Situação']
        ];
        $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os campos as tabelas
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [1010048,22347,6,0]
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    public function ddl()
    {
        // altera tabela
        $this->table('cursoedu', ['schema'=>'escola'])
                ->addColumn('ed29_ativo', 'boolean', ['default' => true])
                ->save();
    }

    public function down()
    {
        $this->execute('delete from configuracoes.db_sysarqcamp where codcam in (22347)');
        $this->execute('delete from configuracoes.db_syscampo   where codcam in (22347)');

        $this->table('cursoedu', ['schema'=>'escola'])
             ->removeColumn('ed29_ativo')
             ->save();
    }
}
