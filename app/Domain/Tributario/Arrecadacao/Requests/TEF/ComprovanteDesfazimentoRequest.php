<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class ComprovanteDesfazimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "numnov" => ["required", "integer"],
            "grupo" => ["required", "integer"],
            "DB_modulo" => ["required", "integer"],
            "DB_itemmenu_acessado" => ["required", "integer"]
        ];
    }

    public function response(array $errors)
    {
        $mensagem = mb_convert_encoding($errors[array_keys($errors)[0]][0], 'ISO-8859-1');
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    public function messages()
    {
        return [
            "numnov.required"        => mb_convert_encoding("Numnov não informado.", 'UTF-8', 'ISO-8859-1'),
            "numnov.integer"         => mb_convert_encoding("Numnov inválido.", 'UTF-8', 'ISO-8859-1'),

            "grupo.required"        => mb_convert_encoding("Grupo não informado.", 'UTF-8', 'ISO-8859-1'),
            "grupo.integer"         => mb_convert_encoding("Grupo inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_modulo.required"        => mb_convert_encoding("Módulo não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_modulo.integer"         => mb_convert_encoding("Módulo inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_itemmenu_acessado.required"        => mb_convert_encoding("Menu não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_itemmenu_acessado.integer"         => mb_convert_encoding("Menu inválido.", 'UTF-8', 'ISO-8859-1')
        ];
    }
}
