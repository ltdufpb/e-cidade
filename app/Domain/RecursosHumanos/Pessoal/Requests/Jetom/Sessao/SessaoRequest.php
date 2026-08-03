<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Sessao;

use App\Http\Requests\BaseFormRequest;

class SessaoRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    #[\Override]
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
            'rh247_sequencial' => 'nullable|integer',
            'rh247_comissao' => 'required|integer',
            'rh247_processada' => 'nullable|boolean',
            'rh247_tiposessao' => 'integer',
            'rh247_mes' => 'integer',
            'rh247_ano' => 'integer',
        ];
    }

    public function response(array $errors)
    {
        $mensagem = $errors[array_keys($errors)[0]][0];

        return response()->json([
            "message" => $mensagem,
            "errors" => $errors,
            "status" => 406
        ], 406);
    }

    #[\Override]
    public function messages()
    {
        return [
            'rh247_sequencial.integer' => mb_convert_encoding('Código da sessão inválido.', 'UTF-8', 'ISO-8859-1'),
            'rh247_comissao.required' => mb_convert_encoding('Comissão não informada.', 'UTF-8', 'ISO-8859-1'),
            'rh247_comissao.integer' => mb_convert_encoding('Código da comissão inválido.', 'UTF-8', 'ISO-8859-1'),
            'rh247_processada.boolean' => mb_convert_encoding('Verificação de sessão processada está em formato inválido.', 'UTF-8', 'ISO-8859-1'),
            'rh247_tiposessao.required' => mb_convert_encoding('Tipo da sessão não informado.', 'UTF-8', 'ISO-8859-1'),
            'rh247_tiposessao.integer' => mb_convert_encoding('Tipo da sessão em formato inválido.', 'UTF-8', 'ISO-8859-1'),
            'rh247_mes.integer' => mb_convert_encoding('Mês da competência em formato inválido.', 'UTF-8', 'ISO-8859-1'),
            'rh247_ano.integer' => mb_convert_encoding('Ano da competência em formato inválido.', 'UTF-8', 'ISO-8859-1')
        ];
    }
}
