<?php


namespace ECidade\Financeiro\Contabilidade\Relatorio\Razao\PorConta;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Excel extends Relatorio
{

    private $excel;
    /**
     * @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    private $sheet;
    private $row = 0;

    private function nextRow()
    {
        $this->row++;
    }

    private function getRow()
    {
        return $this->row;
    }

    public function __construct()
    {
        $this->excel = new Spreadsheet();
        $this->sheet = $this->excel->getActiveSheet();
    }

    public function writeHeader()
    {
        $this->nextRow();
        $this->sheet->setCellValue("A{$this->getRow()}", "LAN");
        $this->sheet->setCellValue("B{$this->getRow()}", "SEQ");
        $this->sheet->setCellValue("C{$this->getRow()}", "DATA");
        $this->sheet->setCellValue("D{$this->getRow()}", "RECEITA");
        $this->sheet->setCellValue("E{$this->getRow()}", mb_convert_encoding("DOTAÇÃO", 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("F{$this->getRow()}", "EMPENHO");
        $this->sheet->setCellValue("G{$this->getRow()}", mb_convert_encoding("SUPLEMENTAÇÃO", 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("H{$this->getRow()}", "DOCUMENTO");
        $this->sheet->setCellValue("I{$this->getRow()}", "SLIP");
        $this->sheet->setCellValue("J{$this->getRow()}", mb_convert_encoding("OP", 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("k{$this->getRow()}", "PLANILHA");
        $this->sheet->setCellValue("L{$this->getRow()}", "CONTA ORIGEM");
        $this->sheet->setCellValue("M{$this->getRow()}", "CONTRAPARTIDA");
        $this->sheet->setCellValue("N{$this->getRow()}", "VALOR");
        $this->sheet->setCellValue("O{$this->getRow()}", "VALOR TIPO");
        $this->sheet->setCellValue("P{$this->getRow()}", "HISTORICO");
        $this->sheet->setCellValue("Q{$this->getRow()}", "INSTITUICAO");
    }

    public function writeLine(ExcelLinha $linha)
    {
        $this->nextRow();
        $this->sheet->setCellValue("A{$this->getRow()}", mb_convert_encoding($linha->getLancamento(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("B{$this->getRow()}", mb_convert_encoding($linha->getSequencial(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("C{$this->getRow()}", mb_convert_encoding($linha->getData(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("D{$this->getRow()}", mb_convert_encoding($linha->getReceita(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("E{$this->getRow()}", mb_convert_encoding($linha->getDotacao(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("F{$this->getRow()}", mb_convert_encoding($linha->getEmpenho(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("G{$this->getRow()}", mb_convert_encoding($linha->getSuplementacao(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("H{$this->getRow()}", mb_convert_encoding($linha->getDocumento(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("I{$this->getRow()}", mb_convert_encoding($linha->getSlip(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("J{$this->getRow()}", mb_convert_encoding($linha->getOp(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("K{$this->getRow()}", mb_convert_encoding($linha->getPlanilha(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("L{$this->getRow()}", mb_convert_encoding($linha->getContaOrigem(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("M{$this->getRow()}", mb_convert_encoding($linha->getContraPartida(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("N{$this->getRow()}", mb_convert_encoding($linha->getValor(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("O{$this->getRow()}", mb_convert_encoding($linha->getTipo(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("P{$this->getRow()}", mb_convert_encoding($linha->getHistorico(), 'UTF-8', 'ISO-8859-1'));
        $this->sheet->setCellValue("Q{$this->getRow()}", mb_convert_encoding($linha->getInstituicao(), 'UTF-8', 'ISO-8859-1'));
    }

    public function writeBody()
    {
        $dados = $this->getComplanoAnalitico();
        foreach ($dados as $dado) {
            $dado = (object)$dado;
            $contas = $this->getDadosGerais($dado->c61_reduz);
            if (!empty($contas)) {
                foreach ($contas as $conta) {
                    $conta = (object)$conta;
                    $excelLinha = new ExcelLinha();
                    $sNumeroEmpenho = "{$conta->e60_codemp}/{$conta->e60_anousu}";
                    if (empty($conta->e60_codemp)) {
                        $sNumeroEmpenho = "";
                    }
                    $excelLinha->setContaOrigem("{$conta->c60_estrut} -  $conta->conta_descr ({$conta->c61_reduz})");
                    $excelLinha->setLancamento($conta->c69_codlan);
                    $excelLinha->setSequencial($conta->c69_sequen);
                    $excelLinha->setData($conta->c69_data);
                    $excelLinha->setReceita($conta->c74_codrec);
                    $excelLinha->setDotacao($conta->c73_coddot);
                    $excelLinha->setEmpenho($sNumeroEmpenho);
                    $excelLinha->setSuplementacao($conta->c79_codsup);
                    $excelLinha->setDocumento(" {$conta->c53_coddoc} - {$conta->c53_descr}");
                    $excelLinha->setTipo($conta->tipo == "D" ? "DEBITO" : "CREDITO");
                    $excelLinha->setValor(db_formatar($conta->c69_valor, 'f'));
                    if ($conta->c61_reduz == $conta->c69_debito) {
                        $contrapartida = "{$conta->credito_estrut} -  {$conta->credito_descr}  ($conta->c69_credito)";
                    } else {
                        $contrapartida = "{$conta->debito_estrut} -  {$conta->debito_descr} ($conta->c69_debito)";
                    }
                    $excelLinha->setContraPartida($contrapartida);

                    $historico = "HISTORICO: {$conta->c50_descr} {$conta->c72_complem} ";

                    if (!empty($conta->z01_numcgm)) {
                        $historico .= " CGM: $conta->z01_numcgm : $conta->z01_nome, ";
                    }

                    if ($conta->c75_numemp != "") {
                        $historico .= $conta->e60_resumo;
                    }

                    $excelLinha->setHistorico($historico);

                    if (!empty($conta->planilha)) {
                        $excelLinha->setPlanilha($conta->planilha);
                    }

                    if (!empty($conta->slip)) {
                        $excelLinha->setSlip($conta->slip);
                    }

                    if (!empty($conta->codigo_movimento)) {
                        $excelLinha->setOp($conta->codigo_movimento);
                    }
                    $excelLinha->setInstituicao("{$dado->codigo} - {$dado->nomeinst}");

                    $this->writeLine($excelLinha);
                }
            }
        }
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function output($nameFile = "file")
    {
        header('Content-Type: application/vnd.ms-excel;charset=ISO-8859-1');
        header('Content-Disposition: attachment;filename="' . $nameFile . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($this->excel, 'Xlsx');
        $writer->save('php://output');
    }

    public function run()
    {
        $this->writeHeader();
        $this->writeBody();
        $this->output("razao_por_conta");
    }
}
