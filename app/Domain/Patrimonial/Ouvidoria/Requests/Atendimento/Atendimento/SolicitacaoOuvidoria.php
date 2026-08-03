<?php
namespace App\Domain\Patrimonial\Ouvidoria\Requests\Atendimento\Atendimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class SolicitacaoOuvidoria extends BaseFormRequest
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
            'numeroProcesso' => 'required|filled|integer',
            'anoProcesso' => 'required|filled|integer',
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
            "numeroProcesso.required" => mb_convert_encoding("Código da Numero de Processo não informado.", 'UTF-8', 'ISO-8859-1'),
            "numeroProcesso.filled" => mb_convert_encoding("O código da Numero de Processo informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "numeroProcesso.integer" => mb_convert_encoding("Código inválido da Numero de Processo.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.required" => mb_convert_encoding("Código do anoProcesso não informado.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.filled" => mb_convert_encoding("O código do anoProcesso informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.integer" => mb_convert_encoding("Código inválido do anoProcesso.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
