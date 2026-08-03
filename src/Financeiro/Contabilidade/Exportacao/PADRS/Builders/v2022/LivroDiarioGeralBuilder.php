<?php

namespace ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Builders\v2022;

use ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Builders\PadBuilder;
use ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Layouts\LayoutPad;
use ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Layouts\v2022\LivroDiarioGeral;

class LivroDiarioGeralBuilder extends PadBuilder
{

    protected $numerosLotesGerados = [];

    protected function create()
    {
        $this->layout = new LivroDiarioGeral();
    }

    protected function processar()
    {
        $historico = $this->dados['historico'];
        if (strlen((string) $historico) > 150) {
            $historico = substr((string) $historico, 0, 150);
        }

        $this->layout->setCodigoContabalanceteVerificao($this->formataNumerico($this->dados['estrutural'], 20));
        $this->layout->setOrgaoUnidade($this->formataNumerico($this->dados['orgaounidade'], 4));
        $this->layout->setLancamento($this->formataNumerico($this->dados['numerolancamento'], 12));
        $this->layout->setNumeroLote($this->formataNumerico($this->getNumeroLote(), 12));
        $this->layout->setNumeroDocumento($this->formataNumerico($this->dados['numerodocumento'], 13));
        $this->layout->setDataLancamento($this->formataData($this->dados['datalancamento']));
        $this->layout->setValor($this->formataValor($this->dados['valor'], 17));
        $this->layout->setTipoLancamento($this->dados['tipolancamento']);
        $this->layout->setHistorico($this->formataCaractere($historico, 150));
        $this->layout->setTipoDocumento($this->getTipoDocumento()); // usar c53_tipo
        $this->layout->setNatureza($this->dados['naturezainformacao']);
        $this->layout->setIndicadorSuperavitFinanceiro($this->dados['indicadorsuperavitfinanceiro']);
        $this->layout->setFonteRecurso($this->formataNumerico($this->dados['recurso'], 4));
        $this->layout->setComplemento($this->formataNumerico($this->dados['complemento_recurso'], 4));
    }

    private function getTipoDocumento()
    {
        if (empty($this->dados['c53_tipo'])) {
            return 0;
        }
        return match ($this->dados['c53_tipo']) {
            10, 11 => 1,
            20, 21 => 3,
            30, 31 => 2,
            default => 9,
        };
    }

    /**
     * Valida se o número do lote é um inteiro, caso não seja, é gerado um novo valor para o mesmo
     * Lógica extraída do programa antigo que gera o arquivo do livro diário geral
     */
    private function getNumeroLote()
    {
        $numeroLote = $this->dados['numerolote'];
        if (!preg_match('/^\d+$/', (string) $numeroLote)) {
            if (!array_key_exists($numeroLote, $this->numerosLotesGerados)) {
                $this->numerosLotesGerados[$numeroLote] = $this->gerarNumeroLote();
            }
            $numeroLote = $this->numerosLotesGerados[$numeroLote];
        }

        return $numeroLote;
    }

    /**
     * Gera um número inteiro contendo 12 dígitos
     * @return int
     */
    private function gerarNumeroLote()
    {
        $novoNumero = mt_rand(100000000000, 999999999999);
        if (in_array($novoNumero, $this->numerosLotesGerados)) {
            $this->gerarNumeroLote();
        }
        return $novoNumero;
    }
}
