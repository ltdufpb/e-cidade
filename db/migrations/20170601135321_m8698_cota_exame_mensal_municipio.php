<?php

/**
*
*  Migration M8698CotaExameMensalMunicipio
*  da tabela grupomunicipio
*/

use Classes\PostgresMigration;

class M8698CotaExameMensalMunicipio extends PostgresMigration
{
    /**
     * Migrate Up
     *
     */
    public function up()
    {
      $this->criarMenu();
      $this->addDicionarioDados();
      $this->criarTabela();
    }
    /**
     * Migrate Down
     *
     */
    public function down()
    {
      $this->removeritensMenu();
      $this->removerDicionarioDados();
      $this->removerTabela();
    }

    /**
    *  Criar menu Cota de Exames Municípais
    */
    public function criarMenu()
    {


      $aColumns   =  ['id_item' ,'descricao' ,'help' ,'funcao' ,'itemativo' ,'manutencao' ,'desctec' ,'libcliente'];
      $aValues    =  [
          [10424 ,'Cota de Exames Municipais' ,'Cota de Exames a serem realizados pelo município' ,'age4_municipiocotamensalexame001.php' ,'1' ,'1' ,'Cota de Exames a serem realizados pelo município' ,'true']
      ];
      $table      = $this->table('db_itensmenu', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       * Vincular itensMenu ao pai db_menu
       */
      $aColumns   =    ['id_item', 'id_item_filho', 'menusequencia', 'modulo'];
      $aValues    =    [
          [32 ,10424 ,480 ,6952]
      ];
      $table      =  $this->table('db_menu', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *  Update tabela db_itensmenu
       */
      $this->execute("update db_itensmenu set id_item = 10424 , descricao = 'Cota de Exames Municípais' , help = 'Cota de Exames a serem realizados pelo município' , funcao = 'age4_municipiocotamensalexame001.php' , itemativo = '1' , manutencao = '1' , desctec = 'Cota de Exames a serem realizados pelo município' , libcliente = 'true' where id_item = 10424;");
    }

    public function addDicionarioDados()
    {
     /**
       *
       * Cria campos db_syscampo
       *
       */
      $aColumns  = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
      $aValues   = [
        [1009319,'age04_sequencial','int4','Código sequencial da tabela grupomunicipio','0', 'Código sequencial',10,'f','f','f',1,'text','Código sequencial'],
        [1009320,'age04_grupoexame','int4','Código sequencial da tabela grupoexame','0', 'Código do grupoexame',10,'f','f','f',1,'text','Código do grupoexame'],
        [1009321,'age04_procedimento','int4','Código procedimento da tabela sau_procedimento','0', 'Código procedimento',10,'f','f','f',1,'text','Código procedimento']
      ];
      $table     = $this->table('db_syscampo', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       * Update db_syscampo
       */
      $this->execute("update db_syscampo set nomecam = 'age01_quantidade', conteudo = 'int4', descricao = 'Campo de quantidade de exames', valorinicial = '0', rotulo = 'Quantidade', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Quantidade' where codcam = 1009269");

      /**
       * Campos db_sysarquivo
       */
      $aColumns  = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
      $aValues   = [
        [1010204, 'grupomunicipio', 'Cota de exame mensal por município', 'age04', '2017-06-01', 'Cota do Município', 0, 'f', 'f', 'f', 'f']
      ];
      $table     = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       * Campos db_sysarqmod
       */
      $aColumns  =  ['codmod', 'codarq'];
      $aValues   =  [
        [30,1010204]
        ];
      $table     =  $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *
       * Campos db_sysarqcamp
       *
       */
      $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
      $aValues  = [
        [1010204,1009319,1,0],
        [1010204,1009320,2,0],
        [1010204,1009321,3,0]
      ];
      $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *
       * Campos db_sysprikey
       *
       */
      $aColumns = ['codarq', 'codcam','sequen', 'camiden'];
      $aValues  = [
        [1010204,1009319,1,1009319]
      ];
      $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();


      /**
       *
       *  Campos  db_sysforkey
       *
       */
      $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
      $aValues  = [
      [1010204,1009320,1,1010204,0],
      [1010204,1009321,2,1010204,0],
      [1010204,1009321,1,1988,0],
      [1010204,1009320,1,1010195,0]
      ];
      $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *
       * Campos db_sysindices
       *
       */
      $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
      $aValues  = [
        [1008200,'grupomunicipio_sequencial_in',1010204,'1']
      ];
      $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *
       * Campos db_syscadind
       *
       */
        $aColumns   = ['codind', 'codcam', 'sequen'];
        $aValues    = [
          [1008200,1009318,1]
        ];
        $table      =  $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

      /**
       *
       * Campos db_syssequencia
       *
       */
      $aColumns   = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
      $aValues    = [
        [1000670, 'grupomunicipio_age04_sequencial_seq', 1, 1, 9223372036854775807, 1, 1]
      ];
      $table      =  $this->table('db_syssequencia', ['schema' => 'configuracoes']);
      $table->insert($aColumns, $aValues);
      $table->saveData();

      /**
       *  Update
       */
      $this->execute("update configuracoes.db_sysarqcamp set codsequencia = 1000670 where codarq = 1010204 and codcam = 1009319");
    }

    /**
     * Criar tabelas
     */
    public function criarTabela()
    {

      $this->execute("CREATE SEQUENCE agendamento.grupomunicipio_age04_sequencial_seq");
      $grupomunicipio = $this->table('grupomunicipio', ['schema' => 'agendamento', 'id' => false, 'primary_key' => 'age04_sequencial', 'constraint' => 'agendamento.age04_sequencial_pk']);
      $grupomunicipio->addColumn('age04_sequencial',   'integer',   ['null'      => false])
                     ->addColumn('age04_grupoexame',   'integer',   ['null'      => false])
                     ->addColumn('age04_procedimento', 'integer',   ['default'   => 0])
                     ->addForeignKey('age04_grupoexame', 'agendamento.grupoexame', 'age02_sequencial', ['constraint'=>'grupomunicipio_grupoexame_fk'])
                     ->addForeignKey('age04_procedimento', 'ambulatorial.sau_procedimento', 'sd63_i_codigo', ['constraint'=>'grupomunicipio_procedimento_fk'])
                     ->addIndex(['age04_sequencial'], ['name' => 'grupomunicipio_sequencial_in'])
                     ->create();

      $this->execute("ALTER TABLE agendamento.grupomunicipio ALTER COLUMN age04_sequencial SET DEFAULT nextval('agendamento.grupomunicipio_age04_sequencial_seq')");
    }

    /**
     *  Remover Itens Menu
     */
    public function removeritensMenu()
    {
      $this->execute("delete from configuracoes.db_itensmenu where id_item = 10424");
      $this->execute("delete from configuracoes.db_menu where id_item_filho = 10424 AND modulo = 6952;");
    }

   /**
   * Remove dados do dicionario de dados
   */
    public function removerDicionarioDados()
    {

      $this->execute("delete from configuracoes.db_sysarqcamp where codcam in (1009319,1009320,1009321)");
      $this->execute('delete from configuracoes.db_syscadind where codind in(1008200)');
      $this->execute('delete from configuracoes.db_sysindices where codind in(1008200)');
      $this->execute('delete from configuracoes.db_sysforkey where  codarq = 1010204 ');
      $this->execute('delete from configuracoes.db_syssequencia where codsequencia in(1000670)');
      $this->execute('delete from configuracoes.db_sysprikey where codarq in(1010204)');
      $this->execute('delete from configuracoes.db_sysarqmod where codarq in(1010204)');
      $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010204)');
      $this->execute("delete from configuracoes.db_syscampo where codcam in (1009319,1009320,1009321)");
    }

    /**
     * Remover tabela grupomunicipio
     */
    public function removerTabela()
    {

      $this->execute("DROP TABLE IF EXISTS grupomunicipio CASCADE;");
      $this->execute("DROP SEQUENCE IF EXISTS grupomunicipio_age04_sequencial_seq;");
    }
}
