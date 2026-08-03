<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoTipoSessao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class Sequencial extends BaseFormRequest
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
            'id' => 'required|filled|integer|exists:jetomcomissaotiposessao,rh249_sequencial',
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
            "id.required" => mb_convert_encoding("Código do Tipo de Sessão da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "id.filled" => mb_convert_encoding("Código inválido do tipo de sessão da comissão.", 'UTF-8', 'ISO-8859-1'),
            "id.integer" => mb_convert_encoding("Código inválido do tipo de sessão da comissão.", 'UTF-8', 'ISO-8859-1'),
            "id.exists" => mb_convert_encoding("Código não encontrado do tipo de sessão da comissão.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
