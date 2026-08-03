<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class PendentesRequest extends FormRequest
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
            "dataInicio" => ["required", "date"],
            "dataFim" => ["required", "date"],
            "terminal" => ["integer", "nullable"],
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
            "dataInicio.required"           => mb_convert_encoding("Data Inicio não informada.", 'UTF-8', 'ISO-8859-1'),
            "dataInicio.date"               => mb_convert_encoding("Data Inicio inválida.", 'UTF-8', 'ISO-8859-1'),

            "dataFim.required"              => mb_convert_encoding("Data Fim não informada.", 'UTF-8', 'ISO-8859-1'),
            "dataFim.date"                  => mb_convert_encoding("Data Fim inválida.", 'UTF-8', 'ISO-8859-1'),

            "terminal.integer"              => mb_convert_encoding("Terminal inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_modulo.required"            => mb_convert_encoding("Módulo não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_modulo.integer"             => mb_convert_encoding("Módulo inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_itemmenu_acessado.required" => mb_convert_encoding("Menu não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_itemmenu_acessado.integer"  => mb_convert_encoding("Menu inválido.", 'UTF-8', 'ISO-8859-1')
        ];
    }
}
