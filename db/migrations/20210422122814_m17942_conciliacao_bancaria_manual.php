<?php

use Classes\PostgresMigration;

class M17942ConciliacaoBancariaManual extends PostgresMigration
{
  public function up()
  {

    $sql = <<<SQL_WRAP
    
          update db_itensmenu set libcliente = false where id_item = 2000365;
          update db_itensmenu set descricao = 'Concilia\xe7\xe3o Banc\xe1ria com carga de extrato',
                                  help = 'Concilia\xe7\xe3o Banc\xe1ria com carga de extrato',
                                  desctec = 'Concilia\xe7\xe3o Banc\xe1ria com carga de extrato'
          where id_item = 147883;
    
    
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228484 ,'Concilia\xe7\xe3o Banc\xe1ria sem carga de extrato', 'Concilia\xe7\xe3o Banc\xe1ria sem carga de extrato' ,'' ,'1' ,'1' ,'Concilia\xe7\xe3o Banc\xe1ria sem carga de extrato' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228485 ,'Implanta\xe7\xe3o de Concilia\xe7\xe3o por Conta' ,'Implanta\xe7\xe3o de Concilia\xe7\xe3o por Conta' ,'cai4_implantaconciliacao001.php' ,'1' ,'1' ,'Implanta\xe7\xe3o de Concilia\xe7\xe3o por Conta' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228486 ,'Abrir Pend\xeancias Antigas' ,'Abrir Pend\xeancias Antigas' ,'cai4_gerapendenciasant.php' ,'1' ,'1' ,'Abrir Pend\xeancias Antigas' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228487 ,'Manuten\xe7\xe3o de Concilia\xe7\xe3o' ,'Manuten\xe7\xe3o de Concilia\xe7\xe3o' ,'cai4_alteraconciliacao_manual.php' ,'1' ,'1' ,'Manuten\xe7\xe3o de Concilia\xe7\xe3o' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228488 ,'Relat\xf3rio da Concilia\xe7\xe3o Dia' ,'Relat\xf3rio da Concilia\xe7\xe3o Dia' ,'cai2_relconciliacaobancaria001_manual.php?dia=true' ,'1' ,'1' ,'Relat\xf3rio da Concilia\xe7\xe3o Dia' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228489 ,'Relat\xf3rio de Registros Conciliados' ,'Relat\xf3rio de Registros Conciliados' ,'cai2_relconciliacaodetalhes001.php' ,'1' ,'1' ,'Relat\xf3rio de Registros Conciliados' ,'true' );
          insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 228490 ,'Zera Concilia\xe7\xe3o por Dia' ,'Zera Concilia\xe7\xe3o por Dia' ,'cai1_conciliazeralog001_manual.php' ,'1' ,'1' ,'Zera Concilia\xe7\xe3o por Dia' ,'true' );
          INSERT INTO db_menu VALUES (32,228484, 4, 39);
          INSERT INTO db_menu VALUES (228484, 228485, 1, 39);
          INSERT INTO db_menu VALUES (228484, 228486, 2, 39);
          INSERT INTO db_menu VALUES (228484, 228487, 3, 39);
          INSERT INTO db_menu VALUES (228484, 228488, 4, 39);
          INSERT INTO db_menu VALUES (228484, 228489, 5, 39);
          INSERT INTO db_menu VALUES (228484, 228490, 6, 39);
    
    
    
    drop function fc_extratocaixa(integer,integer,date,date,boolean);
    drop   type tp_extratocaixa;
    create type tp_extratocaixa as ( riCaixa        integer,
                                     riAutent       integer,
                                     riData         date,
                                     rnValorDebito  numeric,
                                     riValorCredito numeric,
                                     riReceita      integer,
                                     riCheque       integer,
                                     rtCredor       varchar,
    \t\t\t\t\t\t\t\t riEmpenho      integer,
    \t\t\t\t\t\t\t\t riOrdem        integer,
    \t\t\t\t\t\t\t\t riPlanilha     integer,
    \t\t\t\t\t\t\t\t riSlip         integer,
                                     rtDetalhe      text,
                                     rbErro         boolean);
    
    create or replace function fc_extratocaixa(integer,integer,date,date,boolean) returns setof tp_extratocaixa as
    \$\$
    declare
    
        iInstit        alias for \$1;
        iConta         alias for \$2;
    \tdDataini       alias for \$3;
    \tdDatafim       alias for \$4;
        bRaise         alias for \$5;
    
    \tsV             varchar default '';
        sReduz         text    default '';
    \ttSql           text    default '';
        tWhereCorrente text    default ' where 1=1 ';
        tWhereCorlanc  text    default ' where 1=1 ';
    
        iAnoUsu        integer;
    
        rExtratoCaixa  record;
        rReduz         record;
    
        rtp_extratocaixa tp_extratocaixa%ROWTYPE;
    
    begin
    
    \t\tif bRaise then
    \t\t\traise notice ' Instit : % Conta : % Data : % ',iInstit,iConta,dDataini;
    \t\tend if;
    
        rtp_extratocaixa.riCaixa        := 0;
        rtp_extratocaixa.riAutent       := 0;
        rtp_extratocaixa.riData         := null;
        rtp_extratocaixa.rnValorDebito  := 0;
        rtp_extratocaixa.riValorCredito := 0;
        rtp_extratocaixa.riReceita      := 0;
        rtp_extratocaixa.riCheque       := 0;
        rtp_extratocaixa.rtCredor       := '';
    \trtp_extratocaixa.riEmpenho      := 0;
    \trtp_extratocaixa.riOrdem        := 0;
    \trtp_extratocaixa.riPlanilha     := 0;
    \trtp_extratocaixa.riSlip         := 0;
        rtp_extratocaixa.rtDetalhe      := '';
        rtp_extratocaixa.rbErro         := false;
    
        iAnoUsu := cast( (select fc_getsession('DB_anousu')) as integer);
    
        if iAnoUsu is null then
         raise exception 'ERRO : Variavel de sessao [DB_anousu] nao encontrada.';
        end if;
    
    \t\tif iConta is not null then
    
          for rReduz in select distinct c61_reduz
                          from contabancaria
                               inner join conplanocontabancaria on conplanocontabancaria.c56_contabancaria = contabancaria.db83_sequencial
                               inner join conplanoreduz         on conplanoreduz.c61_codcon = conplanocontabancaria.c56_codcon
                                                               and conplanoreduz.c61_anousu = conplanocontabancaria.c56_anousu
                                                               and conplanoreduz.c61_reduz = conplanocontabancaria.c56_reduz
                          where contabancaria.db83_sequencial = iConta
    
          loop
    
            sReduz := sReduz||sV||rReduz.c61_reduz;
            sV     := ',';
    
          end loop;
    
          if sReduz = null or sReduz = '' then
            return ;
          end if;
    
    \t\t  tWhereCorrente := tWhereCorrente|| ' and corrente.k12_conta in ('||sReduz||')';
    \t\t\ttWhereCorlanc  := tWhereCorlanc||  ' and corlanc.k12_conta  in ('||sReduz||')';
    
    \t\tend if;
    \t\tif iInstit is not null then
    \t\t  tWhereCorrente := tWhereCorrente|| ' and corrente.k12_instit = '||iInstit;
    \t\tend if;
    \t\tif dDataini is not null and dDatafim is not null then
    \t\t  tWhereCorrente := tWhereCorrente|| ' and corrente.k12_data between '||quote_literal(dDataini)||' and '||quote_literal(dDatafim);
    \t\t\ttWhereCorlanc  := tWhereCorlanc||  ' and corlanc.k12_data  between '||quote_literal(dDataini)||' and '||quote_literal(dDatafim);
    \t\telsif dDataini is not null and dDatafim is null then
    \t\t  tWhereCorrente := tWhereCorrente|| ' and corrente.k12_data >= '||quote_literal(dDataini);
    \t\t\ttWhereCorlanc  := tWhereCorlanc||  ' and corlanc.k12_data >= '||quote_literal(dDataini);
    \t\telsif dDatafim is not null and dDataini is null then
    \t\t  tWhereCorrente := tWhereCorrente|| ' and corrente.k12_data <= '||quote_literal(dDataini);
    \t\t\ttWhereCorlanc  := tWhereCorlanc||  ' and corlanc.k12_data <= '||quote_literal(dDataini);
    
    \t\tend if;
    
    \t--\tempenhos- despesa or\xe7amentaria
        tSql := '
    \t\tselect corrente.k12_id           as caixa,
    \t\t\t\t\t corrente.k12_data         as data,
    \t\t\t\t\t corrente.k12_autent       as autent,
    \t\t\t\t\t case
                 when corrente.k12_estorn is true
                   then
                     case
                       when corrente.k12_valor < 0
                         then corrente.k12_valor * -1
                       else corrente.k12_valor
                     end
                 else 0
               end as valor_debito,
               case
                 when corrente.k12_estorn is false
                   then corrente.k12_valor
                 else 0
               end as valor_credito,
    \t\t\t\t\t 0                         as receita,
    \t\t\t\t\t coremp.k12_cheque::text   as cheque,
    \t\t\t\t\t z01_nome::text            as credor,
    \t\t\t\t\t k12_empen                 as empenho,
    \t\t\t\t\t k12_codord                as ordem,
    \t\t\t\t\t 0                         as planilha,
    \t\t\t\t\t 0                         as slip,
    \t\t\t\t\t \\'OP-\\'||k12_codord||\\'#N\xfamero empenho-\\'||k12_empen||\\'#Historico-\\'||coalesce(e60_resumo,\\'\\')::text as detalhe
    \t\t\tfrom corrente
    \t\t\t\t\t inner join coremp     on coremp.k12_id = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand coremp.k12_data = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand coremp.k12_autent = corrente.k12_autent
    \t\t\t\t\t inner join empempenho on e60_numemp = coremp.k12_empen
    
    \t\t\t\t\t inner join cgm        on z01_numcgm = e60_numcgm
    \t\t\t\t\t left join corhist     on corhist.k12_id = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_data = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_autent = corrente.k12_autent '|| tWhereCorrente ;
    
    \t\t-- receitas
        tSql := tSql||'\tunion all
    \t\t\tselect caixa,
    \t\t\t\t\t\t data,
    \t\t\t\t\t\t autent,
    \t\t\t\t\t\t valor_debito,
    \t\t\t\t\t\t valor_credito,
    \t\t\t\t\t\t receita,
    \t\t\t\t\t\t cheque,
    \t\t\t\t\t\t credor,
    \t\t\t\t\t\t 0 as empenho,
    \t\t\t\t\t\t 0 as ordem,
    \t\t\t\t\t   planilha,
    \t\t\t\t\t   0 as slip,
    \t\t\t\t\t\t detalhe
    \t\t\t\tfrom ( select caixa,
    \t\t\t\t\t\t\t\t\t\t\tdata,
    \t\t\t\t\t\t\t\t\t\t\tautent,
    \t\t\t\t\t\t\t\t\t\t\tsum(valor_debito) as valor_debito,
    \t\t\t\t\t\t\t\t\t\t\tvalor_credito,
    \t\t\t\t\t\t\t\t\t\t\treceita,
    \t\t\t\t\t\t\t\t\t\t\thistorico::text,
    \t\t\t\t\t\t\t\t\t\t\tcheque::text,
    \t\t\t\t\t\t\t\t\t\t\tcredor::text,
    \t\t\t\t\t\t\t\t\t\t\tplanilha,
             \t\t\t\t\t\t  detalhe
    \t\t\t\t\t\t\t\tfrom ( select corrente.k12_id        as caixa,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcorrente.k12_data      as data,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcorrente.k12_autent    as autent,
                                  case
    \t\t\t\t\t\t\t\t\t              when corrente.k12_estorn is false
    \t\t\t\t\t\t\t\t\t                then cornump.k12_valor
    \t\t\t\t\t\t\t\t\t              else 0
    \t\t\t\t\t\t\t\t\t            end as valor_debito,
    \t\t\t\t\t\t\t\t\t            case
    \t\t\t\t\t\t\t\t\t              when corrente.k12_estorn is true
                                      then abs(cornump.k12_valor)
    \t\t\t\t\t\t\t\t\t              else 0
    \t\t\t\t\t\t\t\t\t            end as valor_credito,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcornump.k12_receit     as receita,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcoalesce(k81_codpla,0) as planilha,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t(\\'RECEITA: \\'||tabrec.k02_drecei||\\',Historico:\\'||coalesce(corhist.k12_histcor,\\'.\\'))::text as historico,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tnull::text         as cheque,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t(select z01_nome::text from arrepaga inner join cgm on z01_numcgm = k00_numcgm where k00_numpre=cornump.k12_numpre limit 1 ) as credor,
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcase when placaixarec is not null then
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t  \\'Planilha-\\'||k81_codpla||\\'#Receita-\\'||k02_codigo||\\'(\\'||k02_descr||\\') #Historico-\\'||coalesce(k12_histcor,\\'\\')
                                  WHEN corcla.k12_codcla is not null
                                   then \\'Classifica\xe7\xe3o-\\'||corcla.k12_codcla||\\'#Arquivo-\\'||disarq.arqret||\\'#Receita-\\'||k02_codigo||
                                        \\'(\\'||k02_descr||\\') #Historico-\\'||coalesce(k12_histcor,\\'\\')||
                                        \\'#C\xf3digo arrecada\xe7\xe3o-\\'||cornump.k12_numpre||\\'/\\'||cornump.k12_numpar||
                                        \\'#Data de cr\xe9dito-\\'||(select case
                                                                         when dtcredito is not null
                                                                           then to_char(dtcredito, \\'DD\\/MM\\/YYYY\\')
                                                                         else
                                                                          \\' \\'
                                                                       end as dtcredito
                                                                  from disbanco
                                                                 where disbanco.codret = disarq.codret
                                                                 limit 1)||
                                        \\'#Datas pagamento-\\'||(select array_to_string(array_accum(to_char(dtpago, \\'DD\\/MM\\/YYYY\\')),\\',\\')
                                                                  from ( select distinct
                                                                                dtpago
                                                                           from disbanco
                                                                          where codret = disarq.codret
                                                                          order by dtpago limit 5 ) as abc )
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\telse
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t  \\'Receita-\\'||k02_codigo||\\'(\\'||k02_descr||\\') #Historico-\\'||coalesce(k12_histcor,\\'\\')||\\'#C\xf3digo arrecada\xe7\xe3o-\\'||cornump.k12_numpre||\\'/\\'||cornump.k12_numpar
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tend as detalhe
    \t\t\t\t\t\t\t\t\t\t\t\t from corrente
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tinner join cornump     on cornump.k12_id             = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand cornump.k12_data           = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand cornump.k12_autent         = corrente.k12_autent
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tleft  join corplacaixa on corplacaixa.k82_id         = cornump.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corplacaixa.k82_data       = cornump.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corplacaixa.k82_autent     = cornump.k12_autent
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tleft  join placaixarec on corplacaixa.k82_seqpla     = placaixarec.k81_seqpla
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tinner join tabrec      on tabrec.k02_codigo          = cornump.k12_receit
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\tleft  join corhist     on corhist.k12_id             = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_data           = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_autent         = corrente.k12_autent
                                  left  join corcla       on corcla.k12_id          = corrente.k12_id
                                                         and corcla.k12_data        = corrente.k12_data
                                                         and corcla.k12_autent      = corrente.k12_autent
                                  left  join discla       on discla.codcla          = corcla.k12_codcla
                                  left  join disarq       on disarq.codret          = discla.codret
    
    \t\t\t\t\t\t\t\t\t\t\t  '||tWhereCorrente||' ) as x
    \t\t\t\t\t\t group by caixa,
    \t\t\t\t\t\t\t\t\t\t\tdata,
    \t\t\t\t\t\t\t\t\t\t\tautent,
    \t\t\t\t\t\t\t\t\t\t\tvalor_credito,
    \t\t\t\t\t\t\t\t\t\t\thistorico,
    \t\t\t\t\t\t\t\t\t\t\treceita,
    \t\t\t\t\t\t\t\t\t\t\tcheque,
    \t\t\t\t\t\t\t\t\t\t\tcredor,
    \t\t\t\t\t\t\t\t\t\t\tplanilha,
    \t\t\t\t\t\t\t\t\t\t\tdetalhe ) as xx ';
    
    \t\t/* transferencias a debito - entradas - corlanc */
    \t\ttSql := tSql||'\tunion all
    \t\tselect corrente.k12_id           as caixa,
    \t\t\t\t\t corlanc.k12_data          as data,
    \t\t\t\t\t corlanc.k12_autent        as autent,
    
    \t\t\t\t\t case
    \t\t\t\t\t   when corrente.k12_estorn is false then
    \t\t\t\t\t     abs(corrente.k12_valor)
    \t\t\t\t\t   else 0
    \t\t\t\t\t end as valor_debito,
    \t\t\t\t\t case
                 when corrente.k12_estorn is true then
                   abs(corrente.k12_valor)
                 else 0
               end as valor_credito,
    \t\t\t\t\t 0                         as receita,
    \t\t\t\t\t e91_cheque::text          as cheque,
    \t\t\t\t\t z01_nome::text            as credor,
    \t\t\t\t\t 0                         as empenho,
    \t\t\t\t\t 0                         as ordem,
    \t\t\t\t\t 0                         as planilha,
    \t\t\t\t\t slip.k17_codigo           as slip,
    \t\t\t\t   (\\'Slip-\\'||slip.k17_codigo||\\'#Hist\xf3rico-\\'||coalesce(slip.k17_texto,\\'\\')||(case when k12_estorn = \\'f\\' then \\'\\' else \\' Estorno: \\'||coalesce(slip.k17_motivoestorno,\\'\\') end))::text as detalhe
    \t\t\tfrom corlanc
    \t\t\t\t\t inner join corrente     on corrente.k12_id             = corlanc.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corrente.k12_data           = corlanc.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corrente.k12_autent         = corlanc.k12_autent
    \t\t\t\t\t inner join slip         on slip.k17_codigo             = corlanc.k12_codigo
    \t\t\t\t\t left join slipnum       on slipnum.k17_codigo          = slip.k17_codigo
    \t\t\t\t\t left join cgm           on slipnum.k17_numcgm          = z01_numcgm
    \t\t\t\t\t left join corconf       on corconf.k12_id              = corlanc.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_ativo is true
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_data            = corlanc.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_autent          = corlanc.k12_autent
    \t\t\t\t\t left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand e91_ativo is true
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_ativo is true
    \t\t\t\t\t left join corhist       on corhist.k12_id              = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_data            = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_autent          = corrente.k12_autent
    \t\t'|| tWhereCorlanc ;
    
    \t\t/* transferencias a credito - saidas - corrente */
    \t\ttSql := tSql || ' union all
    
    \t\tselect corrente.k12_id           as caixa,
    \t\t\t\t\t corlanc.k12_data          as data,
    \t\t\t\t\t corlanc.k12_autent        as autent,
               case
                 when corrente.k12_estorn is true then
                   abs(corrente.k12_valor)
                 else 0
               end as valor_debito,
               case
                 when corrente.k12_estorn is false then
                   abs(corrente.k12_valor)
                 else 0
               end as valor_credito,
               0                         as receita,
    \t\t\t\t\t e91_cheque::text          as cheque,
    \t\t\t\t\t z01_nome::text            as credor,
    \t\t\t\t\t 0                         as empenho,
    \t\t\t\t\t 0                         as ordem,
    \t\t\t\t\t 0                         as planilha,
    \t\t\t\t\t slip.k17_codigo           as slip,
                                             (\\'Slip-\\'||slip.k17_codigo||\\'#Hist\xf3rico-\\'||coalesce(slip.k17_texto,\\'\\')||(case when k12_estorn = \\'f\\' then \\'\\' else \\' Estorno: \\'||coalesce(slip.k17_motivoestorno,\\'\\') end))::text as detalhe
    \t\t\tfrom corrente
    \t\t\t\t\t inner join corlanc      on corrente.k12_id             = corlanc.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corrente.k12_data           = corlanc.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corrente.k12_autent         = corlanc.k12_autent
    \t\t\t\t\t inner join slip         on slip.k17_codigo             = corlanc.k12_codigo
    \t\t\t\t\t left join slipnum       on slipnum.k17_codigo          = slip.k17_codigo
    \t\t\t\t\t left join cgm           on slipnum.k17_numcgm          = z01_numcgm
    \t\t\t\t\t left join corconf       on corconf.k12_id              = corlanc.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_data            = corlanc.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_autent          = corlanc.k12_autent
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_ativo is true
    \t\t\t\t\t left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand e91_ativo is true
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corconf.k12_ativo is true
    \t\t\t\t\t left join corhist       on corhist.k12_id              = corrente.k12_id
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_data            = corrente.k12_data
    \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tand corhist.k12_autent          = corrente.k12_autent
        '|| tWhereCorrente ||' order by data, caixa, cheque ';
    
    \t\tif bRaise then
    \t\t\traise notice 'SQL PRINCIPAL : % ',tSql;
    \t\tend if;
    
    \t\tfor rExtratoCaixa in execute tSql loop
    
        -- raise notice 'id: % data: % autent: % ## debito: % | credito: % ',rExtratoCaixa.caixa,rExtratoCaixa.data, rExtratoCaixa.autent,rExtratoCaixa.valor_debito, rExtratoCaixa.valor_credito;
    
    \t\trtp_extratocaixa.riCaixa        := rExtratoCaixa.caixa;
    \t\trtp_extratocaixa.riAutent       := rExtratoCaixa.autent;
    \t\trtp_extratocaixa.riData         := rExtratoCaixa.data;
    \t\trtp_extratocaixa.rnValorDebito  := rExtratoCaixa.valor_debito;
    \t\trtp_extratocaixa.riValorCredito := rExtratoCaixa.valor_credito;
    \t\trtp_extratocaixa.riReceita      := rExtratoCaixa.receita;
    \t\trtp_extratocaixa.riCheque       := rExtratoCaixa.cheque;
    \t\trtp_extratocaixa.rtCredor       := rExtratoCaixa.credor;
    \t\trtp_extratocaixa.riEmpenho      := rExtratoCaixa.empenho;
    \t\trtp_extratocaixa.riOrdem        := rExtratoCaixa.ordem;
    \t\trtp_extratocaixa.riPlanilha     := rExtratoCaixa.planilha;
    \t\trtp_extratocaixa.riSlip         := rExtratoCaixa.slip;
    \t\trtp_extratocaixa.rtDetalhe      := rExtratoCaixa.detalhe;
    
     \t\t\treturn next rtp_extratocaixa;
    
    \t\tend loop;
    --
    \t\treturn ;
    
    end;
    \$\$ language 'plpgsql';
    
    
    
    
    
    
    
    
    
    
    
    
    
    SQL_WRAP;

    $this->execute($sql);

  }

  public function down()
  {

    $sql = <<<SQL

      update db_itensmenu set libcliente = true where id_item = 2000365;
      delete from db_menu where id_item = 32 and id_item_filho = 228484;
      delete from db_menu where id_item = 228484;
      delete from db_itensmenu where id_item in (228484,228485, 228486, 228487, 228488, 228489,  228490);





SQL;

    $this->execute($sql);

  }


}
