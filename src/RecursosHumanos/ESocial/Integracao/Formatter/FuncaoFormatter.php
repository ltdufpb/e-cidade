<?php

namespace ECidade\RecursosHumanos\ESocial\Integracao\Formatter;

use Override;

/**
 * Formata os dados do Cargo
 *
 * @package ECidade\RecursosHumanos\ESocial\Integracao\Formatter
 * @author Augusto Oliveira <augusto.oliveira@dbseller.com.br>
 */
class FuncaoFormatter extends Formatter
{
    /**
     * Realiza a formatação dos dados para envio da API
     *
     * @param array $dados
     * @return array
     */
    #[Override]
    public function formatar($dados)
    {
        $dadosFormatado = parent::formatar($dados);
        return $this->posProcessamento($dadosFormatado);
    }

    /**
     * Realiza uma consistencia nos dados enviados
     *
     * @param array $dadosFormatado
     * @return array
     */
    private function posProcessamento($dadosFormatado)
    {
        foreach ($dadosFormatado as $dados) {
            if (!isset($dados->ideFuncao->fimValid) || empty($dados->ideFuncao->fimValid) || trim((string) $dados->ideFuncao->fimValid) == "") {
                $dados->ideFuncao->fimValid = null;
            }
        }

        return $dadosFormatado;
    }
}
