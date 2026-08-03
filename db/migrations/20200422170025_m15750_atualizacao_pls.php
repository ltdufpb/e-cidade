<?php

use Classes\PostgresMigration;

class M15750AtualizacaoPls extends PostgresMigration
{

    public function up()
    {
        $this->execute("ALTER TABLE db_auditoria ADD COLUMN gatilho BOOLEAN;");
        $this->auditoriaParticiona();
        $this->auditoriaTemplate();
    }

    public function down()
    {
        $this->execute("ALTER TABLE db_auditoria DROP COLUMN gatilho;");
        $this->downAuditoriaParticiona();
        $this->downAuditoriaTemplate();
    }

    private function auditoriaParticiona()
    {
         $this->execute(<<<SQL_WRAP
         CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_particiona_inc() RETURNS trigger AS
         \$\$
         DECLARE
         \tsEsquema TEXT;
         \tsTabela  TEXT;
         
         \tsEsquemaParticao TEXT;
         \tsTabelaParticao  TEXT;
         
         \tsDataIni    TEXT;
         \tsDataFim    TEXT;
         \tiAno        INTEGER;
         \tiMes        INTEGER;
         
         \tsSQL        TEXT;
         BEGIN
         
         \tsEsquema := TG_TABLE_SCHEMA;
         \tsTabela  := TG_TABLE_NAME;
         \tiAno     := extract(year  from NEW.datahora_servidor);
         \tiMes     := extract(month from NEW.datahora_servidor);
         
         \tsEsquemaParticao := COALESCE(fc_getsession('db_esquema_auditoria_particao'), sEsquema);
         \tsTabelaParticao  := sTabela || '_' ||
             to_char(iAno, 'FM0000') ||
             to_char(iMes, 'FM00') || '_' ||
             NEW.instit::TEXT;
         
         \tsSQL := FORMAT('INSERT INTO %I.%I ('
                 || ' sequencial, '
                 || ' esquema, '
                 || ' tabela, '
                 || ' operacao, '
                 || ' datahora_sessao, '
                 || ' datahora_servidor, '
                 || ' tempo, '
                 || ' usuario, '
                 || ' chave, '
                 || ' mudancas, '
                 || ' logsacessa, '
                 || ' instit, '
                 || ' gatilho '
                 || ') VALUES ( '
                 || '\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8, \$9, \$10, \$11, \$12, \$13)', sEsquemaParticao, sTabelaParticao);
         
         \tIF NEW.sequencial IS NULL THEN
         \t\t-- Usar sequence do acount para compatibilidade
         \t\tNEW.sequencial := NEXTVAL('db_acount_id_acount_seq');
         \tEND IF;
         
         \t<<loop_insere_auditoria>>
         \tLOOP
         \t\tBEGIN
         \t\t\tEXECUTE\tsSQL
         \t\t\tUSING\tNEW.sequencial, NEW.esquema, NEW.tabela, NEW.operacao, NEW.datahora_sessao, NEW.datahora_servidor,
         \t\t\t\t\t(clock_timestamp() - COALESCE(CAST(fc_getsession('clock_timestamp') AS TIMESTAMP WITH TIME ZONE), NOW())),
         \t\t\t\t\tNEW.usuario, NEW.chave, NEW.mudancas, NEW.logsacessa, NEW.instit, NEW.gatilho;
         
         \t\t\tEXIT loop_insere_auditoria;
         \t\tEXCEPTION
         \t\t\tWHEN undefined_table THEN
         \t\t\t\tsDataIni := iAno::TEXT || '-' || iMes::TEXT || '-01 00:00:00.000000';
         \t\t\t\tsDataFim := iAno::TEXT || '-' || iMes::TEXT || '-' || fc_ultimodiames(iAno, iMes)::TEXT || ' 23:59:59.999999';
         
         \t\t\t\tPERFORM configuracoes.fc_auditoria_particao_cria (
                 sEsquema,
                 sTabela,
                 sEsquemaParticao,
                 sTabelaParticao,
                 'datahora_servidor BETWEEN '||quote_literal(sDataIni)||' AND '||quote_literal(sDataFim)|| ' AND instit = ' || NEW.instit::TEXT
             );
         \t\tEND;
         \tEND LOOP;
         
         \tRETURN NULL;
         END;
         \$\$
         LANGUAGE plpgsql;
         SQL_WRAP
);
    }

    private function downAuditoriaParticiona()
    {
        $this->execute(<<<SQL_WRAP
        CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_particiona_inc() RETURNS trigger AS
        \$\$
        DECLARE
        \tsEsquema TEXT;
        \tsTabela  TEXT;
        
        \tsEsquemaParticao TEXT;
        \tsTabelaParticao  TEXT;
        
        \tsDataIni    TEXT;
        \tsDataFim    TEXT;
        \tiAno        INTEGER;
        \tiMes        INTEGER;
        
        \tsSQL        TEXT;
        BEGIN
        
        \tsEsquema := TG_TABLE_SCHEMA;
        \tsTabela  := TG_TABLE_NAME;
        \tiAno     := extract(year  from NEW.datahora_servidor);
        \tiMes     := extract(month from NEW.datahora_servidor);
        
        \tsEsquemaParticao := COALESCE(fc_getsession('db_esquema_auditoria_particao'), sEsquema);
        \tsTabelaParticao  := sTabela || '_' ||
        \t\tto_char(iAno, 'FM0000') ||
        \t\tto_char(iMes, 'FM00') || '_' ||
        \t\tNEW.instit::TEXT;
        
        \tsSQL := FORMAT('INSERT INTO %I.%I ('
        \t\t|| ' sequencial, '
        \t\t|| ' esquema, '
        \t\t|| ' tabela, '
        \t\t|| ' operacao, '
        \t\t|| ' datahora_sessao, '
        \t\t|| ' datahora_servidor, '
        \t\t|| ' tempo, '
        \t\t|| ' usuario, '
        \t\t|| ' chave, '
        \t\t|| ' mudancas, '
        \t\t|| ' logsacessa, '
        \t\t|| ' instit '
        \t\t|| ') VALUES ( '
        \t\t|| '\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8, \$9, \$10, \$11, \$12)', sEsquemaParticao, sTabelaParticao);
        
        \tIF NEW.sequencial IS NULL THEN
        \t\tNEW.sequencial := NEXTVAL('db_acount_id_acount_seq');
        \tEND IF;
        
        \t<<loop_insere_auditoria>>
        \tLOOP
        \t\tBEGIN
        \t\t\tEXECUTE\tsSQL
        \t\t\tUSING\tNEW.sequencial, NEW.esquema, NEW.tabela, NEW.operacao, NEW.datahora_sessao, NEW.datahora_servidor,
        \t\t\t\t\t(clock_timestamp() - COALESCE(CAST(fc_getsession('clock_timestamp') AS TIMESTAMP WITH TIME ZONE), NOW())),
        \t\t\t\t\tNEW.usuario, NEW.chave, NEW.mudancas, NEW.logsacessa, NEW.instit;
        
        \t\t\tEXIT loop_insere_auditoria;
        \t\tEXCEPTION
        \t\t\tWHEN undefined_table THEN
        \t\t\t\tsDataIni := iAno::TEXT || '-' || iMes::TEXT || '-01 00:00:00.000000';
        \t\t\t\tsDataFim := iAno::TEXT || '-' || iMes::TEXT || '-' || fc_ultimodiames(iAno, iMes)::TEXT || ' 23:59:59.999999';
        
        \t\t\t\tPERFORM configuracoes.fc_auditoria_particao_cria (
        \t\t\t\t\tsEsquema,
        \t\t\t\t\tsTabela,
        \t\t\t\t\tsEsquemaParticao,
        \t\t\t\t\tsTabelaParticao,
        \t\t\t\t\t'datahora_servidor BETWEEN '||quote_literal(sDataIni)||' AND '||quote_literal(sDataFim)|| ' AND instit = ' || NEW.instit::TEXT
        \t\t\t\t);
        \t\tEND;
        \tEND LOOP;
        
        \tRETURN NULL;
        END;
        \$\$
        LANGUAGE plpgsql;
        SQL_WRAP
        );
    }

    private function auditoriaTemplate()
    {
        $this->execute(<<<SQLX

CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_template() RETURNS TEXT AS
$$
	SELECT \$SQL$
CREATE OR REPLACE FUNCTION {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}() RETURNS trigger AS
\$AUDITORIA$

DECLARE
	xMudancas configuracoes.tp_auditoria_mudancas_campo;
	xChave    configuracoes.tp_auditoria_chave_primaria;

	tDataHora   TIMESTAMP   DEFAULT COALESCE(fc_getsession('DB_datausu')::TIMESTAMP, NOW());
	sLogin      VARCHAR(20) DEFAULT COALESCE(fc_getsession('DB_login'), 'dbseller');
	iLogsAcessa INTEGER     DEFAULT fc_getsession('DB_acessado')::INTEGER;
	iInstit     INTEGER     DEFAULT fc_getsession('DB_instit')::INTEGER;
	iUsuario    INTEGER     DEFAULT COALESCE(fc_getsession('DB_id_usuario')::INTEGER, 1);
	dData       DATE        DEFAULT tDataHora::DATE;

	rRegistro   {%tpl_tabela_esquema}.{%tpl_tabela_nome}%ROWTYPE;
	rLogsAcessa RECORD;

	aCampo      TEXT[];
	aValorOld   TEXT[];
	aValorNew   TEXT[];
BEGIN
	IF TG_OP = 'DELETE' THEN
		rRegistro := OLD;
	ELSE
		rRegistro := NEW;
	END IF;

	IF iInstit IS NULL THEN
		SELECT	codigo
		INTO	iInstit
		FROM	db_config
		WHERE	prefeitura IS TRUE
		ORDER	BY codigo
		LIMIT	1;

		IF iInstit IS NULL THEN
			SELECT	codigo
			INTO	iInstit
			FROM	db_config
			ORDER	BY codigo
			LIMIT	1;
			IF iInstit IS NULL THEN
				RAISE EXCEPTION 'Impossível realizar auditoria. Nenhuma instituição encontrada nesta base de dados!';
			END IF;
		END IF;
	END IF;

	IF iLogsAcessa IS NULL THEN
		BEGIN
			EXECUTE	format('
				SELECT	codsequen
				FROM	db_logsacessa_%s_%s
				WHERE	instit  = %L
				AND		data    = %L
				AND		hora    = %L
				AND		arquivo = %L',
				to_char(tDataHora, 'FMYYYYMM'), iInstit, iInstit, dData,
				to_char(tDataHora, 'HH24:MI:SS'), 'classes/db_{%tpl_tabela_nome}_classe.php')
			INTO	iLogsAcessa;
		EXCEPTION
			WHEN undefined_table THEN
				iLogsAcessa := NULL;
		END;

		IF iLogsAcessa IS NULL THEN
			SELECT	b.codmod, c.id_item
			INTO	rLogsAcessa
			FROM	db_sysarquivo a
					JOIN db_sysarqmod b ON b.codarq = a.codarq
					JOIN db_auditoria_migracao_depara_codarq_codmod_id_modulo c ON c.codarq = b.codarq AND c.codmod = b.codmod
			WHERE	nomearq = '{%tpl_tabela_nome}';

			INSERT INTO db_logsacessa (
				codsequen, data, hora, arquivo, obs, instit, auditoria, id_usuario, id_modulo, id_item
			) VALUES (
				NEXTVAL('db_logsacessa_codsequen_seq'), dData,
				to_char(tDataHora, 'HH24:MI:SS'), 'classes/db_{%tpl_tabela_nome}_classe.php',
				'LogsAcessa Automatico DML Manual', iInstit, TRUE,
				iUsuario, rLogsAcessa.codmod, rLogsAcessa.id_item
			);

			iLogsAcessa = CURRVAL('db_logsacessa_codsequen_seq');

			PERFORM fc_putsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__', 't');
		END IF;
	END IF;

	{%tpl_bloco_codigo_definicao_chave}

	IF TG_OP = 'INSERT' THEN

		xMudancas := ROW(
			ARRAY[ {%tpl_array_campo_nome} ],
			ARRAY[ {%tpl_array_insert_campo_valor_old} ],
			ARRAY[ {%tpl_array_insert_campo_valor_new} ] );

	ELSIF TG_OP = 'UPDATE' THEN

		IF ROW(OLD.*) IS DISTINCT FROM ROW(NEW.*) THEN

			{%tpl_bloco_codigo_update}

		ELSE
			RETURN rRegistro;
		END IF;

		xMudancas := ROW(aCampo, aValorOld, aValorNew);
	ELSE

		xMudancas := ROW(
			ARRAY[ {%tpl_array_campo_nome} ],
			ARRAY[ {%tpl_array_delete_campo_valor_old} ],
			ARRAY[ {%tpl_array_delete_campo_valor_new} ] );

	END IF;

	INSERT INTO db_auditoria (
		sequencial,
		esquema,
		tabela,
		operacao,
		datahora_sessao,
		usuario,
		chave,
		mudancas,
		logsacessa,
		instit,
		gatilho
	) VALUES (
		NEXTVAL('db_acount_id_acount_seq'),
		TG_TABLE_SCHEMA,
		TG_TABLE_NAME,
		SUBSTR(TG_OP,1,1),
		tDataHora,
		sLogin,
		xChave,
		xMudancas,
		iLogsAcessa,
		iInstit,
		TRUE
	);

	IF fc_getsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__') IS NULL THEN
		UPDATE	db_logsacessa
		SET		auditoria = TRUE
		WHERE	instit    = iInstit
		AND		data      = dData
		AND		codsequen = iLogsAcessa
		AND		auditoria IS FALSE;

		PERFORM fc_putsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__', 't');
	END IF;

	RETURN rRegistro;
END;
\$AUDITORIA$
SECURITY DEFINER
LANGUAGE plpgsql;

CREATE TRIGGER tg_auditoria_insert_delete_{%tpl_tabela_oid}
	AFTER INSERT OR DELETE ON {%tpl_tabela_esquema}.{%tpl_tabela_nome}
	FOR EACH ROW
		WHEN	(fc_getsession('__disable_audit__') IS NULL
		AND		 fc_getsession('__disable_audit_{%tpl_tabela_esquema}_{%tpl_tabela_nome}__') IS NULL)
	EXECUTE PROCEDURE {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}();

CREATE TRIGGER tg_auditoria_update_{%tpl_tabela_oid}
	AFTER UPDATE ON {%tpl_tabela_esquema}.{%tpl_tabela_nome}
	FOR EACH ROW
		WHEN	(NEW.* IS DISTINCT FROM OLD.*
		AND		 fc_getsession('__disable_audit__') IS NULL
		AND		 fc_getsession('__disable_audit_{%tpl_tabela_esquema}_{%tpl_tabela_nome}__') IS NULL)
	EXECUTE PROCEDURE {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}();

\$SQL$::TEXT;

$$
LANGUAGE sql;

SQLX
        );
    }
    private function downAuditoriaTemplate()
    {
        $this->execute(<<<SQL_WRAP
        
        CREATE OR REPLACE FUNCTION configuracoes.fc_auditoria_template() RETURNS TEXT AS
        \$\$
        \tSELECT \$SQL\$
        CREATE OR REPLACE FUNCTION {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}() RETURNS trigger AS
        \$AUDITORIA\$
        
        DECLARE
        \txMudancas configuracoes.tp_auditoria_mudancas_campo;
        \txChave    configuracoes.tp_auditoria_chave_primaria;
        
        \ttDataHora   TIMESTAMP   DEFAULT COALESCE(fc_getsession('DB_datausu')::TIMESTAMP, NOW());
        \tsLogin      VARCHAR(20) DEFAULT COALESCE(fc_getsession('DB_login'), 'dbseller');
        \tiLogsAcessa INTEGER     DEFAULT fc_getsession('DB_acessado')::INTEGER;
        \tiInstit     INTEGER     DEFAULT fc_getsession('DB_instit')::INTEGER;
        \tiUsuario    INTEGER     DEFAULT COALESCE(fc_getsession('DB_id_usuario')::INTEGER, 1);
        \tdData       DATE        DEFAULT tDataHora::DATE;
        
        \trRegistro   {%tpl_tabela_esquema}.{%tpl_tabela_nome}%ROWTYPE;
        \trLogsAcessa RECORD;
        
        \taCampo      TEXT[];
        \taValorOld   TEXT[];
        \taValorNew   TEXT[];
        BEGIN
        \tIF TG_OP = 'DELETE' THEN
        \t\trRegistro := OLD;
        \tELSE
        \t\trRegistro := NEW;
        \tEND IF;
        
        \tIF iInstit IS NULL THEN
        \t\tSELECT\tcodigo
        \t\tINTO\tiInstit
        \t\tFROM\tdb_config
        \t\tWHERE\tprefeitura IS TRUE
        \t\tORDER\tBY codigo
        \t\tLIMIT\t1;
        
        \t\tIF iInstit IS NULL THEN
        \t\t\tSELECT\tcodigo
        \t\t\tINTO\tiInstit
        \t\t\tFROM\tdb_config
        \t\t\tORDER\tBY codigo
        \t\t\tLIMIT\t1;
        \t\t\tIF iInstit IS NULL THEN
        \t\t\t\tRAISE EXCEPTION 'Imposs\xedvel realizar auditoria. Nenhuma institui\xe7\xe3o encontrada nesta base de dados!';
        \t\t\tEND IF;
        \t\tEND IF;
        \tEND IF;
        
        \tIF iLogsAcessa IS NULL THEN
        \t\tBEGIN
        \t\t\tEXECUTE\tformat('
        \t\t\t\tSELECT\tcodsequen
        \t\t\t\tFROM\tdb_logsacessa_%s_%s
        \t\t\t\tWHERE\tinstit  = %L
        \t\t\t\tAND\t\tdata    = %L
        \t\t\t\tAND\t\thora    = %L
        \t\t\t\tAND\t\tarquivo = %L',
        \t\t\t\tto_char(tDataHora, 'FMYYYYMM'), iInstit, iInstit, dData,
        \t\t\t\tto_char(tDataHora, 'HH24:MI:SS'), 'classes/db_{%tpl_tabela_nome}_classe.php')
        \t\t\tINTO\tiLogsAcessa;
        \t\tEXCEPTION
        \t\t\tWHEN undefined_table THEN
        \t\t\t\tiLogsAcessa := NULL;
        \t\tEND;
        
        \t\tIF iLogsAcessa IS NULL THEN
        \t\t\tSELECT\tb.codmod, c.id_item
        \t\t\tINTO\trLogsAcessa
        \t\t\tFROM\tdb_sysarquivo a
        \t\t\t\t\tJOIN db_sysarqmod b ON b.codarq = a.codarq
        \t\t\t\t\tJOIN db_auditoria_migracao_depara_codarq_codmod_id_modulo c ON c.codarq = b.codarq AND c.codmod = b.codmod
        \t\t\tWHERE\tnomearq = '{%tpl_tabela_nome}';
        
        \t\t\tINSERT INTO db_logsacessa (
        \t\t\t\tcodsequen, data, hora, arquivo, obs, instit, auditoria, id_usuario, id_modulo, id_item
        \t\t\t) VALUES (
        \t\t\t\tNEXTVAL('db_logsacessa_codsequen_seq'), dData,
        \t\t\t\tto_char(tDataHora, 'HH24:MI:SS'), 'classes/db_{%tpl_tabela_nome}_classe.php',
        \t\t\t\t'LogsAcessa Automatico DML Manual', iInstit, TRUE,
        \t\t\t\tiUsuario, rLogsAcessa.codmod, rLogsAcessa.id_item
        \t\t\t);
        
        \t\t\tiLogsAcessa = CURRVAL('db_logsacessa_codsequen_seq');
        
        \t\t\tPERFORM fc_putsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__', 't');
        \t\tEND IF;
        \tEND IF;
        
        \t{%tpl_bloco_codigo_definicao_chave}
        
        \tIF TG_OP = 'INSERT' THEN
        
        \t\txMudancas := ROW(
        \t\t\tARRAY[ {%tpl_array_campo_nome} ],
        \t\t\tARRAY[ {%tpl_array_insert_campo_valor_old} ],
        \t\t\tARRAY[ {%tpl_array_insert_campo_valor_new} ] );
        
        \tELSIF TG_OP = 'UPDATE' THEN
        
        \t\tIF ROW(OLD.*) IS DISTINCT FROM ROW(NEW.*) THEN
        
        \t\t\t{%tpl_bloco_codigo_update}
        
        \t\tELSE
        \t\t\tRETURN rRegistro;
        \t\tEND IF;
        
        \t\txMudancas := ROW(aCampo, aValorOld, aValorNew);
        \tELSE
        
        \t\txMudancas := ROW(
        \t\t\tARRAY[ {%tpl_array_campo_nome} ],
        \t\t\tARRAY[ {%tpl_array_delete_campo_valor_old} ],
        \t\t\tARRAY[ {%tpl_array_delete_campo_valor_new} ] );
        
        \tEND IF;
        
        \tINSERT INTO db_auditoria (
        \t\tsequencial,
        \t\tesquema,
        \t\ttabela,
        \t\toperacao,
        \t\tdatahora_sessao,
        \t\tusuario,
        \t\tchave,
        \t\tmudancas,
        \t\tlogsacessa,
        \t\tinstit
        \t) VALUES (
        \t\tNEXTVAL('db_acount_id_acount_seq'),
        \t\tTG_TABLE_SCHEMA,
        \t\tTG_TABLE_NAME,
        \t\tSUBSTR(TG_OP,1,1),
        \t\ttDataHora,
        \t\tsLogin,
        \t\txChave,
        \t\txMudancas,
        \t\tiLogsAcessa,
        \t\tiInstit
        \t);
        
        \tIF fc_getsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__') IS NULL THEN
        \t\tUPDATE\tdb_logsacessa
        \t\tSET\t\tauditoria = TRUE
        \t\tWHERE\tinstit    = iInstit
        \t\tAND\t\tdata      = dData
        \t\tAND\t\tcodsequen = iLogsAcessa
        \t\tAND\t\tauditoria IS FALSE;
        
        \t\tPERFORM fc_putsession('__logsacessa_'||iLogsAcessa||'_auditoria_alterado__', 't');
        \tEND IF;
        
        \tRETURN rRegistro;
        END;
        \$AUDITORIA\$
        SECURITY DEFINER
        LANGUAGE plpgsql;
        
        CREATE TRIGGER tg_auditoria_insert_delete_{%tpl_tabela_oid}
        \tAFTER INSERT OR DELETE ON {%tpl_tabela_esquema}.{%tpl_tabela_nome}
        \tFOR EACH ROW
        \t\tWHEN\t(fc_getsession('__disable_audit__') IS NULL
        \t\tAND\t\t fc_getsession('__disable_audit_{%tpl_tabela_esquema}_{%tpl_tabela_nome}__') IS NULL)
        \tEXECUTE PROCEDURE {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}();
        
        CREATE TRIGGER tg_auditoria_update_{%tpl_tabela_oid}
        \tAFTER UPDATE ON {%tpl_tabela_esquema}.{%tpl_tabela_nome}
        \tFOR EACH ROW
        \t\tWHEN\t(NEW.* IS DISTINCT FROM OLD.*
        \t\tAND\t\t fc_getsession('__disable_audit__') IS NULL
        \t\tAND\t\t fc_getsession('__disable_audit_{%tpl_tabela_esquema}_{%tpl_tabela_nome}__') IS NULL)
        \tEXECUTE PROCEDURE {%tpl_tabela_esquema}.fc_auditoria_tabela_{%tpl_tabela_oid}();
        
        \$SQL\$::TEXT;
        
        \$\$
        LANGUAGE sql;
        
        SQL_WRAP
        );
    }
}
