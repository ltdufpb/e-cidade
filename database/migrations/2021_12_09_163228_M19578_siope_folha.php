<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class M19578SiopeFolha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->dicionarioUp();
        DB::connection()->getPdo()->exec(<<<SQL_WRAP
                   
                  /*
                   * fc_hash_int(text, integer)
                   *
                   *   . responsavel por gerar um hash em INT4 apartir de um text
                   *   . se usar 32, o retorno deve ser bigint, senao ira retornar
                   *   . numeros negativos, devera ser alterado a funcao
                   *
                   * Parametros:
                   *  \$1 - texto a ser processado.
                   *  \$2 - quantidade de bits para c\xe1lculo (default: 32)
                   *
                   * Retorno:
                   *  INT4 - hash gerado apartir do algoritmo
                   *
                   * Referencias:
                   *   https://stackoverflow.com/questions/9809381/hashing-a-string-to-a-numeric-value-in-postgresql
                   *   https://stackoverflow.com/questions/8316164/convert-hex-in-text-representation-to-decimal-number/8316731#8316731
                   *
                   */
                  CREATE OR REPLACE FUNCTION fc_hash_int(text, integer DEFAULT 32) RETURNS integer AS
                  \$\$
                  DECLARE
                  \thash_int INTEGER;
                  BEGIN
                  \tEXECUTE format(E'SELECT (\\'x\\'||substr(md5(%L),1,8))::bit(%s)::int;', \$1, \$2)
                  \tINTO \thash_int;
                  
                  \tRETURN hash_int;
                  END;
                  \$\$
                  LANGUAGE plpgsql;
                  
                  /*
                   *
                   * fc_dicionario_salt()
                   *
                   *   . retorna o 'salt' para ser usado na gera\xe7\xe3o do hash dos IDs do dicion\xe1rio
                   *
                   */
                  CREATE OR REPLACE FUNCTION fc_dicionario_salt()
                  RETURNS INTEGER AS
                  \$\$
                  \tSELECT 50000000;
                  \$\$
                  LANGUAGE sql IMMUTABLE;
                  
                  /*
                   *
                   * fc_remove_dicionario_tabela(text, text)
                   *
                   *   . responsavel por limpar dicionario de dados (tabelas db_sys*) apartir de um DROP TABLE
                   *
                   * Parametros:
                   *  \$1 - nome do esquema para buscar do PostgreSQL.
                   *  \$2 - nome da tabela para buscar do PostgreSQL.
                   *
                   *  Exemplos:
                   *     SELECT fc_remove_dicionario_tabela('caixa', 'arrecad'); -- Tabela caixa.arrecad
                   *
                   */
                  CREATE OR REPLACE FUNCTION fc_remove_dicionario_tabela(text, text)
                  RETURNS void AS
                  \$\$
                  DECLARE
                  \tsysarquivo \t\tINTEGER;
                  \tsysmodulo \t\tINTEGER;
                  \tsyscampos \t\tINTEGER[];
                  \trelid\t\t\tREGCLASS;
                  BEGIN
                  \t-- Salva o "relation id" do cat\xe1logo do PostgreSQL
                  \trelid := format('%I.%I', \$1, \$2)::regclass;
                  
                  \tSELECT \ta.codarq
                  \tINTO \tsysarquivo
                  \tFROM\tconfiguracoes.db_sysarquivo a
                  \t\t\tJOIN configuracoes.db_sysarqmod am ON am.codarq = a.codarq
                  \t\t\tJOIN configuracoes.db_sysmodulo m  ON am.codmod = m.codmod
                  \tWHERE \tregexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') = \$1
                  \tAND \ta.nomearq = \$2;
                  
                  \tIF sysarquivo IS NULL THEN
                  \t\tRAISE INFO 'Tabela %.% n\xe3o encontrada no dicion\xe1rio de dados!', \$1, \$2;
                  \tEND IF;
                  
                  \tRAISE DEBUG 'sysarquivo: %', sysarquivo;
                  
                  \tSELECT \tcodmod
                  \tINTO \tsysmodulo
                  \tFROM \tconfiguracoes.db_sysmodulo
                  \tWHERE \tregexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') = \$1;
                  
                  \tSELECT \tarray_agg(codcam)
                  \tINTO \tsyscampos
                  \tFROM \tconfiguracoes.db_sysarqcamp
                  \tWHERE \tcodarq = sysarquivo;
                  
                  \t-- 0) Cria tabelas tempor\xe1rias para salvar conte\xfado anterior
                  \tDROP TABLE IF EXISTS tmp_sysarquivo;
                  \tDROP TABLE IF EXISTS tmp_syscampo;
                  \tDROP TABLE IF EXISTS tmp_syscampodef;
                  \tDROP TABLE IF EXISTS tmp_syscampodep;
                  
                  \tCREATE TEMP TABLE tmp_sysarquivo AS
                  \t\tSELECT *, pg_catalog.obj_description(relid, 'pg_class') AS comentario
                  \t\tFROM db_sysarquivo WHERE codarq = sysarquivo;
                  
                  \tCREATE TEMP TABLE tmp_syscampo AS
                  \t\tSELECT *, pg_catalog.col_description(relid, (SELECT attnum FROM pg_attribute WHERE attrelid = relid AND attname = nomecam)) AS comentario
                  \t\tFROM db_syscampo WHERE codcam = ANY(syscampos);
                  
                  \tCREATE TEMP TABLE tmp_syscampodef AS
                  \t\tSELECT db_syscampodef.*,
                  \t\t       pg_catalog.col_description(relid, (SELECT attnum FROM pg_attribute WHERE attrelid = relid AND attname = nomecam)) AS comentario
                  \t\tFROM db_syscampodef INNER JOIN db_syscampo ON db_syscampo.codcam = db_syscampodef.codcam
                  \t\tWHERE db_syscampodef.codcam = ANY(syscampos);
                  
                  \tCREATE TEMP TABLE tmp_syscampodep AS
                  \t\tSELECT db_syscampodep.*,
                  \t\t       pg_catalog.col_description(relid, (SELECT attnum FROM pg_attribute WHERE attrelid = relid AND attname = nomecam)) AS comentario
                  \t\tFROM db_syscampodep INNER JOIN db_syscampo ON db_syscampo.codcam = db_syscampodep.codcam
                  \t\tWHERE db_syscampodep.codcam = ANY(syscampos);
                  
                  \t-- 1) Remove tudo
                  \tDELETE FROM configuracoes.db_sysarqmod WHERE codarq = sysarquivo AND codmod = sysmodulo;
                  \tDELETE FROM configuracoes.db_sysforkey WHERE codarq = sysarquivo;
                  \tDELETE FROM configuracoes.db_sysprikey WHERE codarq = sysarquivo;
                  \tDELETE FROM configuracoes.db_sysarqcamp WHERE codarq = sysarquivo AND codcam = ANY(syscampos);
                  \tDELETE FROM configuracoes.db_syscampodef WHERE codcam = ANY(syscampos);
                  \tDELETE FROM configuracoes.db_syscampodep WHERE codcam = ANY(syscampos);
                  \tDELETE FROM configuracoes.db_syscampo c WHERE c.codcam = ANY(syscampos)
                  \tAND NOT EXISTS (SELECT 1 FROM configuracoes.db_sysarqcamp ac WHERE ac.codcam = c.codcam AND ac.codarq IS DISTINCT FROM sysarquivo);
                  
                  \tDELETE FROM configuracoes.db_sysarquivo WHERE codarq = sysarquivo;
                  
                      RETURN;
                  END;
                  \$\$
                  LANGUAGE plpgsql;
                  
                  /*
                   *
                   * fc_gera_dicionario_apartir_tabela(text, text)
                   *
                   *   . responsavel por gerar dicionario de dados (tabelas db_sys*) apartir de uma tabela existente no PostgreSQL
                   *
                   * Parametros:
                   *  \$1 - nome do esquema para buscar do PostgreSQL.
                   *  \$2 - nome da tabela para buscar do PostgreSQL.
                   *
                   *  Exemplos:
                   *     SELECT fc_gera_dicionario_apartir_tabela('caixa', 'arrecad'); -- Tabela caixa.arrecad
                   *
                   */
                  CREATE OR REPLACE FUNCTION fc_gera_dicionario_apartir_tabela(text, text)
                  RETURNS void AS
                  \$\$
                  DECLARE
                  \tsysarquivo \t\tINTEGER;
                  \tsysarquivofk\tINTEGER;
                  \tsyscampo \t\tINTEGER;
                  \tsysmodulo \t\tINTEGER;
                  \tsyssequencia \tINTEGER;
                  \tr \t\t\t\tRECORD;
                  \trelid\t\t\tREGCLASS;
                  
                      tDescricao       TEXT;
                      sRotulo          VARCHAR;
                      bMaiusculo       BOOLEAN;
                      bAutocompl       BOOLEAN;
                      iAceitatipo      INTEGER;
                      sTipoobj         VARCHAR;
                      sRotulorel       VARCHAR;
                  BEGIN
                  \tSELECT \tcodmod
                  \tINTO \tsysmodulo
                  \tFROM \tconfiguracoes.db_sysmodulo
                  \tWHERE \tregexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') = \$1;
                  
                      -- Salva o "relation id" do cat\xe1logo do PostgreSQL
                  \trelid := format('%I.%I', \$1, \$2)::regclass;
                  
                  \t-- 0) Remove tudo
                  \tPERFORM fc_remove_dicionario_tabela(\$1, \$2);
                  
                  \tSELECT \tcodarq
                  \tINTO \tsysarquivo
                  \tFROM\ttmp_sysarquivo
                  \tWHERE \tnomearq = \$2;
                  
                  \tIF sysarquivo IS NULL THEN
                  \t\tsysarquivo := fc_hash_int(\$2, 28) + fc_dicionario_salt();
                  \tEND IF;
                  
                  \t-- 1) db_sysarquivo
                  \tINSERT INTO configuracoes.db_sysarquivo(codarq, nomearq)
                  \tVALUES (sysarquivo, \$2);
                  
                  \t-- 2) db_sysarqmod
                  \tINSERT INTO configuracoes.db_sysarqmod(codmod, codarq)
                  \tVALUES (sysmodulo, sysarquivo);
                  
                  \t-- 3) db_syscampo, db_syssequencia, db_sysarqcamp
                  \tFOR r IN
                  \t\tSELECT \tcolumns.table_catalog,
                  \t\t\t\tcolumns.table_schema,
                  \t\t\t\tcolumns.table_name,
                  \t\t\t\tcolumns.column_name,
                  \t\t\t\tcolumns.column_default,
                  \t\t\t\tcolumns.udt_name,
                  \t\t\t\t(columns.is_nullable='YES') AS is_nullable,
                  \t\t\t\tcolumns.character_maximum_length AS size,
                  \t\t\t\tcolumns.ordinal_position AS position,
                  \t\t\t\tsequences.sequence_name,
                  \t\t\t\tsequences.increment::integer AS increment,
                  \t\t\t\tsequences.start_value::integer AS start_value,
                  \t\t\t\tsequences.minimum_value::integer AS minimum_value,
                  \t\t\t\tsequences.maximum_value::bigint AS maximum_value,
                  \t\t\t\tkc.constraint_catalog,
                  \t\t\t\tkc.constraint_schema,
                  \t\t\t\tkc.constraint_name,
                  \t\t\t\tkc.ordinal_position AS position_in_constraint,
                  \t\t\t\tkc.position_in_unique_constraint,
                  \t\t\t\t(SELECT \tarray_agg(constraint_type::text)
                  \t\t\t\t FROM \t\tinformation_schema.table_constraints tc
                  \t\t\t\t WHERE \t\ttc.constraint_catalog = kc.constraint_catalog
                  \t\t\t\t AND \t\ttc.constraint_schema = kc.constraint_schema
                  \t\t\t\t AND \t\ttc.constraint_name = kc.constraint_name) AS constraint_type
                  \t\t\t\t
                  \t\tFROM \tinformation_schema.columns
                  \t\t\t\tLEFT JOIN information_schema.sequences \tON  sequences.sequence_catalog = columns.table_catalog
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\tAND sequences.sequence_schema = columns.table_schema
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\tAND format('nextval(%L::regclass)', sequences.sequence_name) = columns.column_default
                  
                  \t\t\t\tLEFT JOIN information_schema.key_column_usage kc\t\t\tON \tkc.table_catalog = columns.table_catalog
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAND kc.table_schema = columns.table_schema
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAND\tkc.table_name = columns.table_name
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAND kc.column_name = columns.column_name
                  \t\tWHERE \tcolumns.table_schema = \$1
                  \t\tAND \tcolumns.table_name = \$2
                  \tLOOP
                  \t\t-- 3.1) db_syscampo
                  \t\tSELECT \tcodcam
                  \t\tINTO \tsyscampo
                  \t\tFROM\ttmp_syscampo
                  \t\tWHERE \tnomecam = r.column_name;
                  
                          -- Implementado essa verifica\xe7\xe3o, pois pode haver o mesmo campo em mais de 1 tabela
                  \t\tIF syscampo IS NULL THEN
                             SELECT codcam
                             INTO   syscampo
                             FROM\tdb_syscampo
                             WHERE nomecam = r.column_name;
                  
                             INSERT INTO tmp_syscampo
                             SELECT *, pg_catalog.col_description(relid, (SELECT attnum FROM pg_attribute WHERE attrelid = relid AND attname = nomecam)) AS comentario
                             FROM db_syscampo WHERE nomecam = r.column_name;
                  
                  \t\tEND IF;
                  
                  \t\tIF syscampo IS NULL THEN
                  \t\t\tsyscampo := fc_hash_int(r.column_name, 28) + fc_dicionario_salt();
                  \t\tEND IF;
                  
                          SELECT coalesce(descricao, ''),
                                 coalesce(rotulo, ''),
                                 coalesce(maiusculo, false),
                                 coalesce(autocompl, false),
                                 coalesce(aceitatipo, 0),
                                 coalesce(tipoobj, ''),
                                 coalesce(rotulorel, '')
                            INTO tDescricao,
                                 sRotulo,
                                 bMaiusculo,
                                 bAutocompl,
                                 iAceitatipo,
                                 sTipoobj,
                                 sRotulorel
                          FROM tmp_syscampo
                  \t\tWHERE codcam = syscampo
                  \t\t  AND (comentario = '' OR comentario IS NULL);
                  
                  \t\tIF NOT FOUND THEN
                             tDescricao  = '';
                             sRotulo     = '';
                             bMaiusculo  = false;
                             bAutocompl  = false;
                             iAceitatipo = 0;
                             sTipoobj    = '';
                             sRotulorel  = '';
                          END IF;
                  
                  \t\tINSERT INTO configuracoes.db_syscampo(codcam, nomecam, conteudo, nulo, tamanho, valorinicial, 
                  \t\t                                      descricao, rotulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                  \t\tVALUES (syscampo, r.column_name, r.udt_name || coalesce('('||r.size||')', ''), r.is_nullable, r.size, r.column_default,
                  \t\t        tDescricao, sRotulo, bMaiusculo, bAutocompl, iAceitatipo, sTipoobj, sRotulorel)
                  \t\tON CONFLICT (nomecam)
                  \t\t\tDO UPDATE SET conteudo = EXCLUDED.conteudo, nulo = EXCLUDED.nulo, tamanho = EXCLUDED.tamanho;
                  \t\t
                  \t\t-- 3.2) db_syssequencia
                  \t\tIF r.sequence_name IS NOT NULL THEN
                  \t\t\tsyssequencia := fc_hash_int(r.sequence_name, 28) + fc_dicionario_salt();
                  
                  \t\t\tINSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq)
                  \t\t\tVALUES (syssequencia, r.sequence_name, r.increment, r.minimum_value, r.maximum_value, r.start_value)
                  \t\t\tON CONFLICT (nomesequencia)
                  \t\t\t\tDO UPDATE SET
                  \t\t\t\t\tincrseq = EXCLUDED.incrseq, minvalueseq = EXCLUDED.minvalueseq,
                  \t\t\t\t\tmaxvalueseq = EXCLUDED.maxvalueseq, startseq = EXCLUDED.startseq;
                  \t\tELSE
                  \t\t\tsyssequencia := NULL;
                  \t\tEND IF;
                  
                  \t\t-- 3.3) db_sysarqcamp
                  \t\tINSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
                  \t\tVALUES (sysarquivo, syscampo, r.position, syssequencia)
                  \t\tON CONFLICT ON CONSTRAINT db_sysarqcamp_codc_coda_seqa_pk
                  \t\t\tDO NOTHING;
                  
                  \t\t-- 3.4) db_sysprikey
                  \t\tIF 'PRIMARY KEY' = ANY(r.constraint_type) THEN
                  \t\t\tINSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, camiden)
                  \t\t\tVALUES (sysarquivo, syscampo, r.position_in_constraint, syscampo);
                  \t\tEND IF;
                  
                  \t\t-- 3.5) db_sysforkey
                  \t\tIF 'FOREIGN KEY' = ANY(r.constraint_type) THEN
                  \t\t\tSELECT \ta.codarq
                  \t\t\tINTO \tsysarquivofk
                  \t\t\tFROM \tinformation_schema.referential_constraints rc
                  \t\t\t\t\tJOIN information_schema.table_constraints tc \tON  tc.constraint_catalog = rc.unique_constraint_catalog
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAND tc.constraint_schema = rc.unique_constraint_schema
                  \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tAND tc.constraint_name = rc.unique_constraint_name
                  
                  \t\t\t\t\tJOIN configuracoes.db_sysmodulo m ON regexp_replace(lower(to_ascii(m.nomemod)), '[^A-Za-z]' , '', 'g') = tc.table_schema
                  \t\t\t\t\tJOIN configuracoes.db_sysarquivo a ON a.nomearq = tc.table_name
                  \t\t\t\t\tJOIN configuracoes.db_sysarqmod am ON am.codmod = m.codmod AND am.codarq = a.codarq
                  
                  \t\t\tWHERE \trc.constraint_catalog = r.constraint_catalog
                  \t\t\tAND \trc.constraint_schema = r.constraint_schema
                  \t\t\tAND \trc.constraint_name = r.constraint_name;
                  
                  \t\t\tIF sysarquivofk IS NOT NULL THEN
                  \t\t\t\tINSERT INTO configuracoes.db_sysforkey(codarq, codcam, sequen, referen)
                  \t\t\t\tVALUES (sysarquivo, syscampo, r.position_in_constraint, sysarquivofk);
                  \t\t\tEND IF;
                  \t\tELSE
                  \t\t\tsysarquivofk := NULL;
                  \t\tEND IF;
                  
                  \t\t-- 3.6) Atualiza metadados no dicionario da COLUNA apartir do comentario salvo
                  \t\tPERFORM fc_atualiza_dicionario_apartir_comentario('table column', format('%I.%I.%I', \$1, \$2, r.column_name), comentario)
                  \t\tFROM \ttmp_syscampo
                  \t\tWHERE \tnomecam = r.column_name
                  \t\tAND \tcomentario IS NOT NULL;
                  
                  \tEND LOOP;
                  
                  \t-- 4) Atualiza metadados no dicionario da TABELA apartir do comentario salvo
                  \tPERFORM fc_atualiza_dicionario_apartir_comentario('table', format('%I.%I', \$1, \$2), comentario)
                  \tFROM \ttmp_sysarquivo
                  \tWHERE \tnomearq = \$2
                  \tAND \tcomentario IS NOT NULL;
                  
                  \tRETURN;
                  END;
                  \$\$
                  LANGUAGE plpgsql;
                  
                  /*
                   *
                   * fc_atualiza_dicionario_apartir_comentario(text, text, text)
                   *
                   *   . responsavel por gerar dicionario de dados (tabelas db_sys*) apartir de uma tabela existente no PostgreSQL
                   *
                   * Parametros;
                   *  \$1 - tipo de objeto atualizar (valores: schema, table, table column)
                   *  \$2 - nome do objeto (schema: foo, table: foo.bar, table column: foo.bar.baz)
                   *  \$3 - coment\xe1rio no formato JSON
                   *
                   *  Exemplos:
                   *     SELECT fc_atualiza_dicionario_apartir_comentario(
                   * \t\t\t\t'table', 'caixa.arrecad', '{"descricao": "Debitos do Contribuinte"}'); -- Tabela caixa.arrecad
                   *
                   */
                  CREATE OR REPLACE FUNCTION fc_atualiza_dicionario_apartir_comentario(tipo_obj text, nome_obj text, comentario_obj text)
                  RETURNS void AS
                  \$\$
                  DECLARE
                  \tsysmodulo \t\tTEXT;
                  \tsysarquivo \t\tTEXT;
                  \tsyscampo \t\tTEXT;
                  \tsystabela   \tTEXT;
                  \tcomentario \t\tJSON;
                  \tsql_update\t\tTEXT;
                  \tsql_where \t\tTEXT;
                  \tlista_from \t\tTEXT;
                  \tlista_join \t\tTEXT;
                  \tcampos_update \tTEXT[];
                  \tlinhas\t\t\tINTEGER;
                  BEGIN
                  \tcomentario := comentario_obj::json;
                  \tsysmodulo  := split_part(nome_obj, '.', 1);
                  \tsql_where  := format('%s = %L',
                  \t\t\t\t\t\tE'regexp_replace(lower(to_ascii(db_sysmodulo.nomemod)), \\'[^A-Za-z]\\' , \\'\\', \\'g\\')', sysmodulo);
                  
                  \tRAISE DEBUG 'tipo_obj: %  nome_obj: %  comentario: %', tipo_obj, nome_obj, comentario_obj;
                  
                  \tCASE tipo_obj
                  \t\tWHEN 'schema' THEN
                  \t\t\tsystabela := 'configuracoes.db_sysmodulo';
                  \t\t\tcampos_update := ARRAY['descricao',  'dataincl', 'ativo'];
                  \t\tWHEN 'table' THEN
                  \t\t\tsysarquivo := split_part(nome_obj, '.', 2);
                  \t\t\tsystabela  := 'configuracoes.db_sysarquivo';
                  \t\t\t
                  \t\t\tlista_from := 'configuracoes.db_sysarqmod, configuracoes.db_sysmodulo';
                  \t\t\tlista_join := 'db_sysarquivo.codarq = db_sysarqmod.codarq AND db_sysarqmod.codmod = db_sysmodulo.codmod';
                  \t\t\tsql_where  := format('%s AND %s = %L', sql_where, 'db_sysarquivo.nomearq', sysarquivo);
                  
                  \t\t\tcampos_update := ARRAY['descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela',
                  \t\t\t\t\t\t\t\t   'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
                  \t\tWHEN 'table column' THEN
                  \t\t\tsysarquivo := split_part(nome_obj, '.', 2);
                  \t\t\tsyscampo   := split_part(nome_obj, '.', 3);
                  \t\t\tsystabela  := 'configuracoes.db_syscampo';
                  \t\t\t
                  \t\t\tlista_from := 'configuracoes.db_sysarqcamp, configuracoes.db_sysarquivo, configuracoes.db_sysarqmod, configuracoes.db_sysmodulo';
                  \t\t\tlista_join := 'db_syscampo.codcam = db_sysarqcamp.codcam';
                  \t\t\tlista_join := lista_join ||' AND db_sysarqcamp.codarq = db_sysarquivo.codarq';
                  \t\t\tlista_join := lista_join ||' AND db_sysarqmod.codarq = db_sysarquivo.codarq';
                  \t\t\tlista_join := lista_join ||' AND db_sysarqmod.codmod = db_sysmodulo.codmod';
                  
                  \t\t\tsql_where  := format('%s AND %s = %L AND %s = %L', sql_where, 
                  \t\t\t\t\t\t\t'db_sysarquivo.nomearq', sysarquivo,
                  \t\t\t\t\t\t\t'db_syscampo.nomecam', syscampo);
                  \t\t\t
                  \t\t\tcampos_update := ARRAY['conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho',
                  \t\t\t\t\t\t\t\t   'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
                  
                  \t\t\t-- Atualizar db_syscampodef
                  \t\t\tDELETE FROM db_syscampodef
                  \t\t\tWHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = syscampo);
                  
                  \t\t\tINSERT INTO db_syscampodef(codcam, defcampo, defdescr)
                  \t\t\tSELECT \tcodcam, value->>'defcampo', value->>'defdescr'
                  \t\t\tFROM \tjson_array_elements(comentario->'syscampodef'),
                  \t\t\t\t\tdb_syscampo
                  \t\t\tWHERE \tnomecam = syscampo;
                  \t\tELSE
                  \t\t\tRAISE EXCEPTION 'Tipo de objeto % inv\xe1lido!', tipo_obj;
                  \tEND CASE;
                  
                  \tSELECT \tformat('UPDATE %s SET %s', systabela, string_agg(format('%I = %L', key, value), ', '))
                  \tINTO \tsql_update
                  \tFROM \tjson_each_text(comentario)
                  \tWHERE \tlower(key) = ANY(campos_update);
                  
                  \tIF lista_from IS NULL THEN
                  \t\tsql_update := format('%s WHERE %s;', sql_update, sql_where);
                  \tELSE
                  \t\tsql_update := format('%s FROM %s WHERE %s AND %s;', sql_update, lista_from, lista_join, sql_where);
                  \tEND IF;
                  
                  \tRAISE DEBUG 'sysmodulo: %, sysarquivo: %, syscampo: %, comentario: %',
                  \t\tsysmodulo, sysarquivo, syscampo, comentario;
                  
                  \tRAISE DEBUG 'sql_update: %', sql_update;
                  
                  \tEXECUTE sql_update;
                  \tGET DIAGNOSTICS linhas = ROW_COUNT;
                  
                  \tRAISE DEBUG 'linhas: %', linhas;
                  
                  \tRETURN;
                  END;
                  \$\$
                  LANGUAGE plpgsql;
                  
                  CREATE OR REPLACE FUNCTION configuracoes.fc_dicionario_gatilho_ddl()
                  RETURNS event_trigger AS
                  \$\$
                  DECLARE
                  \tr \t\t\t\tRECORD;
                  \t_schema_name \tTEXT;
                  \t_current_query \tTEXT;
                  BEGIN
                  \tIF fc_getsession('__disable_trigger_dicionario__') IS NOT NULL THEN
                  \t\tRAISE DEBUG 'Event Trigger do Dicionario de Dados Desabilitada';
                  \t\tRETURN;
                  \tEND IF;
                  
                  \tFOR r IN
                  \t\tSELECT\tobjid, objsubid, schema_name, pg_class.relname::text AS table_name, command_tag, object_type, object_identity
                  \t\tFROM\tpg_event_trigger_ddl_commands()
                  \t\t\t\tLEFT JOIN pg_class ON pg_class.oid = objid
                  \t\tWHERE \tcommand_tag IN ('CREATE TABLE', 'ALTER TABLE', 'COMMENT')
                  \tLOOP
                  \t\tRAISE DEBUG 'pg_event_trigger_ddl_commands: %', r;
                  
                  \t\t-- Apenas algums subcomandos do ALTER TABLE s\xe3o permitidos como RENAME, ADD, DROP, SET SCHEMA e ALTER
                  \t\tIF r.command_tag = 'ALTER TABLE' THEN
                  \t\t\t_current_query := trim(regexp_replace(replace(upper(current_query()), 'ALTER TABLE ', ''), '\\s+', ' ', 'g'));
                  \t\t\tCONTINUE WHEN _current_query !~ '(RENAME|ADD|DROP|SET SCHEMA|ALTER) ';
                  \t\tEND IF;
                  
                  \t\tIF r.object_type = 'schema' AND r.command_tag = 'COMMENT' THEN
                  \t\t\t_schema_name = r.object_identity;
                  \t\tELSE
                  \t\t\t_schema_name = r.schema_name;
                  \t\tEND IF;
                  
                  \t\t-- Processa geracao do dicionario de dados apenas se o "esquema" existir na "db_sysmodulo"
                  \t\tIF EXISTS (SELECT 1 FROM configuracoes.db_sysmodulo WHERE regexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') = _schema_name) THEN
                  
                  \t\t\t-- Processa comandos de tabela
                  \t\t\tIF r.object_type = 'table' AND r.command_tag <> 'COMMENT' THEN
                  \t\t\t\t-- Particoes de tabelas particionadas (db_logsacessa, db_auditoria e debitos) devem ser ignoradas
                  \t\t\t\tCONTINUE WHEN r.table_name ~ '^(db_logsacessa|db_auditoria|debitos)_[0-9]' OR r.table_name ~ '^(db_logsacessa|db_auditoria|debitos)\$';
                  \t\t\t\tRAISE DEBUG '%', format('fc_gera_dicionario_apartir_tabela(%L, %L)', r.schema_name, r.table_name);
                  \t\t\t\tPERFORM\tfc_gera_dicionario_apartir_tabela(r.schema_name, r.table_name);
                  
                  \t\t\t-- Processa comandos de comentarios
                  \t\t\tELSIF r.command_tag = 'COMMENT' THEN
                  \t\t\t\tIF r.object_type = 'table column' THEN
                  \t\t\t\t\tPERFORM fc_atualiza_dicionario_apartir_comentario(
                  \t\t\t\t\t\t\t\tr.object_type, r.object_identity, pg_catalog.col_description(r.objid, r.objsubid));
                  \t\t\t\tELSIF r.object_type = 'table' THEN
                  \t\t\t\t\tPERFORM fc_atualiza_dicionario_apartir_comentario(
                  \t\t\t\t\t\t\t\tr.object_type, r.object_identity, pg_catalog.obj_description(r.objid, 'pg_class'));
                  \t\t\t\tELSIF r.object_type = 'schema' THEN
                  \t\t\t\t\tPERFORM fc_atualiza_dicionario_apartir_comentario(
                  \t\t\t\t\t\t\t\tr.object_type, r.object_identity, pg_catalog.obj_description(r.objid, 'pg_namespace'));
                  \t\t\t\tEND IF;
                  \t\t\tEND IF;
                  
                  \t\t\tIF r.object_type <> 'schema' THEN
                  \t\t\t\t-- Salva na sessao tabelas que foram processadas
                  \t\t\t\tPERFORM fc_putsession('__evtg_dicionario_gatilho_ddl_tables__', array_agg(distinct i)::text)
                  \t\t\t\tFROM \tunnest(array_append(fc_getsession('__evtg_dicionario_gatilho_ddl_tables__')::text[], format('%s.%s', r.schema_name, r.table_name))) AS i;
                  \t\t\tEND IF;
                  \t\tEND IF;
                  \tEND LOOP;
                  
                      RETURN;
                  END;
                  \$\$
                  SECURITY DEFINER
                  LANGUAGE plpgsql;
                  
                  DROP EVENT TRIGGER IF EXISTS evtg_dicionario_gatilho_ddl;
                  CREATE EVENT TRIGGER evtg_dicionario_gatilho_ddl
                  \tON ddl_command_end
                  \tWHEN tag IN ('CREATE TABLE', 'ALTER TABLE', 'COMMENT')
                  \tEXECUTE FUNCTION configuracoes.fc_dicionario_gatilho_ddl();
                  ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl DISABLE;
                  
                  CREATE OR REPLACE FUNCTION configuracoes.fc_dicionario_gatilho_ddl_drop()
                  RETURNS event_trigger AS
                  \$\$
                  DECLARE
                  \tr \tRECORD;
                  BEGIN
                  \tIF fc_getsession('__disable_trigger_dicionario__') IS NOT NULL THEN
                  \t\tRAISE DEBUG 'Event Trigger do Dicionario de Dados Desabilitada';
                  \t\tRETURN;
                  \tEND IF;
                  
                  \tFOR r IN
                  \t\tSELECT\tschema_name, object_name AS table_name
                  \t\tFROM\tpg_event_trigger_dropped_objects()
                  \t\tWHERE \tobject_type = 'table'
                  \tLOOP
                  \t\t-- Processa geracao do dicionario de dados apenas se o "esquema" existir na "db_sysmodulo"
                  \t\tIF EXISTS (SELECT 1 FROM configuracoes.db_sysmodulo WHERE regexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') = r.schema_name) THEN
                  \t\t\tRAISE DEBUG 'pg_event_trigger_dropped_objects: %', r;
                  \t\t\tPERFORM fc_remove_dicionario_tabela(r.schema_name, r.table_name);
                  
                  \t\t\t-- Salva na sessao tabelas que foram processadas
                  \t\t\tPERFORM fc_putsession('__evtg_dicionario_gatilho_ddl_tables__', array_agg(distinct i)::text)
                  \t\t\tFROM \tunnest(array_append(fc_getsession('__evtg_dicionario_gatilho_ddl_tables__')::text[], format('%s.%s', r.schema_name, r.table_name))) AS i;
                  \t\tEND IF;
                  \tEND LOOP;
                  
                      RETURN;
                  END;
                  \$\$
                  SECURITY DEFINER
                  LANGUAGE plpgsql;
                  
                  DROP EVENT TRIGGER IF EXISTS evtg_dicionario_gatilho_ddl_drop;
                  CREATE EVENT TRIGGER evtg_dicionario_gatilho_ddl_drop
                  \tON sql_drop
                  \tEXECUTE FUNCTION configuracoes.fc_dicionario_gatilho_ddl_drop();
                  ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl_drop DISABLE;
        
        SQL_WRAP
);

        DB::connection()->getPdo()->exec(<<<SQL

       ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl ENABLE;
       ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl_drop ENABLE;

       DROP SEQUENCE IF EXISTS pessoal.siopesituacao_id_seq;
       CREATE SEQUENCE pessoal.siopesituacao_id_seq
          INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
       
       create table IF NOT EXISTS pessoal.siopesituacao (
       
          si01_id        int4 NOT NULL DEFAULT nextval('pessoal.siopesituacao_id_seq'),
          si01_descricao varchar NOT NULL,
          CONSTRAINT siopesituacao_id_pk PRIMARY KEY (si01_id)
       );

       COMMENT ON TABLE pessoal.siopesituacao IS '{"descricao": "Tabela de cadastro de situações",
                                                   "sigla": "si01",
                                                   "dataincl": "2021-12-09",
                                                   "rotulo": "siopesituacao",
                                                   "tipotabela": "0",
                                                   "naolibclass": "false",
                                                   "naolibfunc": "false",
                                                   "naolibprog": "false",
                                                   "naolibform": "false"
                                                  }';

       COMMENT ON COLUMN pessoal.siopesituacao.si01_id IS '{ "descricao": "Código da Situação",
                                                             "rotulo": "Código da Situação",
                                                             "rotulorel": "Código da Situação",
                                                             "maiusculo": false,
                                                             "autocompl": false,
                                                             "aceitatipo": 1,
                                                             "tamanho": 10,
                                                             "tipoobj": "text"
                                                           }' ;

       COMMENT ON COLUMN pessoal.siopesituacao.si01_descricao IS '{ "descricao": "Situação",
                                                                    "rotulo": " Situação",
                                                                    "rotulorel": " Situação",
                                                                    "maiusculo": true,
                                                                    "autocompl": false,
                                                                    "aceitatipo": 3,
                                                                    "tamanho": 100,
                                                                    "tipoobj": "text"
                                                                  }' ;

       DROP SEQUENCE IF EXISTS pessoal.siopecategoriatipo_id_seq;
       CREATE SEQUENCE IF NOT EXISTS pessoal.siopecategoriatipo_id_seq
          INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

       create table IF NOT EXISTS pessoal.siopecategoriatipo (
       
          si02_id        int4 NOT NULL DEFAULT nextval('pessoal.siopecategoriatipo_id_seq'),
          si02_descricao varchar,
          CONSTRAINT siopecategoriatipo_id_pk PRIMARY KEY (si02_id)
       );

       COMMENT ON TABLE pessoal.siopecategoriatipo IS '{"descricao": "Tabela de cadastro dos tipos de categoria",
                                                        "sigla": "si02",
                                                        "dataincl": "2021-12-09",
                                                        "rotulo": "siopecategoriatipo",
                                                        "tipotabela": "0",
                                                        "naolibclass": "false",
                                                        "naolibfunc": "false",
                                                        "naolibprog": "false",
                                                        "naolibform": "false"
                                                       }';

       COMMENT ON COLUMN pessoal.siopecategoriatipo.si02_id IS '{ "descricao": "Código do Tipo de Categoria",
                                                                  "rotulo": "Código do Tipo de Categoria",
                                                                  "rotulorel": "Código do Tipo de Categoria",
                                                                  "maiusculo": false,
                                                                  "autocompl": false,
                                                                  "aceitatipo": 1,
                                                                  "tamanho": 10,
                                                                  "tipoobj": "text"
                                                                }' ;

       COMMENT ON COLUMN pessoal.siopecategoriatipo.si02_descricao IS '{ "descricao": "Tipo Categoria",
                                                                         "rotulo": " Tipo Categoria",
                                                                         "rotulorel": " Tipo Categoria",
                                                                         "maiusculo": true,
                                                                         "autocompl": false,
                                                                         "aceitatipo": 3,
                                                                         "tamanho": 255,
                                                                         "tipoobj": "text"
                                                                       }' ;

       DROP SEQUENCE IF EXISTS pessoal.siopecategoria_id_seq;
       CREATE SEQUENCE pessoal.siopecategoria_id_seq
          INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

       create table IF NOT EXISTS pessoal.siopecategoria (
      
          si03_id                 int4 NOT NULL DEFAULT nextval('pessoal.siopecategoria_id_seq'),
          si03_siopecategoriatipo int4 NOT NULL,
          si03_descricao          varchar,
          CONSTRAINT siopecategoria_id_pk PRIMARY KEY (si03_id),
          constraint siopecategoria_fk foreign key (si03_siopecategoriatipo) references pessoal.siopecategoriatipo
       );       
       
       COMMENT ON TABLE pessoal.siopecategoria IS '{"descricao": "Tabela de cadastro das categorias",
                                                    "sigla": "si03",
                                                    "dataincl": "2021-12-09",
                                                    "rotulo": "siopecategoria",
                                                    "tipotabela": "0",
                                                    "naolibclass": "false",
                                                    "naolibfunc": "false",
                                                    "naolibprog": "false",
                                                    "naolibform": "false"
                                                   }';

       COMMENT ON COLUMN pessoal.siopecategoria.si03_id IS '{ "descricao": "Código da Categoria",
                                                              "rotulo": "Código da Categoria",
                                                              "rotulorel": "Código da Categoria",
                                                              "maiusculo": false,
                                                              "autocompl": false,
                                                              "aceitatipo": 1,
                                                              "tamanho": 10,
                                                              "tipoobj": "text"
                                                            }' ;

       COMMENT ON COLUMN pessoal.siopecategoria.si03_siopecategoriatipo IS '{ "descricao": "Código do Tipo de Categoria",
                                                                              "rotulo": "Código do Tipo de Categoria",
                                                                              "rotulorel": "Código do Tipo de Categoria",
                                                                              "maiusculo": false,
                                                                              "autocompl": false,
                                                                              "aceitatipo": 1,
                                                                              "tamanho": 10,
                                                                              "tipoobj": "text"
                                                                            }' ;

       COMMENT ON COLUMN pessoal.siopecategoria.si03_descricao IS '{ "descricao": "Categoria",
                                                                     "rotulo": " Categoria",
                                                                     "rotulorel": " Categoria",
                                                                     "maiusculo": true,
                                                                     "autocompl": false,
                                                                     "aceitatipo": 3,
                                                                     "tamanho": 255,
                                                                     "tipoobj": "text"
                                                                   }' ;

       DROP SEQUENCE IF EXISTS pessoal.siopequalificacao_id_seq;
       CREATE SEQUENCE pessoal.siopequalificacao_id_seq
          INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

       create table IF NOT EXISTS pessoal.siopequalificacao (

          si04_id        int4 NOT NULL DEFAULT nextval('pessoal.siopequalificacao_id_seq'),
          si04_descricao text NOT NULL,
          CONSTRAINT siopequalificacao_id_pk PRIMARY KEY (si04_id)
       );

       COMMENT ON TABLE pessoal.siopequalificacao IS '{"descricao": "Tabela de cadastro de qualificações do servidor",
                                                       "sigla": "si04",
                                                       "dataincl": "2021-12-09",
                                                       "rotulo": "siopequalificacao",
                                                       "tipotabela": "0",
                                                       "naolibclass": "false",
                                                       "naolibfunc": "false",
                                                       "naolibprog": "false",
                                                       "naolibform": "false"
                                                      }';

       COMMENT ON COLUMN pessoal.siopequalificacao.si04_id IS '{ "descricao": "Código da Qualificação",
                                                                 "rotulo": "Código da Qualificação",
                                                                 "rotulorel": "Código da Qualificação",
                                                                 "maiusculo": false,
                                                                 "autocompl": false,
                                                                 "aceitatipo": 1,
                                                                 "tamanho": 10,
                                                                 "tipoobj": "text"
                                                               }' ;

       COMMENT ON COLUMN pessoal.siopequalificacao.si04_descricao IS '{ "descricao": "Qualificação",
                                                                        "rotulo": " Qualificação",
                                                                        "rotulorel": " Qualificação",
                                                                        "maiusculo": true,
                                                                        "autocompl": false,
                                                                        "aceitatipo": 3,
                                                                        "tamanho": 1,
                                                                        "tipoobj": "text"
                                                                      }' ;

       alter table pessoal.rhlocaltrab add column if not exists rh55_inep integer not null default 0;

       COMMENT ON COLUMN pessoal.rhlocaltrab.rh55_inep IS '{ "descricao": "Código do Inep",
                                                             "rotulo": "Código do Inep",
                                                             "rotulorel": "Código do Inep",
                                                             "maiusculo": false,
                                                             "autocompl": false,
                                                             "aceitatipo": 1,
                                                             "tamanho": 10,
                                                             "tipoobj": "text"
                                                           }' ;

       DROP SEQUENCE IF EXISTS pessoal.siopesegmentoatuacao_segmento_seq;
       CREATE SEQUENCE pessoal.siopesegmentoatuacao_segmento_seq
          INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

       CREATE TABLE IF NOT EXISTS pessoal.siopesegmentoatuacao (
          si07_segmento  int4 NOT NULL DEFAULT nextval('pessoal.siopesegmentoatuacao_segmento_seq'),
          si07_descricao varchar(255) NOT NULL,
          CONSTRAINT siopesegmentoatuacao_segmento_pk PRIMARY KEY (si07_segmento)
       );
       
       COMMENT ON TABLE pessoal.siopesegmentoatuacao IS '{"descricao": "Tabela de cadastro do Segmento de Atuação",
                                                          "sigla": "si07",
                                                          "dataincl": "2021-12-09",
                                                          "rotulo": "siopesegmentoatuacao",
                                                          "tipotabela": "0",
                                                          "naolibclass": "false",
                                                          "naolibfunc": "false",
                                                          "naolibprog": "false",
                                                          "naolibform": "false"
                                                         }';

       COMMENT ON COLUMN pessoal.siopesegmentoatuacao.si07_segmento IS '{ "descricao": "Código do Segmento de Atuação",
                                                                          "rotulo": "Código do Segmento de Atuação",
                                                                          "rotulorel": "Código do Segmento de Atuação",
                                                                          "maiusculo": false,
                                                                          "autocompl": false,
                                                                          "aceitatipo": 1,
                                                                          "tamanho": 10,
                                                                          "tipoobj": "text"
                                                                        }' ;

       COMMENT ON COLUMN pessoal.siopesegmentoatuacao.si07_descricao IS '{ "descricao": "Segmento de Atuação",
                                                                           "rotulo": " Segmento de Atuação",
                                                                           "rotulorel": " Segmento de Atuação",
                                                                           "maiusculo": true,
                                                                           "autocompl": false,
                                                                           "aceitatipo": 3,
                                                                           "tamanho": 100,
                                                                           "tipoobj": "text"
                                                                         }' ;

       create table IF NOT EXISTS pessoal.siopeservidormanutencao (

          si06_servidor int4 NOT NULL,
          si06_categoria int4 NOT NULL,
          si06_situacao int4 NOT NULL,
          si06_segmento int4 NOT NULL,
          constraint siopeservidormanutencao_servidor_pk PRIMARY KEY (si06_servidor),
          constraint siopeservidormanutencao_servidor_fk foreign key (si06_servidor) references pessoal.rhpessoal,
          constraint siopeservidormanutencao_categoria_fk foreign key (si06_categoria) references pessoal.siopecategoria,
          constraint siopeservidormanutencao_situacao_fk foreign key (si06_situacao) references pessoal.siopesituacao,
          constraint siopeservidormanutencao_segmento_fk foreign key (si06_segmento) references pessoal.siopesegmentoatuacao
       );

       COMMENT ON TABLE pessoal.siopeservidormanutencao IS '{"descricao": "Tabela com a matricula do servidor e suas caracteristicas para o siope",
                                                             "sigla": "si06",
                                                             "dataincl": "2021-12-09",
                                                             "rotulo": "siopeservidormanutencao",
                                                             "tipotabela": "2",
                                                             "naolibclass": "false",
                                                             "naolibfunc": "false",
                                                             "naolibprog": "false",
                                                             "naolibform": "false"
                                                            }';

       COMMENT ON COLUMN pessoal.siopeservidormanutencao.si06_servidor IS '{ "descricao": "Matricula do servidor",
                                                                             "rotulo": "Matricula do servidor",
                                                                             "rotulorel": "Matricula do servidor",
                                                                             "maiusculo": false,
                                                                             "autocompl": false,
                                                                             "aceitatipo": 1,
                                                                             "tamanho": 10,
                                                                             "tipoobj": "text"
                                                                           }' ;

       COMMENT ON COLUMN pessoal.siopeservidormanutencao.si06_categoria IS '{ "descricao": "Categoria do Servidor",
                                                                              "rotulo": "Categoria do Servidor",
                                                                              "rotulorel": "Categoria do Servidor",
                                                                              "maiusculo": false,
                                                                              "autocompl": false,
                                                                              "aceitatipo": 1,
                                                                              "tamanho": 10,
                                                                              "tipoobj": "text"
                                                                            }' ;

       COMMENT ON COLUMN pessoal.siopeservidormanutencao.si06_situacao IS '{ "descricao": "Situação do Servidor",
                                                                             "rotulo": "Situação do Servidor",
                                                                             "rotulorel": "Situação do Servidor",
                                                                             "maiusculo": false,
                                                                             "autocompl": false,
                                                                             "aceitatipo": 1,
                                                                             "tamanho": 10,
                                                                             "tipoobj": "text"
                                                                           }' ;

       COMMENT ON COLUMN pessoal.siopeservidormanutencao.si06_segmento IS '{ "descricao": "Segmento de Atuação do Servidor",
                                                                             "rotulo": "Segmento de Atuação do Servidor",
                                                                             "rotulorel": "Segmento de Atuação do Servidor",
                                                                             "maiusculo": false,
                                                                             "autocompl": false,
                                                                             "aceitatipo": 1,
                                                                             "tamanho": 10,
                                                                             "tipoobj": "text"
                                                                           }' ;

       create table IF NOT EXISTS pessoal.siopeservidorqualificacao (

          si08_servidor int4 NOT NULL,
          si08_qualificacao int4 NOT NULL,
          constraint siopeservidorqualificacao_servidor_qualific_pk primary key (si08_servidor, si08_qualificacao),
          constraint siopeservidorqualificacao_servidor_fk foreign key (si08_servidor) references pessoal.rhpessoal,
          constraint siopeservidorqualificacao_qualificacao_fk foreign key (si08_qualificacao) references pessoal.siopequalificacao
       );

       COMMENT ON TABLE pessoal.siopeservidorqualificacao IS '{"descricao": "Tabela com a matricula do servidor e suas qualificações",
                                                               "sigla": "si08",
                                                               "dataincl": "2021-12-09",
                                                               "rotulo": "siopeservidorqualificacao",
                                                               "tipotabela": "2",
                                                               "naolibclass": "false",
                                                               "naolibfunc": "false",
                                                               "naolibprog": "false",
                                                               "naolibform": "false"
                                                              }';

       COMMENT ON COLUMN pessoal.siopeservidorqualificacao.si08_servidor IS '{ "descricao": "Matricula do servidor",
                                                                               "rotulo": "Matricula do servidor",
                                                                               "rotulorel": "Matricula do servidor",
                                                                               "maiusculo": false,
                                                                               "autocompl": false,
                                                                               "aceitatipo": 1,
                                                                               "tamanho": 10,
                                                                               "tipoobj": "text"
                                                                             }' ;

       COMMENT ON COLUMN pessoal.siopeservidorqualificacao.si08_qualificacao IS '{ "descricao": "Qualificação do Servidor",
                                                                                   "rotulo": "Qualificação do Servidor",
                                                                                   "rotulorel": "Qualificação do Servidor",
                                                                                   "maiusculo": false,
                                                                                   "autocompl": false,
                                                                                   "aceitatipo": 1,
                                                                                   "tamanho": 10,
                                                                                   "tipoobj": "text"
                                                                                 }' ;

       insert into pessoal.siopesituacao (si01_descricao) values ('Efetivo');
       insert into pessoal.siopesituacao (si01_descricao) values ('Temporário');
       insert into pessoal.siopesituacao (si01_descricao) values ('Profissional da educação em atividade alheia à MDE');
       insert into pessoal.siopesituacao (si01_descricao) values ('Outros');

       insert into pessoal.siopecategoriatipo (si02_descricao) values ('Profissionais do Magistério');
       insert into pessoal.siopecategoriatipo (si02_descricao) values ('Outros Profissionais da Educação');

       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente habilitado em curso de nível médio');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente habilitado em curso de pedagogia');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente habilitado em curso de licenciatura plena');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente habilitado em programa especial de formação pedagógica de docentes');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente pós-graduado em cursos de especialização para formação de docentes para educação profissional técnica de nível médio');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente graduado bacharel e tecnólogo com diploma de mestrado ou doutorado na área do componente curricular da educação profissional técnica de nível médio');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente professor indígena sem prévia formação pedagógica');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente instrutor, tradutor e intérprete de Libras');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Docente professor de comunidade quilombola');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Profissionais não habilitados, porém  autorizados a exercer a docência em caráter precário e provisório na educação infantil e nos anos iniciais do ensino fundamental');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Profissionais graduados, bacharéis e tecnólogos autorizados a atuar como docentes, em caráter   precário e provisório, nos anos finais do ensino fundamental e no ensino médio e médio integrado à educação');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Profissionais experientes, não graduados, autorizados a atuar como docentes, em caráter precário e provisório, no ensino médio e médio integrado à educação profissional técnica de nível médio');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (1, 'Profissionais em efetivo exercício no âmbito da educação infantil e ensino fundamental');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (2, 'Auxiliar/Assistente Educacional');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (2, 'Profissionais que exercem funções de secretaria escolar, alimentação escolar (merendeiras), multimeios didáticos e infraestrutura');
       insert into pessoal.siopecategoria (si03_siopecategoriatipo, si03_descricao)
          values (2, 'Profissionais que atuam na realização das atividades requeridos nos ambientes de secretaria, de manutenção em geral');

       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 61 da LBD - Professores habilitados em nível médio ou superior para a docência na educação infantil e nos ensinos fundamental e médio.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 61 da LBD - Trabalhadores em educação portadores de diploma de pedagogia, com habilitação em administração, planejamento, supervisão, inspeção e orientação educacional, bem como com títulos de mestrado ou doutorado nas mesmas áreas.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 61 da LBD - Trabalhadores em educação, portadores de diploma de curso técnico ou superior em área pedagógica ou afim.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 61 da LBD - Profissionais com notório saber reconhecido pelos respectivos sistemas de ensino, para ministrar conteúdos de áreas afins à sua formação ou experiência profissional, atestados por titulação específica ou prática de ensino em unidades educacionais da rede pública ou privada ou das corporações privadas em que tenham atuado, exclusivamente para atender ao inciso V do caput do art. 36.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 61 da LBD - Profissionais graduados que tenham feito complementação pedagógica, conforme disposto pelo Conselho Nacional de Educação.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 1 da Lei nº 13.935/2019 - Prestação de serviços em psicologia.');
       insert into pessoal.siopequalificacao (si04_descricao)
          values ('Art. 1 da Lei nº 13.935/2019 - Prestação de serviços em serviço social');

       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Creche');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Pre-escola');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Fundamental 1');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Fundamental 2');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Medio');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Profissional');
       INSERT INTO pessoal.siopesegmentoatuacao (si07_descricao) VALUES ('Administrativo');

       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopesituacao');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopecategoriatipo');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopecategoria');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopequalificacao');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopesegmentoatuacao');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopeservidormanutencao');
       select  fc_gera_dicionario_apartir_tabela('pessoal', 'siopeservidorqualificacao');

       ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl DISABLE;
       ALTER EVENT TRIGGER evtg_dicionario_gatilho_ddl_drop DISABLE;

SQL
);

    }

    private function dicionarioUp()
    {
        DB::statement("insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
                                        values ( 228603 ,'Informações SIOPE' ,'Informações SIOPE' ,'pes1_manutencaosiope.php' ,
                                                 '1' ,'1' ,'Rotina para cadastrar as informações do Siope' ,'true' );");
        DB::statement("insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4354 ,228603 ,9 ,952 );");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dicionarioDown();
        DB::connection()->getPdo()->exec(<<<SQL

          select fc_remove_dicionario_tabela('pessoal', 'siopesituacao');
          select fc_remove_dicionario_tabela('pessoal', 'siopecategoriatipo');
          select fc_remove_dicionario_tabela('pessoal', 'siopecategoria');
          select fc_remove_dicionario_tabela('pessoal', 'siopequalificacao');
          select fc_remove_dicionario_tabela('pessoal', 'siopesegmentoatuacao');
          select fc_remove_dicionario_tabela('pessoal', 'siopeservidormanutencao');
          select fc_remove_dicionario_tabela('pessoal', 'siopeservidorqualificacao');
          
          drop table if exists pessoal.siopeservidorqualificacao;
          drop table if exists pessoal.siopeservidormanutencao;
          drop table if exists pessoal.siopecategoria;
          drop table if exists pessoal.siopecategoriatipo;
          drop table if exists pessoal.siopesituacao;
          drop table if exists pessoal.siopequalificacao;
          drop table if exists pessoal.siopesegmentoatuacao;
          
          alter table pessoal.rhlocaltrab drop column if exists rh55_inep;

SQL
);
    }

    private function dicionarioDown()
    {
        DB::statement("delete from db_menu where id_item_filho = 228603");
        DB::statement("delete from db_itensmenu where id_item = 228603");
    }

}
