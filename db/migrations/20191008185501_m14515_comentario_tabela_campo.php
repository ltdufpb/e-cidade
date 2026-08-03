<?php

use Classes\PostgresMigration;

class M14515ComentarioTabelaCampo extends PostgresMigration
{
    /**
     *Adicionar COMMENT de um campo na fc_auditoria_consulta_mudancas
     */

    public function up()
    {
        $sql = <<<SQL_WRAP
        
                    CREATE TYPE configuracoes.tp_auditoria_consulta_mudancas AS (
        \tesquema           TEXT,
        \ttabela            TEXT,
        \tcomentario_tabela TEXT,
        \toperacao          CHAR(1),
        \tchave             VARCHAR,
        \ttransacao         BIGINT,
        \tdatahora_sessao   TIMESTAMP WITH TIME ZONE,
        \tdatahora_servidor TIMESTAMP WITH TIME ZONE,
        \tusuario           VARCHAR(20),
        \tnome_campo        TEXT,
        \tcomentario_campo  TEXT,
        \tvalor_antigo      TEXT,
        \tvalor_novo        TEXT,
        \tlogsacessa        INTEGER,
        \tinstit            INTEGER
        );
        
        CREATE OR REPLACE FUNCTION fc_comentario_tabela(TEXT, TEXT)
        RETURNS TEXT AS
        \$\$
        BEGIN
        \tRETURN pg_catalog.obj_description(format('%I.%I', \$1, \$2)::regclass, 'pg_class');
        EXCEPTION
        \tWHEN undefined_table THEN
        \t\tRETURN NULL;
        END;
        \$\$
        LANGUAGE plpgsql;
        
        CREATE OR REPLACE FUNCTION fc_comentario_campo(TEXT, TEXT, TEXT)
        RETURNS TEXT AS
        \$\$
        DECLARE
        \t_objid \t\tOID;
        \t_objsubid \tSMALLINT;
        BEGIN
        \t_objid := format('%I.%I', \$1, \$2)::regclass;
        
        \tSELECT \tattnum
        \tINTO \t_objsubid
        \tFROM \tpg_catalog.pg_attribute
        \tWHERE \tattrelid = _objid
        \tAND \tattname  = \$3;
        
        \tRETURN pg_catalog.col_description(_objid, _objsubid);
        EXCEPTION
        \tWHEN undefined_table THEN
        \t\tRETURN NULL;
        END;
        \$\$
        LANGUAGE plpgsql;
        
        CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_consulta_mudancas(
        \ttDataHoraInicio TIMESTAMP,
        \ttDataHoraFim    TIMESTAMP,
        \tsEsquema        TEXT,
        \tsTabela         TEXT,
        \tsUsuario        TEXT,
        \tiLogsAcessa     INTEGER,
        \tiInstit         INTEGER,
        \tsCampo          TEXT,
        \tsValorAntigo    TEXT,
        \tsValorNovo      TEXT
        ) RETURNS SETOF configuracoes.tp_auditoria_consulta_mudancas AS
        \$\$
        DECLARE
        \trRetorno\t\tconfiguracoes.tp_auditoria_consulta_mudancas;
        \trAuditoria\t\tRECORD;
        
        \trCursorRetorno\tREFCURSOR;
        
        \tiQtdMudancas\tINTEGER;
        \tiMudanca\t\tINTEGER;
        
        \tsSQL\t\t\tTEXT;
        \tsConector\t\tTEXT DEFAULT 'OR';
        \tsConexaoRemota\tTEXT;
        \tsBaseAuditoria\tTEXT DEFAULT current_database()||'_auditoria';
        
        \ttInicioAno\t\t\t\tTIMESTAMPTZ;
        \tlExisteBaseAuditoria\tBOOLEAN;
        BEGIN
        \tlExisteBaseAuditoria := EXISTS (SELECT 1 FROM pg_database WHERE datname = sBaseAuditoria);
        
        \tsSQL := E'SELECT *, (select string_agg(coalesce((chave).nome_campo[id], \\'NULL\\') || \\'=\\' || coalesce((chave).valor[id], \\'NULL\\'), \\'\\n\\') from generate_series(1, array_upper((chave).nome_campo, 1)) as id) as chave_text   FROM configuracoes.db_auditoria ';
        \tsSQL := sSQL || ' WHERE datahora_servidor BETWEEN '||quote_literal(tDataHoraInicio::TEXT)||'::TIMESTAMPTZ AND '||quote_literal(tDataHoraFim::TEXT)||'::TIMESTAMPTZ';
        \tsSQL := sSQL || '   AND instit  = '||iInstit::TEXT;
        
        \tIF sEsquema IS NOT NULL THEN
        \t\tsSQL := sSQL || '   AND esquema = '||quote_literal(sEsquema);
        \tEND IF;
        
        \tIF sTabela IS NOT NULL THEN
        \t\tsSQL := sSQL || '   AND tabela  = '||quote_literal(sTabela);
        \tEND IF;
        
        \tIF sUsuario IS NOT NULL THEN
        \t\tsSQL := sSQL || '   AND usuario  = '||quote_literal(sUsuario);
        \tEND IF;
        
        \tIF iLogsAcessa IS NOT NULL THEN
        \t\tsSQL := sSQL || '   AND logsacessa  = '||cast(iLogsAcessa as text);
        \tEND IF;
        
        \tIF sCampo IS NOT NULL AND (sValorAntigo IS NOT NULL OR sValorNovo IS NOT NULL) THEN
        \t\tsSQL := sSQL || '   AND (((mudancas).nome_campo    @> ARRAY['||quote_literal(sCampo)||'] ';
        \t\tsSQL := sSQL || '    OR   (chave).nome_campo       @> ARRAY['||quote_literal(sCampo)||']) ';
        
        \t\tIF sValorAntigo IS NULL AND sValorNovo IS NOT NULL THEN
        \t\t\tsSQL := sSQL || '   AND ((mudancas).valor_novo @> ARRAY['||quote_literal(sValorNovo)||'] AND ';
        \t\t\tsSQL := sSQL || '        ((mudancas).valor_novo)[array_position('||quote_literal(sCampo)||'::text, (mudancas).nome_campo)] = '||quote_literal(sValorNovo)||') ';
        \t\t\tsSQL := sSQL || '    OR ((chave).valor @> ARRAY['||quote_literal(sValorNovo)||'])) ';
        \t\tELSIF sValorAntigo IS NOT NULL AND sValorNovo IS NULL THEN
        \t\t\tsSQL := sSQL || '   AND ((mudancas).valor_antigo @> ARRAY['||quote_literal(sValorAntigo)||'] AND ';
        \t\t\tsSQL := sSQL || '        ((mudancas).valor_antigo)[array_position('||quote_literal(sCampo)||'::text, (mudancas).nome_campo)] = '||quote_literal(sValorAntigo)||') ';
        \t\t\tsSQL := sSQL || '    OR ((chave).valor @> ARRAY['||quote_literal(sValorAntigo)||'])) ';
        \t\tELSE
        \t\t\tsSQL := sSQL || '   AND (((mudancas).valor_antigo @> ARRAY['||quote_literal(sValorAntigo)||'] OR ';
        \t\t\tsSQL := sSQL || '         (mudancas).valor_novo   @> ARRAY['||quote_literal(sValorNovo)||']) AND ';
        \t\t\tsSQL := sSQL || '        (((mudancas).valor_antigo)[array_position('||quote_literal(sCampo)||'::text, (mudancas).nome_campo)] = '||quote_literal(sValorAntigo)||' OR ';
        \t\t\tsSQL := sSQL || '         ((mudancas).valor_novo)[array_position('||quote_literal(sCampo)||'::text, (mudancas).nome_campo)] = '||quote_literal(sValorNovo)||'))';
        \t\t\tsSQL := sSQL || '    OR ((chave).valor @> ARRAY['||quote_literal(sValorAntigo)||'] OR (chave).valor @> ARRAY['||quote_literal(sValorNovo)||'])) ';
        \t\tEND IF;
        \tEND IF;
        
        \ttInicioAno := (extract(year from current_date)||'-01-01 00:00:00.00000')::timestamptz;
        
        \t-- SE a Data/Hora de inicio for menor que o Inicio do Ano Corrente
        \t-- E  a base de auditoria EXISTIR, entao executa a query na base de auditoria
        \tIF tDataHoraInicio < tInicioAno AND lExisteBaseAuditoria IS TRUE AND EXISTS (SELECT 1 FROM pg_extension WHERE extname = 'dblink') THEN
        \t\tsConexaoRemota := 'auditoria';
        \t\tIF array_position(sConexaoRemota, dblink_get_connections()) IS NULL THEN
        \t\t\tPERFORM dblink_connect(sConexaoRemota, 'dbname='||sBaseAuditoria);
        \t\tELSE
        \t\t\tPERFORM dblink_exec(sConexaoRemota, 'DISCARD ALL');
        \t\tEND IF;
        \t\tPERFORM dblink_open(sConexaoRemota, 'log', sSQL);
        
        \t\tLOOP
        \t\t\tSELECT\t*
        \t\t\tINTO\trAuditoria
        \t\t\tFROM\tdblink_fetch(sConexaoRemota, 'log', 1)
        \t\t\t\t\tAS (sequencial         integer,
        \t\t\t\t\t\tesquema            text,
        \t\t\t\t\t\ttabela             text,
        \t\t\t\t\t\toperacao           dm_operacao_tabela,
        \t\t\t\t\t\ttransacao          bigint,
        \t\t\t\t\t\tdatahora_sessao    timestamp with time zone,
        \t\t\t\t\t\tdatahora_servidor  timestamp with time zone,
        \t\t\t\t\t\ttempo              interval,
        \t\t\t\t\t\tusuario            character varying(20),
        \t\t\t\t\t\tchave              tp_auditoria_chave_primaria,
        \t\t\t\t\t\tmudancas           tp_auditoria_mudancas_campo,
        \t\t\t\t\t\tlogsacessa         integer,
        \t\t\t\t\t\tinstit             integer,
        \t\t\t\t\t\tchave_text         text);
        \t\t\tIF NOT FOUND THEN
        \t\t\t\tEXIT;
        \t\t\tEND IF;
        
        \t\t\trRetorno.esquema           := rAuditoria.esquema;
        \t\t\trRetorno.tabela            := rAuditoria.tabela;
        \t\t\trRetorno.comentario_tabela := fc_comentario_tabela(rAuditoria.esquema, rAuditoria.tabela);
        \t\t\trRetorno.operacao          := rAuditoria.operacao;
        \t\t\trRetorno.chave             := rAuditoria.chave_text;
        \t\t\trRetorno.transacao         := rAuditoria.transacao;
        \t\t\trRetorno.datahora_sessao   := rAuditoria.datahora_sessao;
        \t\t\trRetorno.datahora_servidor := rAuditoria.datahora_servidor;
        \t\t\trRetorno.usuario           := rAuditoria.usuario;
        \t\t\trRetorno.logsacessa        := rAuditoria.logsacessa;
        \t\t\trRetorno.instit            := rAuditoria.instit;
        
        \t\t\tiQtdMudancas := ARRAY_UPPER((rAuditoria.mudancas).nome_campo, 1);
        
        \t\t\tFOR iMudanca IN 1..iQtdMudancas
        \t\t\tLOOP
        \t\t\t\trRetorno.nome_campo       := (rAuditoria.mudancas).nome_campo[iMudanca];
        \t\t\t\trRetorno.comentario_campo := fc_comentario_campo(rAuditoria.esquema, rAuditoria.tabela, (rAuditoria.mudancas).nome_campo[iMudanca]);
        \t\t\t\trRetorno.valor_antigo     := (rAuditoria.mudancas).valor_antigo[iMudanca];
        \t\t\t\trRetorno.valor_novo       := (rAuditoria.mudancas).valor_novo[iMudanca];
        
        \t\t\t\tRETURN NEXT rRetorno;
        \t\t\tEND LOOP;
        
        \t\tEND LOOP;
        
        \t\tPERFORM dblink_close(sConexaoRemota, 'log');
        \tEND IF;
        
        \t-- SE o ano da Data/Hora de inicio for igual ao ano da Data/Hora corrente
        \t-- OU a base de auditoria NAO EXISTIR, entao executa a query na base corrente
        \tIF extract(year from tDataHoraInicio) = extract(year from current_date) OR lExisteBaseAuditoria IS FALSE THEN
        
        \t\tOPEN rCursorRetorno FOR EXECUTE sSQL;
        
        \t\tLOOP
        \t\t\tFETCH rCursorRetorno INTO rAuditoria;
        \t\t\tIF NOT FOUND THEN
        \t\t\t\tEXIT;
        \t\t\tEND IF;
        
        \t\t\trRetorno.esquema           := rAuditoria.esquema;
        \t\t\trRetorno.tabela            := rAuditoria.tabela;
        \t\t\trRetorno.comentario_tabela := fc_comentario_tabela(rAuditoria.esquema, rAuditoria.tabela);
        \t\t\trRetorno.operacao          := rAuditoria.operacao;
        \t\t\trRetorno.chave             := rAuditoria.chave_text;
        \t\t\trRetorno.transacao         := rAuditoria.transacao;
        \t\t\trRetorno.datahora_sessao   := rAuditoria.datahora_sessao;
        \t\t\trRetorno.datahora_servidor := rAuditoria.datahora_servidor;
        \t\t\trRetorno.usuario           := rAuditoria.usuario;
        \t\t\trRetorno.logsacessa        := rAuditoria.logsacessa;
        \t\t\trRetorno.instit            := rAuditoria.instit;
        
        \t\t\tiQtdMudancas := ARRAY_UPPER((rAuditoria.mudancas).nome_campo, 1);
        
        \t\t\tFOR iMudanca IN 1..iQtdMudancas
        \t\t\tLOOP
        \t\t\t\trRetorno.nome_campo       := (rAuditoria.mudancas).nome_campo[iMudanca];
        \t\t\t\trRetorno.comentario_campo := fc_comentario_campo(rAuditoria.esquema, rAuditoria.tabela, (rAuditoria.mudancas).nome_campo[iMudanca]);
        \t\t\t\trRetorno.valor_antigo     := (rAuditoria.mudancas).valor_antigo[iMudanca];
        \t\t\t\trRetorno.valor_novo       := (rAuditoria.mudancas).valor_novo[iMudanca];
        
        \t\t\t\tRETURN NEXT rRetorno;
        \t\t\tEND LOOP;
        
        \t\tEND LOOP;
        
        \t\tCLOSE rCursorRetorno;
        \tEND IF;
        
        \tRETURN;
        END;
        \$\$
        LANGUAGE plpgsql;
        
        CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_consulta_mudancas(
          tDataHoraInicio TIMESTAMP,
          tDataHoraFim    TIMESTAMP,
          sEsquema        TEXT,
          sTabela         TEXT,
          sUsuario        TEXT,
          iLogsAcessa     INTEGER,
          iInstit         INTEGER
        ) RETURNS SETOF configuracoes.tp_auditoria_consulta_mudancas AS
        \$\$
          SELECT *
            FROM configuracoes.fc_auditoria_consulta_mudancas(\$1, \$2, \$3, \$4, \$5, \$6, \$7, NULL, NULL, NULL);
        \$\$
        LANGUAGE sql;
        
        
        CREATE OR REPLACE FUNCTION configuracoes.fc_logsacessa_consulta(
        \ttDataHoraInicio TIMESTAMP,
        \ttDataHoraFim    TIMESTAMP,
        \tiInstit         INTEGER,
        \tsWhere          TEXT
        ) RETURNS SETOF configuracoes.db_logsacessa AS
        \$\$
        DECLARE
        \trRetorno\t\tconfiguracoes.db_logsacessa;
        
        \trCursorRetorno\tREFCURSOR;
        
        \tiQtdMudancas\tINTEGER;
        \tiMudanca\t\tINTEGER;
        
        \tsSQL\t\t\tTEXT;
        \tsConexaoRemota\tTEXT;
        \tsBaseAuditoria\tTEXT DEFAULT current_database()||'_auditoria';
        
        \ttInicioAno\t\t\t\tTIMESTAMPTZ;
        \tlExisteBaseAuditoria\tBOOLEAN;
        BEGIN
        \tlExisteBaseAuditoria := EXISTS (SELECT 1 FROM pg_database WHERE datname = sBaseAuditoria);
        
        \tsSQL := E'SELECT * FROM configuracoes.db_logsacessa';
        \tsSQL := sSQL || ' WHERE data BETWEEN '||quote_literal(tDataHoraInicio::DATE::TEXT)||'::DATE AND '||quote_literal(tDataHoraFim::DATE::TEXT)||'::DATE';
        \tsSQL := sSQL || '   AND instit  = '||iInstit::TEXT;
        \tsSQL := sSQL || COALESCE(' AND '||sWhere, '');
        
        \ttInicioAno := (extract(year from current_date)||'-01-01 00:00:00.00000')::timestamptz;
        
        \t-- SE a Data/Hora de inicio for menor que o Inicio do Ano Corrente
        \t-- E  a base de auditoria EXISTIR, entao executa a query na base de auditoria
        \tIF tDataHoraInicio < tInicioAno AND lExisteBaseAuditoria IS TRUE AND EXISTS (SELECT 1 FROM pg_extension WHERE extname = 'dblink') THEN
        \t\tsConexaoRemota := 'auditoria';
        \t\tIF array_position(sConexaoRemota, dblink_get_connections()) IS NULL THEN
        \t\t\tPERFORM dblink_connect(sConexaoRemota, 'dbname='||sBaseAuditoria);
        \t\tELSE
        \t\t\tPERFORM dblink_exec(sConexaoRemota, 'DISCARD ALL');
        \t\tEND IF;
        \t\tPERFORM dblink_open(sConexaoRemota, 'log', sSQL);
        
        \t\tLOOP
        \t\t\tSELECT\t*
        \t\t\tINTO\trRetorno
        \t\t\tFROM\tdblink_fetch(sConexaoRemota, 'log', 1)
        \t\t\t\t\tAS (codsequen   integer,
        \t\t\t\t\t\tip          character varying(50),
        \t\t\t\t\t\tdata        date,
        \t\t\t\t\t\thora        character varying(10),
        \t\t\t\t\t\tarquivo     text,
        \t\t\t\t\t\tobs         text,
        \t\t\t\t\t\tid_usuario  integer,
        \t\t\t\t\t\tid_modulo   integer,
        \t\t\t\t\t\tid_item     integer,
        \t\t\t\t\t\tcoddepto    integer,
        \t\t\t\t\t\tinstit      integer,
        \t\t\t\t\t\tauditoria   boolean);
        
        \t\t\tIF NOT FOUND THEN
        \t\t\t\tEXIT;
        \t\t\tEND IF;
        
        \t\t\tRETURN NEXT rRetorno;
        \t\tEND LOOP;
        
        \t\tPERFORM dblink_close(sConexaoRemota, 'log');
        \tEND IF;
        
        \t-- SE o ano da Data/Hora de inicio for igual ao ano da Data/Hora corrente
        \t-- OU a base de auditoria NAO EXISTIR, entao executa a query na base corrente
        \t--IF extract(year from tDataHoraInicio) = extract(year from current_date) OR lExisteBaseAuditoria IS FALSE THEN
        
        \t\tOPEN rCursorRetorno FOR EXECUTE sSQL;
        
        \t\tLOOP
        \t\t\tFETCH rCursorRetorno INTO rRetorno;
        \t\t\tIF NOT FOUND THEN
        \t\t\t\tEXIT;
        \t\t\tEND IF;
        
        \t\t\tRETURN NEXT rRetorno;
        \t\tEND LOOP;
        
        \t\tCLOSE rCursorRetorno;
        \t--END IF;
        
        \tRETURN;
        END;
        \$\$
        LANGUAGE plpgsql;
        
        SQL_WRAP;
        $this->execute($sql);
    }

    public function down()
    {
        $sql = <<<SQL
        DROP TYPE IF EXISTS configuracoes.tp_auditoria_consulta_mudancas CASCADE;
SQL;
        $this->execute($sql);
    }
}
