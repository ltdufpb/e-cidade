<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class AlterarOperacaoRequest extends FormRequest
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
            "valor" => ["numeric"],
            "nsu" => ["integer", "nullable"],
            "operacaotef" => ["integer"],
            "bandeira" => ["string", "nullable"],
            "parcela" => ["integer", "nullable"],
            "confirmado" => ["boolean", "nullable"],
            "mensagemretorno" => ["string", "nullable"],
            "desfeito" => ["boolean", "nullable"],
            "codigoaprovacao" => ["string", "nullable"],
            "nsuautorizadora" => ["integer", "nullable"],
            "cartao" => ["string", "nullable"],
            "retorno" => ["string", "nullable"],
            "grupo" => ["integer"],
            "confirmadoautorizadora" => ["boolean", "nullable"],
            "terminal" => ["integer"],
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
            "sequencial.required"     => mb_convert_encoding("Sequencial não informado.", 'UTF-8', 'ISO-8859-1'),
            "sequencial.integer"      => mb_convert_encoding("Sequencial inválido.", 'UTF-8', 'ISO-8859-1'),

            "numnov.required"         => mb_convert_encoding("Número do recibo não informado.", 'UTF-8', 'ISO-8859-1'),
            "numnov.integer"          => mb_convert_encoding("Número do recibo inválido.", 'UTF-8', 'ISO-8859-1'),

            "valor.required"          => mb_convert_encoding("Valor do recibo não informado.", 'UTF-8', 'ISO-8859-1'),
            "valor.numeric"           => mb_convert_encoding("Valor do recibo inválido.", 'UTF-8', 'ISO-8859-1'),

            "nsu.integer"             => mb_convert_encoding("NSU do CTF inválido.", 'UTF-8', 'ISO-8859-1'),

            "operacaotef.required"    => mb_convert_encoding("Operação não informada.", 'UTF-8', 'ISO-8859-1'),
            "operacaotef.integer"     => mb_convert_encoding("Operação inválida.", 'UTF-8', 'ISO-8859-1'),

            "bandeira.string"         => mb_convert_encoding("Bandeira inválido.", 'UTF-8', 'ISO-8859-1'),

            "parcela.string"          => mb_convert_encoding("Parcela inválido.", 'UTF-8', 'ISO-8859-1'),

            "confirmado.string"       => mb_convert_encoding("Confirmado inválido.", 'UTF-8', 'ISO-8859-1'),

            "mensagemretorno.string"  => mb_convert_encoding("Mensagem de Retorno inválida.", 'UTF-8', 'ISO-8859-1'),

            "desfeito.string"         => mb_convert_encoding("Desfeito inválido.", 'UTF-8', 'ISO-8859-1'),

            "codigoaprovacao.string"  => mb_convert_encoding("Código de Aprovação inválido.", 'UTF-8', 'ISO-8859-1'),

            "nsuautorizadora.integer" => mb_convert_encoding("NSU da Autorizadora inválido.", 'UTF-8', 'ISO-8859-1'),

            "cartao.string"           => mb_convert_encoding("Formato cartão inválido.", 'UTF-8', 'ISO-8859-1'),

            "retorno.require"         => mb_convert_encoding("Retorno do CTFClient não informado.", 'UTF-8', 'ISO-8859-1'),
            "retorno.string"          => mb_convert_encoding("Retorno do CTFClient inválido.", 'UTF-8', 'ISO-8859-1'),

            "grupo.required"          => mb_convert_encoding("Grupo não informado.", 'UTF-8', 'ISO-8859-1'),
            "grupo.string"            => mb_convert_encoding("Grupo inválido.", 'UTF-8', 'ISO-8859-1'),

            "terminal.required"       => mb_convert_encoding("Terminal não informado.", 'UTF-8', 'ISO-8859-1'),
            "terminal.string"         => mb_convert_encoding("Terminal inválido.", 'UTF-8', 'ISO-8859-1'),

            "confirmadoautorizadora.boolean" => mb_convert_encoding("Confirmação da Autorizadora inválida.", 'UTF-8', 'ISO-8859-1'),

            "DB_instit.required"      => mb_convert_encoding("Código da instituição não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_instit.integer"       => mb_convert_encoding("Código da instituição inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_coddepto.required"    => mb_convert_encoding("Código do departamentro não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_coddepto.integer"     => mb_convert_encoding("Código do departamentro inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_id_usuario.required"  => mb_convert_encoding("Código do usuário não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_id_usuario.integer"   => mb_convert_encoding("Código do usuário inválido.", 'UTF-8', 'ISO-8859-1'),

            "DB_datausu.required"     => mb_convert_encoding("Data do sistema não informada não informado.", 'UTF-8', 'ISO-8859-1'),
            "DB_datausu.integer"      => mb_convert_encoding("Data do sistema não informada inválido.", 'UTF-8', 'ISO-8859-1')
        ];
    }
}
