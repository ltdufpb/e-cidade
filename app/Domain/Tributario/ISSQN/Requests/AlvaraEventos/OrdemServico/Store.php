<?php
namespace App\Domain\Tributario\ISSQN\Requests\AlvaraEventos\OrdemServico;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
{
    /**
     * @return bool
     */
    #[\Override]
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'q168_processo'     => 'required_without:q168_processoexterno|integer',
            'q168_cgm'          => 'required_without:q168_inscricao|integer',
            'q168_inscricao'    => 'required_without:q168_cgm|integer',
            'q168_descricao'    => 'required|filled|string',
            'q168_localizacao'  => 'required|filled|string',
            'q168_dataemissao'  => 'nullable|date',
            'q168_datainicio'   => 'required|filled|date',
            'q168_datafim'      => 'required|filled|date',
            'q168_horainicio'   => 'required|filled|string',
            'q168_horafim'      => 'required|filled|string',
            'q168_processoexterno' => 'required_without:q168_processo|string',
            'q168_titularprocessoexterno' => 'required_without:q168_processo|string',
            'q168_dataprocessoexterno' => 'required_without:q168_processo|date',
        ];
    }

    /**
     * @param array $errors
     * @return DBJsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $mensagem = mb_convert_encoding($errors[array_keys($errors)[0]][0], 'ISO-8859-1');
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    /**
     * @return array
     */
    #[\Override]
    public function messages()
    {
        return [
            "q168_processo.required_without"  => mb_convert_encoding("Processo ou Processo Externo devem ser informados!", 'UTF-8', 'ISO-8859-1'),
            "q168_processo.integer"           => mb_convert_encoding("Processo inválido.", 'UTF-8', 'ISO-8859-1'),
            "q168_descricao.required"         => mb_convert_encoding("Descricao não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_descricao.filled"           => mb_convert_encoding("Descricao informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_descricao.string"           => mb_convert_encoding("Descricao inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_localizacao.required"       => mb_convert_encoding("Localização não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_localizacao.filled"         => mb_convert_encoding("Localização informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_localizacao.string"         => mb_convert_encoding("Localização inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_datainicio.required"        => mb_convert_encoding("Data de inicio não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_datainicio.filled"          => mb_convert_encoding("Data de inicio informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_datainicio.string"          => mb_convert_encoding("Data de inicio inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_datafim.required"           => mb_convert_encoding("Data de fim não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_datafim.filled"             => mb_convert_encoding("Data de fim informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_datafim.string"             => mb_convert_encoding("Data de fim inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_horainicio.required"        => mb_convert_encoding("Hora de inicio não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_horainicio.filled"          => mb_convert_encoding("Hora de inicio informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_horainicio.string"          => mb_convert_encoding("Hora de inicio inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_horafim.required"           => mb_convert_encoding("Hora final não informada.", 'UTF-8', 'ISO-8859-1'),
            "q168_horafim.filled"             => mb_convert_encoding("Hora final informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q168_horafim.string"             => mb_convert_encoding("Hora final inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_dataemissao.date"           => mb_convert_encoding("Data de emissao inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_cgm.integer"                => mb_convert_encoding("CGM inválido.", 'UTF-8', 'ISO-8859-1'),
            "q168_cgm.required_without"       => mb_convert_encoding("CGM ou Inscrição devem ser informados!", 'UTF-8', 'ISO-8859-1'),
            "q168_inscricao.integer"          => mb_convert_encoding("Inscrição inválida.", 'UTF-8', 'ISO-8859-1'),
            "q168_inscricao.required_without" => mb_convert_encoding("CGM ou Inscrição devem ser informados!", 'UTF-8', 'ISO-8859-1'),
            "q168_dataprocessoexterno.date"   => mb_convert_encoding("Data do processo externo inválida.", 'UTF-8', 'ISO-8859-1'),

            "q168_processoexterno.required_without" => mb_convert_encoding(
                "Processo ou Processo Externo devem ser informados!", 'UTF-8', 'ISO-8859-1'
            ),
            "q168_titularprocessoexterno.required_without" => mb_convert_encoding(
                "Processo ou Processo Externo devem ser informados!", 'UTF-8', 'ISO-8859-1'
            ),
            "q168_dataprocessoexterno.required_without" => mb_convert_encoding(
                "Processo ou Processo Externo devem ser informados!", 'UTF-8', 'ISO-8859-1'
            ),
        ];
    }
}
