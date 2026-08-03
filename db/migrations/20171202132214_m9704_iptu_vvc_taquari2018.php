<?php

use Classes\PostgresMigration;

class M9704IptuVvcTaquari2018 extends PostgresMigration
{
    public function up()
    {
        $sSql = <<<VVC_WRAP
        create or replace function fc_iptu_calculavvc_taquari_2018( iMatricula      integer,
                                                                    iAnousu         integer,
                                                                    nVlrref         numeric,
                                                                    bRaise          boolean,
        
                                                                    OUT rnVvc       numeric(15,2),
                                                                    OUT rnTotarea   numeric,
                                                                    OUT riNumconstr integer,
                                                                    OUT rtDemo      text,
                                                                    OUT rtMsgerro   text,
                                                                    OUT rbErro      boolean,
                                                                    OUT riCodErro   integer,
                                                                    OUT rtErro      text
                                                              ) returns record as
        \$\$
        declare
        
            iMatricula           alias for \$1;
            iAnousu              alias for \$2;
        \t  nVlrref \t           alias for \$3;
            lRaise               alias for \$4;
        
        \t  nValorVenalTotal\t    numeric(15,2) default 0;
        \t  iNumeroedificacoes   integer default 0;
            nVm2c    \t\t\t       numeric(15,2) default 0;
            nValorVenal     \t   numeric;
            nFatorEstConservacao numeric;
        \t  lEdificacao\t\t\t     boolean;
            nAreaconstr\t\t\t     numeric(15,2) default 0;
        \t  lMatriculaPredial\t   boolean;
        
            tSqlConstr           text    default '';
        \t  tSqlCar\t\t           text    default '';
            lAtualiza            boolean default true;
        
            rConstr              record;
            rCar\t\t\t           record;
            rValorM2             record;
        
        begin
        
            perform fc_debug('', lRaise);
            perform fc_debug('' || lpad('',60,'-'), lRaise);
            perform fc_debug('* INICIANDO CALCULO DO VALOR VENAL DA CONSTRUCAO', lRaise);
        
            rnVvc       := 0;
            rnTotarea   := 0;
            riNumconstr := 0;
            rtDemo      := '';
            rtMsgerro   := 'Retorno ok';
            rbErro      := 'f';
            riCodErro   := 0;
            rtErro      := '';
        
            tSqlConstr :=               ' select * ';
            tSqlConstr := tSqlConstr || '  from iptuconstr ';
        \t  tSqlConstr := tSqlConstr || ' where j39_matric = ' || iMatricula;
            tSqlConstr := tSqlConstr || '   and j39_dtdemo is null';
        
            perform fc_debug('Buscando as construcoes: ' || tSqlConstr, lRaise);
        
            for rConstr in execute tSqlConstr loop
        
             lEdificacao := true;
             rValorM2    := fc_iptu_getvaloredificacao_taquari_2018( iMatricula, rConstr.j39_idcons, iAnousu, lRaise );
        
             if rValorM2.rlErro then
        
                rbErro    := 't';
                riCodErro := rValorM2.riCodErro;
                rtErro    := rValorM2.rtErro;
                return;
              end if;
        
             nVm2c := rValorM2.rnValorM2Edificacao;
        
             perform fc_debug('MATRICULA : ' || iMatricula || ' - IDCONSTR: ' || rConstr.j39_idcons ||' - ANO: '|| iAnousu || ' - VALOR: ' || nVm2c, lRaise);
        
             --Fator Estado Conservacao
              select j74_fator
                into nFatorEstConservacao
                from carconstr
                     inner join caracter   on j31_codigo = j48_caract
                     inner join cargrup    on j32_grupo  = j31_grupo
                     inner join iptuconstr on j39_matric = j48_matric
                                          and j39_idcons = j48_idcons
                     inner join carfator   on j74_caract = j31_codigo
               where j48_matric = iMatricula
                 and j48_idcons = rConstr.j39_idcons
                 and j31_grupo  = 23;
        
              if not found then
        
                rbErro    := true;
                riCodErro := 102;
                rtErro    := '23 - ESTADO CONSERVACAO';
                return;
              end if;
        
               perform fc_debug(' VVC usando formula: ( rConstr.j39_area * nVm2c * nFatorEstConservacao )', lRaise);
               perform fc_debug('  -> Valores: ( '||rConstr.j39_area||' * '||nVm2c||' * '||nFatorEstConservacao||' )', lRaise);
        
               nValorVenal        := ( rConstr.j39_area * nVm2c * nFatorEstConservacao );
               perform fc_debug('Valor venal da construcao '||rConstr.j39_idcons||': '||coalesce(nValorVenal,0),lRaise);
               nValorVenalTotal   := nValorVenalTotal + nValorVenal;
               perform fc_debug('Valor total venal: '||coalesce(nValorVenalTotal,0),lRaise);
        
               nAreaconstr        := nAreaconstr + rConstr.j39_area;
               perform fc_debug('Area Construida: ' || coalesce(nAreaconstr,0),lRaise);
               iNumeroedificacoes := iNumeroedificacoes + 1;
        
               insert into tmpiptucale (anousu, matric, idcons, areaed, vm2, pontos, valor, edificacao)
                    values (iAnousu, iMatricula, rConstr.j39_idcons, rConstr.j39_area, nVm2c, 0, nValorVenal, lEdificacao);
        
               if lAtualiza then
        
                 update tmpdadosiptu set predial = true;
                 lAtualiza = false;
               end if;
        
            end loop;
        
            perform matric
               from tmpiptucale
            where edificacao is true;
        
          \tif found then
          \t  lMatriculaPredial = true;
          \telse
          \t  lMatriculaPredial = false;
          \tend if;
        
          \tif lMatriculaPredial is true then
        
          \t  rnVvc       := nValorVenalTotal;
          \t  rnTotarea   := nAreaconstr;
          \t  riNumconstr := iNumeroedificacoes;
          \t  rtDemo      := '';
          \t  rbErro      := 'f';
        
          \t  update tmpdadosiptu set vvc = rnVvc;
          \telse
        
          \t  delete from tmpiptucale;
          \t  update tmpdadosiptu set predial = false;
          \tend if;
        
              perform fc_debug('' || lpad('',60,'-'), lRaise);
              perform fc_debug('', lRaise);
        
            return;
        
        end;
        \$\$  language 'plpgsql';
        VVC_WRAP;

        $this->execute($sSql);
    }

    public function down()
    {
        $this->execute("drop function fc_iptu_calculavvc_taquari_2018(integer, integer, numeric, boolean);");
    }
}
