<?php

use Classes\PostgresMigration;

class M9068MatriculaParcialTurnoIntegral extends PostgresMigration
{

    public function up()
    {
        $this->criarDicionario();
        $this->adicionarTabela();
    }

    public function down()
    {
        $this->removerTabela();
        $this->excluirDicionario();
    }

    private function criarDicionario() {

        // tabela
        $aColumns = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues  = [
            [1010210, 'periodoescolaturnoreferente', 'Vínculo entre os períodos da escola e seu turno referente.', 'ed143', '2017-07-21', 'Turno Referente do Período', 0, 'f', 'f', 'f', 'f'],
        ];
        $table    = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula modulo
        $aColumns = ['codmod', 'codarq' ];
        $aValues  = [
            [1008004,1010210],
        ];
        $table    = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // campos
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues  = [
            [1009354,'ed143_sequencial','int4','Sequencial da tabela.','0', 'Código',10,'f','f','f',1,'text','Código'],
            [1009355,'ed143_periodoescola','int4','Vínculo com o período da escola.','0', 'Período da Escola',10,'f','f','f',1,'text','Período da Escola'],
            [1009356,'ed143_turnoreferente','int4','Vínculo da referência do turno.','0', 'Referência do Turno',10,'f','f','f',1,'text','Referência do Turno'],
        ];
        $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os campos as tabelas
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [1010210,1009354,1,0],
            [1010210,1009355,2,0],
            [1010210,1009356,3,0],
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq','codcam','sequen','camiden'];
        $aValues  = [
            [1010210,1009354,1,1009354],
        ];
        $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues  = [
            [1010210,1009355,1,1010040,0],
            [1010210,1009356,1,2015,0],
        ];
        $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues  = [
            [1008207,'periodoescolaturnoreferente_periodoescola_in',1010210,'0'],
            [1008208,'periodoescolaturnoreferente_turnoreferente_in',1010210,'0'],
        ];
        $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues  = [
            [1008207,1009355,1],
            [1008208,1009356,1],
        ];
        $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues  = [
            [1000675, 'periodoescolaturnoreferente_ed143_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table    = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    private function adicionarTabela() {

        $this->execute("CREATE SEQUENCE escola.periodoescolaturnoreferente_ed143_sequencial_seq");
        $tabela = $this->table('periodoescolaturnoreferente',  ['schema'=>'escola', 'id'=> false, 'primary_key'=>'ed143_sequencial', 'constraint'=>'periodoescolaturnoreferente_ed143_sequencial_pk']);
        $tabela->addColumn('ed143_sequencial', 'integer')
               ->addColumn('ed143_periodoescola', 'integer')
               ->addForeignKey('ed143_periodoescola', 'escola.periodoescola', 'ed17_i_codigo', ['constraint'=>'periodoescolaturnoreferente_ed143_periodoescola_fk'])
               ->addIndex(['ed143_periodoescola'], ['name' => 'periodoescolaturnoreferente_periodoescola_in'])

               ->addColumn('ed143_turnoreferente', 'integer')
               ->addForeignKey('ed143_turnoreferente', 'escola.turnoreferente', 'ed231_i_codigo', ['constraint'=>'periodoescolaturnoreferente_ed143_turnoreferente_fk'])
               ->addIndex(['ed143_turnoreferente'], ['name' => 'periodoescolaturnoreferente_turnoreferente_in'])
               ->create();
        $this->execute("ALTER TABLE escola.periodoescolaturnoreferente ALTER COLUMN ed143_sequencial SET DEFAULT nextval('escola.periodoescolaturnoreferente_ed143_sequencial_seq')");
    }

    private function removerTabela() {

        $this->execute('drop table if exists escola.periodoescolaturnoreferente');
        $this->execute('drop sequence if exists escola.periodoescolaturnoreferente_ed143_sequencial_seq');
    }

    private function excluirDicionario() {

        $this->execute('delete from configuracoes.db_syscadind  where codind in (1008207, 1008208) ');
        $this->execute('delete from configuracoes.db_sysindices where codind in (1008207, 1008208) ');
        $this->execute('delete from configuracoes.db_sysforkey where codarq in (1010210) ');
        $this->execute('delete from configuracoes.db_sysprikey where codarq in (1010210) ');
        $this->execute('delete from configuracoes.db_sysarqcamp where codarq in (1010210) ');

        $this->execute('delete from configuracoes.db_syscampo   where codcam in (1009354, 1009355, 1009356) ');
        $this->execute('delete from configuracoes.db_syssequencia where codsequencia in (1000675) ');
        $this->execute('delete from configuracoes.db_sysarqmod  where codarq in(1010210)');
        $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010210)');
    }

}
