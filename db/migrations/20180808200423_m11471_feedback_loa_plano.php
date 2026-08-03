<?php

use Classes\PostgresMigration;

class M11471FeedbackLoaPlano extends PostgresMigration
{
    public function up()
    {
        $this->addDicionarioDados();
        $this->criarTabelas();
    }

    public function down()
    {
        $this->removerDicionarioDados();
        $this->droparDML();
    }

    public function addDicionarioDados()
    {
        /**
         * Cria tabelas
         */
        $aColumns = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues = [
            [1010303, 'previsaodespesaplano', 'Tabela que armazena os registros de planos orçamentários da despesa.', 'c55', '2018-08-08', 'previsaodespesaplano', 0, 'f', 'f', 'f', 'f'],
        ];
        $table = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula modulo
        $aColumns = ['codmod', 'codarq'];
        $aValues = [
            /**
             *lista de campos
             */
            [32, 1010303]
        ];
        $table = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * Cria campos
         */
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues = [
            [1009881, 'c55_sequencial', 'int4', 'Sequencial', '0', 'Sequencial', 10, 'f', 'f', 'f', 1, 'text', 'Sequencial'],
            [1009882, 'c55_previsaodespesa', 'int4', 'Previsão despesa', '0', 'Previsão despesa', 10, 'f', 'f', 'f', 1, 'text', 'Previsão despesa'],
            [1009883, 'c55_titulo', 'varchar(100)', 'Título', '', 'Título', 100, 'f', 'f', 'f', 0, 'text', 'Título'],
            [1009884, 'c55_valor', 'float8', 'Valor', '0', 'Valor', 15, 'f', 'f', 'f', 4, 'text', 'Valor']
        ];
        $table = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * db_sysarqcamp
         */
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues = [
            [1010303, 1009881, 1, 0],
            [1010303, 1009882, 2, 0],
            [1010303, 1009883, 3, 0],
            [1010303, 1009884, 4, 0]

        ];
        $table = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues = [
            [1000753, 'previsaodespesaplano_c55_sequencial_seq', 1, 1, 9223372036854775807, 1, 1]
        ];
        $table = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq', 'codcam', 'sequen', 'camiden'];
        $aValues = [
            [1010303, 1009881, 1, 1009881],
        ];
        $table = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues = [
            [1010303, 1009882, 1, 1010295, 0]
        ];
        $table = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues = [
            [1008311, 'previsaodespesaplano_c55_sequencial_in', 1010303, '0'],

        ];
        $table = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues = [
            [1008311, 1009881, 1],
        ];
        $table = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        $this->execute("UPDATE db_sysarqcamp SET codsequencia = 1000753 WHERE codarq = 1010303 AND codcam = 1009881");
    }

    public function criarTabelas()
    {
        $sql = "
            CREATE SEQUENCE previsaodespesaplano_c55_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
            CREATE TABLE previsaodespesaplano(
            c55_sequencial		int4 NOT NULL default 0,
            c55_previsaodespesa		int4 NOT NULL default 0,
            c55_titulo		varchar(100) NOT NULL ,
            c55_valor		float8 default 0,
            CONSTRAINT previsaodespesaplano_sequ_pk PRIMARY KEY (c55_sequencial));
            
            ALTER TABLE previsaodespesaplano
            ADD CONSTRAINT previsaodespesaplano_previsaodespesa_fk FOREIGN KEY (c55_previsaodespesa)
            REFERENCES previsaodespesa;

            CREATE  INDEX previsaodespesaplano_c55_sequencial_in ON previsaodespesaplano(c55_sequencial);
        ";
        $this->execute($sql);
    }

    /**
     * Remove dados do dicionario de dados
     */
    private function removerDicionarioDados()
    {
        $this->execute('DELETE FROM configuracoes.db_syscampodef WHERE codcam IN(1009881, 1009882, 1009883, 1009884)');
        $this->execute('DELETE FROM configuracoes.db_syscadind WHERE codind IN(1008311)');
        $this->execute('DELETE FROM configuracoes.db_sysindices WHERE codind IN(1008311)');
        $this->execute('DELETE FROM configuracoes.db_sysforkey WHERE codcam IN(1009881, 1009882, 1009883, 1009884)');
        $this->execute('DELETE FROM configuracoes.db_syssequencia WHERE codsequencia IN(1000753)');
        $this->execute('DELETE FROM configuracoes.db_sysprikey WHERE codarq IN(1010303)');
        $this->execute('DELETE FROM configuracoes.db_sysarqcamp WHERE codcam IN(1009881, 1009882, 1009883, 1009884)');
        $this->execute('DELETE FROM configuracoes.db_syscampo WHERE codcam IN(1009881, 1009882, 1009883, 1009884)');
        $this->execute('DELETE FROM configuracoes.db_sysarqmod WHERE codarq IN(1010303)');
        $this->execute('DELETE FROM configuracoes.db_sysarquivo WHERE codarq IN(1010303)');
    }

    private function droparDML()
    {
        $sql = "
            DROP SEQUENCE IF EXISTS previsaodespesaplano_c55_sequencial_seq;
            DROP TABLE IF EXISTS previsaodespesaplano CASCADE;
        ";
        $this->execute($sql);

    }

}
