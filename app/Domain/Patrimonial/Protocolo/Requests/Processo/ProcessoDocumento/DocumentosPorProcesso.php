<?php
namespace App\Domain\Patrimonial\Protocolo\Requests\Processo\ProcessoDocumento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class DocumentosPorProcesso extends BaseFormRequest
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
            'codigoProcesso' => 'required|filled|integer',
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
            "codigoProcesso.required" => mb_convert_encoding("Código do processo não informado.", 'UTF-8', 'ISO-8859-1'),
            "codigoProcesso.filled" => mb_convert_encoding("O código do processo informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "codigoProcesso.integer" => mb_convert_encoding("Código inválido do processo.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
