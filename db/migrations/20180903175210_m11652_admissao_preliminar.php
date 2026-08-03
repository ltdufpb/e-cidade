<?php

use Classes\PostgresMigration;

class M11652AdmissaoPreliminar extends PostgresMigration
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
            [1010314, 'avaliacaogruporespostaadmissaopreliminar', 'Guarda os dados de admissão preliminar do eSocial', 'eso18', '2018-09-03', 'avaliacaogruporespostaadmissaopreliminar', 0, 'f', 'f', 'f', 'f'],
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
            [81, 1010314]
        ];
        $table = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * Cria campos
         */
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues = [
            [1009936, 'eso18_sequencial', 'int4', 'Sequencial', '0', 'Sequencial', 10, 'f', 'f', 'f', 1, 'text', 'Sequencial'],
            [1009937, 'eso18_avaliacaogruporesposta', 'int4', 'Resposta', '0', 'Resposta', 10, 'f', 'f', 'f', 1, 'text', 'Resposta'],
            [1009938, 'eso18_cgm', 'int4', 'CGM', '0', 'CGM', 10, 'f', 'f', 'f', 1, 'text', 'CGM'],
            [1009939, 'eso18_cpf', 'varchar(11)', 'CPF', '', 'CPF', 11, 'f', 'f', 'f', 0, 'text', 'CPF']
        ];
        $table = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        /**
         * db_sysarqcamp
         */
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues = [
            [1010314, 1009936, 1, 0],
            [1010314, 1009937, 2, 0],
            [1010314, 1009938, 3, 0],
            [1010314, 1009939, 4, 0]

        ];
        $table = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues = [
            [1000763, 'avaliacaogruporespostaadmissaopreliminar_eso18_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq', 'codcam', 'sequen', 'camiden'];
        $aValues = [
            [1010314, 1009936, 1, 1009936],
        ];
        $table = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues = [
            [1010314, 1009937, 1, 2987, 0],
            [1010314, 1009938, 1, 42, 0]
        ];
        $table = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues = [
            [1008321, 'eso18_sequencial_eso03_avaliacaogruporesposta_in', 1010314, '0']
        ];
        $table = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues = [
            [1008321, 1009936, 1]
        ];
        $table = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        $this->execute("UPDATE db_sysarqcamp SET codsequencia = 1000763 WHERE codarq = 1010314 AND codcam = 1009936");
    }

    public function criarTabelas()
    {
        $sql = "
            -- Criando  sequences
            CREATE SEQUENCE avaliacaogruporespostaadmissaopreliminar_eso18_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
            
            -- TABELAS E ESTRUTURA
            
            -- Módulo: esocial
            CREATE TABLE avaliacaogruporespostaadmissaopreliminar(
            eso18_sequencial		int4 NOT NULL default 0,
            eso18_avaliacaogruporesposta		int4 NOT NULL default 0,
            eso18_cgm		int4 NOT NULL default 0,
            eso18_cpf		varchar(11) ,
            CONSTRAINT avaliacaogruporespostaadmissaopreliminar_sequ_pk PRIMARY KEY (eso18_sequencial));
            
            
            
            
            -- CHAVE ESTRANGEIRA
            
            
            ALTER TABLE avaliacaogruporespostaadmissaopreliminar
            ADD CONSTRAINT avaliacaogruporespostaadmissaopreliminar_avaliacaogruporesposta_fk FOREIGN KEY (eso18_avaliacaogruporesposta)
            REFERENCES avaliacaogruporesposta;
            
            ALTER TABLE avaliacaogruporespostaadmissaopreliminar
            ADD CONSTRAINT avaliacaogruporespostaadmissaopreliminar_cgm_fk FOREIGN KEY (eso18_cgm)
            REFERENCES cgm;
            
            
            
            
            -- INDICES
            
            
            CREATE  INDEX eso18_sequencial_eso03_avaliacaogruporesposta_in ON avaliacaogruporespostaadmissaopreliminar(eso18_sequencial);
        ";
        $this->execute($sql);
    }

    /**
     * Remove dados do dicionario de dados
     */
    private function removerDicionarioDados()
    {

        $this->execute('DELETE FROM configuracoes.db_syscampodef WHERE codcam IN(1009936, 1009937, 1009938, 1009939)');
        $this->execute('DELETE FROM configuracoes.db_syscadind WHERE codind IN(1008321)');
        $this->execute('DELETE FROM configuracoes.db_sysindices WHERE codind IN(1008321)');
        $this->execute('DELETE FROM configuracoes.db_sysforkey WHERE codcam IN(1009936, 1009937, 1009938, 1009939)');
        $this->execute('DELETE FROM configuracoes.db_syssequencia WHERE codsequencia IN(1000763)');
        $this->execute('DELETE FROM configuracoes.db_sysprikey WHERE codarq IN(1010314)');
        $this->execute('DELETE FROM configuracoes.db_sysarqcamp WHERE codcam IN(1009936, 1009937, 1009938, 1009939)');
        $this->execute('DELETE FROM configuracoes.db_syscampo WHERE codcam IN(1009936, 1009937, 1009938, 1009939)');
        $this->execute('DELETE FROM configuracoes.db_sysarqmod WHERE codarq IN(1010314)');
        $this->execute('DELETE FROM configuracoes.db_sysarquivo WHERE codarq IN(1010314)');
    }

    private function droparDML()
    {
        $sql = "
            --Criando drop sequences
            DROP SEQUENCE IF EXISTS avaliacaogruporespostaadmissaopreliminar_eso18_sequencial_seq;
            --DROP TABLE:
            DROP TABLE IF EXISTS avaliacaogruporespostaadmissaopreliminar CASCADE;
        ";
        $this->execute($sql);
    }

}
