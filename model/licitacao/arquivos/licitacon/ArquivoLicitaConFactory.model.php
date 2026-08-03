<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

abstract class ArquivoLicitaConFactory {

  public static function getArquivo($sNomeArquivo, CabecalhoLicitaCon $oCabecalho) {

    return match ($sNomeArquivo) {
        MembroConsLicitaCon::NOME_ARQUIVO => new MembroConsLicitaCon($oCabecalho),
        PessoasLicitaCon::NOME_ARQUIVO => new PessoasLicitaCon($oCabecalho),
        ComissaoLicitaCon::NOME_ARQUIVO => new ComissaoLicitaCon($oCabecalho),
        MemComissaoLicitaCon::NOME_ARQUIVO => new MemComissaoLicitaCon($oCabecalho),
        LicitacaoLicitaCon::NOME_ARQUIVO => new LicitacaoLicitaCon($oCabecalho),
        LicitanteLicitaCon::NOME_ARQUIVO => new LicitanteLicitaCon($oCabecalho),
        DotacaoLicLicitaCon::NOME_ARQUIVO => new DotacaoLicLicitaCon($oCabecalho),
        EventoLicLicitaCon::NOME_ARQUIVO => new EventoLicLicitaCon($oCabecalho),
        DocumentoLicLicitaCon::NOME_ARQUIVO => new DocumentoLicLicitaCon($oCabecalho),
        LoteLicitaCon::NOME_ARQUIVO => new LoteLicitaCon($oCabecalho),
        ItemLicitaCon::NOME_ARQUIVO => new ItemLicitaCon($oCabecalho),
        PropostaLicitaCon::NOME_ARQUIVO => new PropostaLicitaCon($oCabecalho),
        LotePropLicitaCon::NOME_ARQUIVO => new LotePropLicitaCon($oCabecalho),
        ItemPropLicitaCon::NOME_ARQUIVO => new ItemPropLicitaCon($oCabecalho),
        ContratoLicitaCon::NOME_ARQUIVO => new ContratoLicitaCon($oCabecalho),
        DotacaoConLicitaCon::NOME_ARQUIVO => new DotacaoConLicitaCon($oCabecalho),
        EventoConLicitaCon::NOME_ARQUIVO => new EventoConLicitaCon($oCabecalho),
        DocumentoConLicitaCon::NOME_ARQUIVO => new DocumentoConLicitaCon($oCabecalho),
        ResponsavelConLicitaCon::NOME_ARQUIVO => new ResponsavelConLicitaCon($oCabecalho),
        LoteConLicitaCon::NOME_ARQUIVO => new LoteConLicitaCon($oCabecalho),
        ItemConLicitaCon::NOME_ARQUIVO => new ItemConLicitaCon($oCabecalho),
        AlteracaoLicitaCon::NOME_ARQUIVO => new AlteracaoLicitaCon($oCabecalho),
        default => throw new Exception("Arquivo {$sNomeArquivo} não encontrado."),
    };
  }
}