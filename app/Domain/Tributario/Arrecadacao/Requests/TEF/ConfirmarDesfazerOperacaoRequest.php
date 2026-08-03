<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmarDesfazerOperacaoRequest extends FormRequest
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
            "sequencial" => ["required", "integer"],
            "DB_instit" => ["required", "integer"],
            "DB_coddepto" => ["required", "integer"],
            "DB_id_usuario" => ["required", "integer"],
            "DB_datausu" => ["required", "integer"]
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
            "sequencial.required"        => mb_convert_encoding("Sequencial não informado.", 'UTF-8', 'ISO-8859-1'),
            "sequencial.integer"         => mb_convert_encoding("Sequencial inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_instit.required"     => mb_convert_encoding("Código da instituição não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_instit.integer"      => mb_convert_encoding("Código da instituição inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_coddepto.required"   => mb_convert_encoding("Código do departamentro não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_coddepto.integer"    => mb_convert_encoding("Código do departamentro inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_id_usuario.required" => mb_convert_encoding("Código do usuário não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_id_usuario.integer"  => mb_convert_encoding("Código do usuário inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_datausu.required"    => mb_convert_encoding("Data do sistema não informada não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_datausu.integer"     => mb_convert_encoding("Data do sistema não informada inválido.", 'UTF-8', 'ISO-8859-1')
        ];
    }
}
