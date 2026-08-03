<?php
namespace ECidade\Patrimonial\Licitacao\ComprasPublicas\Model;

class ComprasPublicasRetornoItens
{
  private $identificadoritemeportal;
    private $dados;
    private $deparaFornecedores;
    private $propostas = [];
    private $lances   = [];
    public function __construct(/**
     * identificador do item enviado para o portal l21_codigo da liclicitem
     * */
    private $identificadoritemecidade, $retornoItem, $deparaFornecedor)
    {
   
        $this->identificadoritemeportal  = $retornoItem->IdItem;
        $this->dados                     = $retornoItem;
        $this->deparaFornecedor          = $deparaFornecedor;
    }

    public function processar()
    {
        $valoresMelhorLanceFornecedor  = [];
        $dadosLances = $this->dados->Lances ?? [];
        foreach ($dadosLances as $lance) {
            $lanceItemLicitacao = new ComprasPublicasLancesFornecedor(
                $this->identificadoritemeportal,
                $this->identificadoritemecidade,
                $lance->Data,
                $lance->Hora,
                $this->deparaFornecedor[$lance->IdFornecedor],
                $lance->Valido,
                $lance->Cancelado,
                $lance->Justificativa,
                $lance->ValorUnitario,
                $lance->ValorTotal,
                $lance->ValorDesconto ?? "0"
            );
            $lanceItemLicitacao->save();

            if (!array_key_exists($lance->IdFornecedor, $valoresMelhorLanceFornecedor)) {
                $valoresMelhorLanceFornecedor[$lance->IdFornecedor] = $lanceItemLicitacao;
                continue;
            }
        
            if ($valoresMelhorLanceFornecedor[$lance->IdFornecedor]->getValorTotal() >
                $lanceItemLicitacao->getValorTotal()) {
                $valoresMelhorLanceFornecedor[$lance->IdFornecedor] = $lanceItemLicitacao;
            }
        }
    
        $dadosProposta = $this->dados->Propostas ?? [];
    
        foreach ($dadosProposta as $proposta) {
            $propostaItem = new ComprasPublicasProposta(
                $proposta->IdItem,
                $this->identificadoritemecidade,
                $proposta->Data,
                $proposta->Hora,
                $this->deparaFornecedor[$proposta->IdFornecedor],
                $proposta->Modelo,
                $proposta->Marca,
                $proposta->Fabricante,
                $proposta->Detalhamento,
                $proposta->ValidadeProposta,
                $proposta->ValorUnitario,
                $proposta->ValorDesconto,
                $proposta->ValorTotal,
                $proposta->Valido
            );

            if (count($valoresMelhorLanceFornecedor) > 1 &&
                array_key_exists($proposta->IdFornecedor, $valoresMelhorLanceFornecedor)) {
                $propostaItem->setData($valoresMelhorLanceFornecedor[$proposta->IdFornecedor]->getData());
                $propostaItem->setHora($valoresMelhorLanceFornecedor[$proposta->IdFornecedor]->getHora());
                $propostaItem->setValorTotal($valoresMelhorLanceFornecedor[$proposta->IdFornecedor]
                             ->getValorTotal());
                $propostaItem->setValorUnitario($valoresMelhorLanceFornecedor[$proposta->IdFornecedor]
                             ->getValorUnitario());
                $propostaItem->setDesconto($valoresMelhorLanceFornecedor[$proposta->IdFornecedor]
                             ->getValorDesconto());
            }

            $this->propostas[] = $propostaItem;
        }
    }

    public function getPropostas()
    {

        return $this->propostas;
    }

    public function getCodigoEcidade()
    {
        return $this->identificadoritemecidade;
    }
 
    public function getCodigoPortal()
    {
        return $this->identificadoritemeportal;
    }
}
