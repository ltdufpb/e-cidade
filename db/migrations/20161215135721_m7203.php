<?php

use Classes\PostgresMigration;

class M7203 extends PostgresMigration
{

  public function up()
  {

    $codeAtribute = $this->fetchRow("select db118_sequencial from configuracoes.db_cadattdinamico where db118_descricao = 'Atributos da licitação'");
    $codeAtribute = $codeAtribute['db118_sequencial'];

    $data = [
      (object)['descricao' => 'CNPJ do Órgão Gerenciador',          'propriedade' => 'cnpjorgaogerenciador', 'tipo' => 1],
      (object)['descricao' => 'Nome do Órgão Gerenciador',          'propriedade' => 'nomeorgaogerenciador', 'tipo' => 1],
      (object)['descricao' => 'Número da Licitação Original',       'propriedade' => 'numerolicitacao',      'tipo' => 1],
      (object)['descricao' => 'Ano da Licitação Original',          'propriedade' => 'anolicitacao',         'tipo' => 2],
      (object)['descricao' => 'Número da Ata de Registro de Preço', 'propriedade' => 'numeroataregistropreco', 'tipo' => 1],
      (object)['descricao' => 'Data da Ata de Adesão',              'propriedade' => 'dataata',                'tipo' => 3],
      (object)['descricao' => 'Data de Autorização da Adesão',      'propriedade' => 'dataautorizacao',        'tipo' => 3],
      (object)['descricao' => 'Tipo de Atuação',                    'propriedade' => 'tipoatuacao',            'tipo' => 1]
    ];


    $dataColumns = [
      'db109_sequencial',
      'db109_db_cadattdinamico',
      'db109_codcam',
      'db109_descricao',
      'db109_valordefault',
      'db109_tipo',
      'db109_nome'
    ];

    $lastSequence = null;
    $table = $this->table('db_cadattdinamicoatributos', ['schema' => 'configuracoes']);
    $dataRow = [];
    foreach ($data as $row) {

      $lastSequence = $this->fetchRow("select nextval('configuracoes.db_cadattdinamicoatributos_db109_sequencial_seq') as nextval");
      $lastSequence = $lastSequence['nextval'];

      $dataRow[] = [
        $lastSequence,
        $codeAtribute,
        null,
        $row->descricao,
        null,
        $row->tipo,
        $row->propriedade
      ];
    }

    $table->insert($dataColumns, $dataRow);
    $table->saveData();
    unset($table, $dataColumns, $dataRow);

    $data = [
      (object)['valor' => 'P', 'descricao' => 'Participante'],
      (object)['valor' => 'A', 'descricao' => 'Não Participante / Aderente']
    ];

    $dataColumns = [
      'db18_sequencial',
      'db18_cadattdinamicoatributos',
      'db18_opcao',
      'db18_valor'
    ];

    $dataRows = [];
    $table = $this->table('db_cadattdinamicoatributosopcoes', ['schema' => 'configuracoes']);
    foreach ($data as $row) {

      $sequence = $this->fetchRow("select nextval('configuracoes.db_cadattdinamicoatributosopcoes_db18_sequencial_seq') as nextval");

      $dataRows[] = [
        $sequence['nextval'],
        $lastSequence,
        $row->valor,
        $row->descricao
      ];
    }

    $table->insert($dataColumns, $dataRows);
    $table->saveData();
  }


  public function down()
  {

    $nameAtributes = [
      'cnpjorgaogerenciador',
      'nomeorgaogerenciador',
      'numerolicitacao',
      'anolicitacao',
      'propriedade',
      'dataata',
      'dataautorizacao',
      'tipoatuacao',
      'numeroataregistropreco'
    ];

    $deleteOptions = "delete from db_cadattdinamicoatributosopcoes
                            using db_cadattdinamicoatributos
                            where db_cadattdinamicoatributosopcoes.db18_cadattdinamicoatributos = db_cadattdinamicoatributos.db109_sequencial
                              and db_cadattdinamicoatributos.db109_nome = 'tipoatuacao'
                              and db109_db_cadattdinamico = 2";

    $deleteAtributes = "delete from db_cadattdinamicoatributos
                              where db_cadattdinamicoatributos.db109_db_cadattdinamico = 2
                                and db_cadattdinamicoatributos.db109_nome in ('".implode("','", $nameAtributes)."')";

    $this->execute($deleteOptions);
    $this->execute($deleteAtributes);
  }
}
