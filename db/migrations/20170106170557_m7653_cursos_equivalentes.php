<?php

use Classes\PostgresMigration;

class M7653CursosEquivalentes extends PostgresMigration
{
    public function up()
    {
        $this->criarMenu();
        $this->criarDiscionario();
        $this->createTable();
    }

    public function criarMenu()
    {

        $aColumns = ['id_item', 'descricao', 'help', 'funcao', 'itemativo', 'manutencao', 'desctec', 'libcliente'];
        $aValues  = [[10387, 'Equivalência entre Cursos' ,'Equivalência entre Cursos' ,'edu1_cursoequivalente001.php' ,'1' ,'1' ,'Informa quais cursos são equivalentes ' ,'true' ]];
        $table    = $this->table('db_itensmenu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        $aColumns = ['id_item', 'id_item_filho', 'menusequencia', 'modulo'];
        $aValues  = [[1101209 ,10387 ,4 ,7159 ]];
        $table    = $this->table('db_menu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    public function criarDiscionario()
    {
        // tabela
        $aColumns = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues  = [[4023, 'cursoequivalencia', 'Cursos equivalentes', 'ed140', '2017-01-06', 'cursoequivalencia', 0, 'f', 'f', 'f', 'f' ]];
        $table    = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula modulo
        $aColumns = ['codmod', 'codarq' ];
        $aValues  = [[61, 4023]];
        $table    = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // campos
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues  = [
            [22323,'ed140_sequencial','int4','Código PK','0', 'Código',10,'f','f','f',1,'text','Código'],
            [22324,'ed140_cursoedu','int4','Curso referenciado ','0', 'Curso',10,'f','f','f',1,'text','Curso'],
            [22325,'ed140_cursoequivalente','int4','Curso que equivale ao curso referente','0', 'Curso equivalente',10,'f','f','f',1,'text','Curso equivalente'],
        ];
        $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues  = [[1000648, 'cursoequivalencia_ed140_sequencial_seq', 1, 1, 9223372036854775807, 1, 1]];
        $table    = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os campos as tabelas
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [4023, 22323, 1, 1000648],
            [4023, 22324, 2, 0],
            [4023, 22325, 3, 0],
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq','codcam','sequen','camiden'];
        $aValues  = [[4023,22323,1,22323]];
        $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues  = [
            [4023,22324,1,1010048,0],
            [4023,22325,1,1010048,0],
        ];
        $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues  = [
            [4414,'cursoequivalencia_cursoedu_in',4023,'0'],
            [4415,'cursoequivalencia_cursoequivalente_in',4023,'0'],
        ];
        $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues  = [
            [4414,22324,1],
            [4415,22325,1],
        ];
        $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    public function createTable()
    {
        $this->execute("CREATE SEQUENCE secretariadeeducacao.cursoequivalencia_ed140_sequencial_seq");
        $tabela = $this->table('cursoequivalencia',  ['schema'=>'secretariadeeducacao', 'id'=> false, 'primary_key'=>'ed140_sequencial', 'constraint'=>'cursoequivalencia_ed140_sequencial_pk']);
        $tabela->addColumn('ed140_sequencial', 'integer')
               ->addColumn('ed140_cursoedu', 'integer')
               ->addColumn('ed140_cursoequivalente', 'integer')
               ->addForeignKey('ed140_cursoedu', 'escola.cursoedu', 'ed29_i_codigo', ['constraint'=>'cursoequivalencia_ed140_cursoedu_fk'])
               ->addForeignKey('ed140_cursoequivalente', 'escola.cursoedu', 'ed29_i_codigo',  ['constraint'=>'cursoequivalencia_ed140_cursoequivalente_fk'])
               ->addIndex(['ed140_cursoedu'],         ['name' => 'cursoequivalencia_ed140_sequencial_seq_cursoedu_in'])
               ->addIndex(['ed140_cursoequivalente'], ['name' => 'cursoequivalencia_ed140_sequencial_seq_cursoequivalente_in'])
               ->create();
        $this->execute("ALTER TABLE secretariadeeducacao.cursoequivalencia ALTER COLUMN ed140_sequencial SET DEFAULT nextval('secretariadeeducacao.cursoequivalencia_ed140_sequencial_seq')");
    }

    public function down()
    {

        $this->execute('delete from configuracoes.db_menu      where id_item_filho = 10387 and modulo = 7159');
        $this->execute('delete from configuracoes.db_itensmenu where id_item = 10387');

        $this->execute('delete from configuracoes.db_syscadind  where codind in (4414, 4415) ');
        $this->execute('delete from configuracoes.db_sysindices where codind in (4414, 4415) ');
        $this->execute('delete from configuracoes.db_sysforkey where codarq in (4023) ');
        $this->execute('delete from configuracoes.db_sysprikey where codarq in (4023) ');
        $this->execute('delete from configuracoes.db_sysarqcamp where codarq in (4023) ');
        $this->execute('delete from configuracoes.db_syscampo   where codcam in (22323, 22324, 22325) ');
        $this->execute('delete from configuracoes.db_syssequencia where codsequencia = 1000648 ');
        $this->execute('delete from configuracoes.db_sysarqmod  where codarq = 4023');
        $this->execute('delete from configuracoes.db_sysarquivo where codarq = 4023');


        $this->execute('drop table if exists secretariadeeducacao.cursoequivalencia');
        $this->execute('drop sequence if exists secretariadeeducacao.cursoequivalencia_ed140_sequencial_seq');
    }
}
