<?php

use Classes\PostgresMigration;

class M9993StatusGerenciadorTarefas extends PostgresMigration
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
      [1010252, 'esocialenviostatus', 'Tabela que guarda o status dos envios para a API do eSocial', 'rh214', '2018-01-08', 'eSocial Envio Status', 0, 'f', 'f', 'f', 'f' ],
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
      [81,1010252]
    ];
    $table    = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    /**
     * Cria campos
     */
    $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
    $aValues  = [
        [1009598,'rh214_sequencial','int4','Sequencial','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
        [1009599,'rh214_esocialenvio','int4','Envio eSocial','0', 'Envio eSocial',10,'f','f','f',1,'text','Envio eSocial'],
        [1009600,'rh214_data','date','Data','0', 'Data',10,'f','f','f',0,'text','Data'],
        [1009602,'rh214_descricao','varchar(200)','Descrição','0', 'Descrição',200,'f','f','f',0,'text','Descrição'],
        [1009603,'rh214_situacao','bool','Situação','f', 'Situação',1,'f','f','f',5,'text','Situação']
    ];
    $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    /**
     * db_sysarqcamp
     */
    $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
    $aValues  = [
        [1010252,1009598,1,0],
        [1010252,1009599,2,0],
        [1010252,1009600,3,0],
        [1010252,1009602,5,0],
        [1010252,1009603,6,0]
    ];
    $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();


    // inclui a sequence
    $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
    $aValues  = [
      [1000712, 'esocialenviostatus_rh214_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
    ];
    $table    = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui a chave primaria
    $aColumns = ['codarq','codcam','sequen','camiden'];
    $aValues  = [
      [1010252,1009598,1,1009598],
    ];
    $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui a chave estrangeira
    $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
    $aValues  = [
      [1010252,1009599,1,1010244,0],
    ];
    $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // inclui os indices
    $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
    $aValues  = [
      [1008247,'esocialenviostatus_sequencial_in',1010252,'0'],
      [1008248,'esocialenviostatus_esocialenvio_in',1010252,'0'],

    ];
    $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // vincula os indices
    $aColumns = ['codind', 'codcam', 'sequen'];
    $aValues  = [
      [1008247,1009598,1],
      [1008248,1009599,1]
    ];
    $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    $this->execute("update db_sysarqcamp set codsequencia = 1000712 where codarq = 1010252 and codcam = 1009598;");
  }

  public function criarTabelas() {


    $sSql = "        
        -- Criando  sequences
        CREATE SEQUENCE esocialenviostatus_rh214_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        -- TABELAS E ESTRUTURA
        
        -- Módulo: esocial
        CREATE TABLE esocialenviostatus(
        rh214_sequencial		int4 NOT NULL default 0,
        rh214_esocialenvio		int4 NOT NULL default 0,
        rh214_data		timestamp NOT NULL default NOW(),
        rh214_descricao		varchar(200) NOT NULL ,
        rh214_situacao		bool default 'f',
        CONSTRAINT esocialenviostatus_sequ_pk PRIMARY KEY (rh214_sequencial));
        
        -- CHAVE ESTRANGEIRA
        
        ALTER TABLE esocialenviostatus
        ADD CONSTRAINT esocialenviostatus_esocialenvio_fk FOREIGN KEY (rh214_esocialenvio)
        REFERENCES esocialenvio;

        -- INDICES
        CREATE  INDEX esocialenviostatus_sequencial_in ON esocialenviostatus(rh214_sequencial);
        CREATE  INDEX esocialenviostatus_esocialenvio_in ON esocialenviostatus(rh214_esocialenvio);
    ";

    $this->execute($sSql);
  }

  /**
   * Remove dados do dicionario de dados
   */
  private function removerDicionarioDados()
  {

    $this->execute('delete from configuracoes.db_syscampodef where codcam in(1009598, 1009599, 1009600, 1009602, 1009603)');
    $this->execute('delete from configuracoes.db_syscadind where codind in(1008247, 1008248)');
    $this->execute('delete from configuracoes.db_sysindices where codind in(1008247, 1008248)');
    $this->execute('delete from configuracoes.db_sysforkey where codcam in(1009598, 1009599, 1009600, 1009602, 1009603)');
    $this->execute('delete from configuracoes.db_syssequencia where codsequencia in(1000712)');
    $this->execute('delete from configuracoes.db_sysprikey where codarq in(1010252)');
    $this->execute('delete from configuracoes.db_sysarqcamp where codcam in(1009598, 1009599, 1009600, 1009602, 1009603)');
    $this->execute('delete from configuracoes.db_syscampo where codcam in(1009598, 1009599, 1009600, 1009602, 1009603)');
    $this->execute('delete from configuracoes.db_sysarqmod where codarq in(1010252)');
    $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010252)');
  }

  private function droparDML() {

    $this->execute("
        --DROP TABLE:
        DROP TABLE IF EXISTS esocialenviostatus CASCADE;
        
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS esocialenviostatus_rh214_sequencial_seq;
    ");

  }

}
