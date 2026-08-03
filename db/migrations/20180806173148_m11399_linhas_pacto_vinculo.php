<?php

use Classes\PostgresMigration;

class M11399LinhasPactoVinculo extends PostgresMigration
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
            [1010302, 'previsaodespesalinhaspacto', 'Vínculo de previsão de despesa com linhas de pacto', 'c41', '2018-08-06', 'previsaodespesalinhaspacto', 0, 'f', 'f', 'f', 'f'],
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
            [32, 1010302]
        ];
        $table = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * Cria campos
         */
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues = [
            [1009878, 'c41_sequencial', 'int4', 'Código', '0', 'Código', 10, 'f', 'f', 'f', 1, 'text', 'Código'],
            [1009879, 'c41_previsaodespesa', 'int4', 'Previsão despesa', '0', 'Previsão despesa', 10, 'f', 'f', 'f', 1, 'text', 'Previsão despesa'],
            [1009880, 'c41_linhaspacto', 'int4', 'LInhas pacto', '0', 'LInhas pacto', 10, 'f', 'f', 'f', 1, 'text', 'LInhas pacto']
        ];
        $table = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * db_sysarqcamp
         */
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues = [
            [1010302, 1009878, 1, 0],
            [1010302, 1009879, 2, 0],
            [1010302, 1009880, 3, 0]
        ];
        $table = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues = [
            [1000752, 'previsaodespesalinhaspacto_c41_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq', 'codcam', 'sequen', 'camiden'];
        $aValues = [
            [1010302, 1009878, 1, 1009878],
        ];
        $table = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues = [
            [1010302, 1009879, 1, 1010295, 0],
            [1010302, 1009880, 1, 1010299, 0]
        ];
        $table = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues = [
            [1008309, 'previsaodespesalinhaspacto_c41_sequencia_in', 1010302, '0']
        ];
        $table = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues = [
            [1008309, 1009878, 1],
        ];
        $table = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        $this->execute("UPDATE db_sysarqcamp SET codsequencia = 1000752 WHERE codarq = 1010302 AND codcam = 1009878");
    }

    public function criarTabelas()
    {
        $this->execute("
            CREATE SEQUENCE previsaodespesalinhaspacto_c41_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

            CREATE TABLE previsaodespesalinhaspacto(
            c41_sequencial		INT4 NOT NULL DEFAULT 0,
            c41_previsaodespesa		INT4 NOT NULL DEFAULT 0,
            c41_linhaspacto		INT4 DEFAULT 0,
            CONSTRAINT previsaodespesalinhaspacto_sequ_pk PRIMARY KEY (c41_sequencial));
            
            ALTER TABLE previsaodespesalinhaspacto
            ADD CONSTRAINT previsaodespesalinhaspacto_previsaodespesa_fk FOREIGN KEY (c41_previsaodespesa)
            REFERENCES previsaodespesa;
            
            ALTER TABLE previsaodespesalinhaspacto
            ADD CONSTRAINT previsaodespesalinhaspacto_linhaspacto_fk FOREIGN KEY (c41_linhaspacto)
            REFERENCES linhaspacto;
            
            CREATE  INDEX previsaodespesalinhaspacto_c41_sequencia_in ON previsaodespesalinhaspacto(c41_sequencial);
        ");
    }

    /**
     * Remove dados do dicionario de dados
     */
    private function removerDicionarioDados()
    {

        $this->execute('DELETE FROM configuracoes.db_syscampodef WHERE codcam IN(1009878, 1009879, 1009880)');
        $this->execute('DELETE FROM configuracoes.db_syscadind WHERE codind IN(1008309)');
        $this->execute('DELETE FROM configuracoes.db_sysindices WHERE codind IN(1008309)');
        $this->execute('DELETE FROM configuracoes.db_sysforkey WHERE codcam IN(1009878, 1009879, 1009880)');
        $this->execute('DELETE FROM configuracoes.db_syssequencia WHERE codsequencia IN(1000752)');
        $this->execute('DELETE FROM configuracoes.db_sysprikey WHERE codarq IN(1010302)');
        $this->execute('DELETE FROM configuracoes.db_sysarqcamp WHERE codcam IN(1009878, 1009879, 1009880)');
        $this->execute('DELETE FROM configuracoes.db_syscampo WHERE codcam IN(1009878, 1009879, 1009880)');
        $this->execute('DELETE FROM configuracoes.db_sysarqmod WHERE codarq IN(1010302)');
        $this->execute('DELETE FROM configuracoes.db_sysarquivo WHERE codarq IN(1010302)');
    }

    private function droparDML()
    {
        $this->execute("DROP TABLE IF EXISTS previsaodespesalinhaspacto");
        $this->execute("DROP SEQUENCE IF EXISTS previsaodespesalinhaspacto_c41_sequencial_seq");

    }

}
