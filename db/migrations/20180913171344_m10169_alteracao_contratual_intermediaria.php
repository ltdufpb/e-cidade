<?php

use Classes\PostgresMigration;

class M10169AlteracaoContratualIntermediaria extends PostgresMigration
{
  public function up()
  {
    $this->addDicionarioDados();
    $this->criarTabelas();
  }

  public function down() {

    $this->removerDicionarioDados();
    $this->droparDML();
  }

  public function addDicionarioDados()
  {
    /**
     * Cria tabelas
     */
    $aColumns = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
    $aValues  = [
      [1010315, 'avaliacaogruporespostaaltercontratual', 'Guarda os dos de alteração contratual', 'eso20', '2018-09-13', 'avaliacaogruporespostaaltercontratual', 0, 'f', 'f', 'f', 'f'],
    ];
    $table    = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // vincula modulo
    $aColumns = ['codmod', 'codarq' ];
    $aValues  = [
      /**
      *lista de campos
      */
      [81,1010315]
    ];
    $table    = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    /**
     * Cria campos
     */
    $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
    $aValues  = [
        [1009941,'eso20_sequencial','int4','Sequencial','0', 'Sequencial',15,'f','f','f',1,'text','Sequencial'],
        [1009942,'eso20_avaliacaogruporesposta','int4','Resposta','0', 'Resposta',15,'f','f','f',1,'text','Resposta'],
        [1009943,'eso20_cgm','int4','CGM','0', 'CGM',15,'f','f','f',1,'text','CGM'],
        [1009944,'eso20_rhpessoal','int4','Pessoal','0', 'Pessoal',15,'f','f','f',1,'text','Pessoal']
    ];
    $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    /**
     * db_sysarqcamp
     */
    $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
    $aValues  = [
        [1010315,1009941,1,0],
        [1010315,1009942,2,0],
        [1010315,1009943,3,0],
        [1010315,1009944,4,0],
    ];
    $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();


    // inclui a sequence
    $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
    $aValues  = [
      [1000764, 'avaliacaogruporespostaaltercontratual_eso20_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
    ];
    $table    = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui a chave primaria
    $aColumns = ['codarq','codcam','sequen','camiden'];
    $aValues  = [
      [1010315,1009941,1,1009944],
    ];
    $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui a chave estrangeira
    $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
    $aValues  = [
      [1010315,1009943,1,42,0],
      [1010315,1009944,1,1153,0],
      [1010315,1009942,1,2987,0],
    ];
    $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui os indices
    $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
    $aValues  = [
      [1008323,'avaliacaogruporespostaaltercontratual_eso20_sequencial_in',1010315,'0'],
    ];
    $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // vincula os indices
    $aColumns = ['codind', 'codcam', 'sequen'];
    $aValues  = [
      [1008323,1009941,1],
    ];
    $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    $this->execute("update db_sysarqcamp set codsequencia = 1000764 where codarq = 1010315 and codcam = 1009941");
  }

  public function criarTabelas() {
      $sql = "
        CREATE SEQUENCE avaliacaogruporespostaaltercontratual_eso20_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        CREATE TABLE avaliacaogruporespostaaltercontratual(
        eso20_sequencial		int4 default 0,
        eso20_avaliacaogruporesposta		int4 NOT NULL default 0,
        eso20_cgm		int4 NOT NULL default 0,
        eso20_rhpessoal		int4 NOT NULL default 0,
        CONSTRAINT avaliacaogruporespostaaltercontratual_sequ_pk PRIMARY KEY (eso20_sequencial));

        ALTER TABLE avaliacaogruporespostaaltercontratual
        ADD CONSTRAINT avaliacaogruporespostaaltercontratual_cgm_fk FOREIGN KEY (eso20_cgm)
        REFERENCES cgm;
        
        ALTER TABLE avaliacaogruporespostaaltercontratual
        ADD CONSTRAINT avaliacaogruporespostaaltercontratual_rhpessoal_fk FOREIGN KEY (eso20_rhpessoal)
        REFERENCES rhpessoal;
        
        ALTER TABLE avaliacaogruporespostaaltercontratual
        ADD CONSTRAINT avaliacaogruporespostaaltercontratual_avaliacaogruporesposta_fk FOREIGN KEY (eso20_avaliacaogruporesposta)
        REFERENCES avaliacaogruporesposta;

        CREATE  INDEX avaliacaogruporespostaaltercontratual_eso20_sequencial_in ON avaliacaogruporespostaaltercontratual(eso20_sequencial);
      ";
      $this->execute($sql);
  }

  /**
   * Remove dados do dicionario de dados
   */
  private function removerDicionarioDados()
  {
    $this->execute('delete from configuracoes.db_syscampodef where codcam in(1009941, 1009942, 1009943, 1009944)');
    $this->execute('delete from configuracoes.db_syscadind where codind in(1008323)');
    $this->execute('delete from configuracoes.db_sysindices where codind in(1008323)');
    $this->execute('delete from configuracoes.db_sysforkey where codcam in(1009941, 1009942, 1009943, 1009944)');
    $this->execute('delete from configuracoes.db_syssequencia where codsequencia in(1000764)');
    $this->execute('delete from configuracoes.db_sysprikey where codarq in(1010315)');
    $this->execute('delete from configuracoes.db_sysarqcamp where codcam in(1009941, 1009942, 1009943, 1009944)');
    $this->execute('delete from configuracoes.db_syscampo where codcam in(1009941, 1009942, 1009943, 1009944)');
    $this->execute('delete from configuracoes.db_sysarqmod where codarq in(1010315)');
    $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010315)');
  }

  private function droparDML() {
    $this->execute('drop table if exists avaliacaogruporespostaaltercontratual');
    $this->execute('drop sequence if exists avaliacaogruporespostaaltercontratual_eso20_sequencial_seq');

  }

}
