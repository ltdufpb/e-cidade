<?php

use Classes\PostgresMigration;

class M9506MultasTransito extends PostgresMigration
{
    public function up()
    {
        $this->criarMenu();
        $this->addDicionarioDados();
        $this->criarTabela();
    }

    public function down()
    {
        $this->removerDicionarioDados();
        $this->removerTabela();
    }

    private function criarMenu()
    {
       $this->execute("update db_itensmenu set descricao = 'Infração de Trânsito', help = 'Infração de Trânsito', libcliente='true' where id_item = 10455");
       $this->execute("update db_itensmenu set descricao = 'Consolidado por Nível', help = 'Consolidado por Nível', funcao = 'inf2_arrecmultastransito001.php' , libcliente='true' where id_item = 10456");
       $this->execute("update db_itensmenu set descricao = 'Pagamentos Duplicados', help = 'Pagamentos Duplicados', funcao = 'inf2_pagamentoduplicidade001.php', libcliente='true' where id_item = 10457");
    }

    private function addDicionarioDados()
    {
        // Cadastro de Tabelas
        $aColumns  = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues   = [
            [1010228, 'arquivoinfracaomulta', 'Guarda as multas do arquivo de infração importado.', 'i08', '2017-09-26', 'Multas', 0, 'f', 'f', 'f', 'f' ],
        ];
        $table     = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Vínculo da tabela com o módulo
        $aColumns  =  ['codmod', 'codarq'];
        $aValues   =  [
            [5,1010228],
        ];
        $table     =  $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro de campos
        $aColumns  = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues   = [
            [1009452,'i08_sequencial','int4','Código sequencial da tabela.','0', 'Código',10,'f','f','f',1,'text','Código'],
            [1009453,'i08_arquivoinfracao','int4','Vínculo das multas com o arquivo de infração importado.','0', 'Arquivo de Infração',10,'f','f','f',1,'text','Arquivo de Infração'],
            [1009454,'i08_dtpagamento','date','Data de pagamento da multa.','null', 'Data de Pagamento',10,'f','f','f',1,'text','Data de Pagamento'],
            [1009455,'i08_dtrepasse','date','Data do repasse da multa.','null', 'Data de Repasse',10,'f','f','f',1,'text','Data de Repasse'],
            [1009456,'i08_nivel','int4','Nível da multa.','0', 'Nível',10,'f','f','f',1,'text','Nível'],
            [1009457,'i08_vlfunset','float4','Valor de repasse para a FUNSET.','0', 'Valor FUNSET',10,'t','f','f',4,'text','Valor FUNSET'],
            [1009458,'i08_vldetran','float4','Valor de repasse para o DETRAN.','0', 'Valor DETRAN',10,'t','f','f',4,'text','Valor DETRAN'],
            [1009459,'i08_vlprefeitura','float4','Valor de repasse para a Prefeitura.','0', 'Valor Prefeitura',10,'f','f','f',4,'text','Valor Prefeitura'],
            [1009460,'i08_vlbruto','float4','Valor bruto da multa.','0', 'Valor Bruto',10,'f','f','f',4,'text','Valor Bruto'],
            [1009461,'i08_codigoinfracao','varchar(10)','Código da infração.', '0', 'Código da Infração',10,'f','t','f',0,'text','Código da Infração'],
            [1009462,'i08_nossonumero', 'varchar(11)','Identificação do Titulo no banco(Nosso Número).','', 'Nosso Número', 11,'f','t','f',0,'text','Nosso Número'],
            [1009463,'i08_autoinfracao','varchar(13)','Código do auto de infração.','', 'Auto de Infração',13,'f','t','f',0,'text','Auto de Infração'],
            [1009464,'i08_duplicado','bool','Mostra se é um pagamento de multa duplicado.','f', 'Duplicado',1,'f','f','f',5,'text','Duplicado'],
        ];
        $table     = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Vínculo dos campos com a tabela
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [1010228,1009452,1,0],
            [1010228,1009453,2,0],
            [1010228,1009454,3,0],
            [1010228,1009455,4,0],
            [1010228,1009456,5,0],
            [1010228,1009457,6,0],
            [1010228,1009458,7,0],
            [1010228,1009459,8,0],
            [1010228,1009460,9,0],
            [1010228,1009461,10,0],
            [1010228,1009462,11,0],
            [1010228,1009463,12,0],
            [1010228,1009464,13,0],
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro da PK
        $aColumns = ['codarq', 'codcam','sequen', 'camiden'];
        $aValues  = [
          [1010228,1009452,1,1009452],
        ];
        $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro da FK
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues  = [
            [1010228,1009453,1,1010226,0],
        ];
        $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues  = [
            [1008225,'arquivoinfracaomulta_arquivoinfracao_in',1010228,'0'],
        ];
        $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues  = [
            [1008225,1009453,1],
        ];
        $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro de sequências
        $aColumns   = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues    = [
          [1000692, 'arquivoinfracaomulta_i08_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table      =  $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
        $this->execute("update db_sysarqcamp set codsequencia = 1000692 where codarq = 1010228 and codcam = 1009452");
    }

    private function criarTabela()
    {

        $this->execute("CREATE SEQUENCE caixa.arquivoinfracaomulta_i08_sequencial_seq");
        $atualizacaoiptuschema = $this->table('arquivoinfracaomulta', ['schema' => 'caixa', 'id' => false, 'primary_key' => 'i08_sequencial', 'constraint' => 'caixa.i08_sequencial_pk']);
        $atualizacaoiptuschema->addColumn('i08_sequencial',     'integer' )
                        ->addColumn('i08_arquivoinfracao', 'integer')
                        ->addForeignKey('i08_arquivoinfracao', 'caixa.arquivoinfracao', 'i07_sequencial', ['constraint'=>'arquivoinfracaomulta_i08_arquivoinfracao_fk'])
                        ->addIndex(['i08_arquivoinfracao'], ['name' => 'arquivoinfracaomulta_arquivoinfracao_in'])
                        ->addColumn('i08_dtpagamento', 'date')
                        ->addColumn('i08_dtrepasse', 'date')
                        ->addColumn('i08_nivel', 'integer')
                        ->addColumn('i08_vlfunset', 'float')
                        ->addColumn('i08_vldetran', 'float')
                        ->addColumn('i08_vlprefeitura', 'float')
                        ->addColumn('i08_vlbruto', 'float')
                        ->addColumn('i08_codigoinfracao', 'string', ['limit' => 10])
                        ->addColumn('i08_nossonumero',  'string', ['limit' => 11] )
                        ->addColumn('i08_autoinfracao', 'string', ['limit' => 13] )
                        ->addColumn('i08_duplicado', 'boolean', ['default' => false] )
                        ->create();
        $this->execute("ALTER TABLE caixa.arquivoinfracaomulta ALTER COLUMN i08_sequencial SET DEFAULT nextval('caixa.arquivoinfracaomulta_i08_sequencial_seq')");
    }

    public function removerDicionarioDados()
    {
        $this->execute('delete from configuracoes.db_syscadind  where codind in (1008225) ');
        $this->execute('delete from configuracoes.db_sysindices where codind in (1008225) ');
        $this->execute('delete from configuracoes.db_sysforkey where codarq in (1010228) ');

        $this->execute("delete from configuracoes.db_sysarqcamp where codcam in (1009452, 1009453, 1009454, 1009455, 1009456, 1009457, 1009458, 1009459, 1009460, 1009461, 1009462, 1009463, 1009464)");
        $this->execute('delete from configuracoes.db_sysprikey where codarq in(1010228)');
        $this->execute('delete from configuracoes.db_sysarqmod where codarq in(1010228)');
        $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010228)');
        $this->execute('delete from configuracoes.db_syssequencia where codsequencia in(1000692)');
        $this->execute("delete from configuracoes.db_syscampo where codcam in (1009452, 1009453, 1009454, 1009455, 1009456, 1009457, 1009458, 1009459, 1009460, 1009461, 1009462, 1009463, 1009464)");
    }


    private function removerTabela()
    {
        $this->execute("DROP TABLE IF EXISTS arquivoinfracaomulta");
        $this->execute("DROP SEQUENCE IF EXISTS arquivoinfracaomulta_i08_sequencial_seq");
    }
}
