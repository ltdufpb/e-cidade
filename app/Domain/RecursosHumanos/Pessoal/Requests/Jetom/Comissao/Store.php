<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Comissao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

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
     * @return array|bool
     */
    public function rules()
    {
        return $this->preValidacaoRule() ?: [
            'instituicao' => 'required|filled|integer|max:50',
            'descricao' => [
                'required',
                'filled',
                'string',
                'max:50',
                Rule::unique(
                    'jetomcomissao',
                    'rh242_descricao'
                )->where(
                    "rh242_instit",
                    $this->request->all()['instituicao']
                ),
            ],

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
            "descricao.required" => mb_convert_encoding("É necessário informar a descrição da comissão.", 'UTF-8', 'ISO-8859-1'),
            "descricao.filled" => mb_convert_encoding("Descrição não pode estar vazia.", 'UTF-8', 'ISO-8859-1'),
            "descricao.string" => mb_convert_encoding("Descrição inválida.", 'UTF-8', 'ISO-8859-1'),
            "descricao.unique" => mb_convert_encoding("Esta descrição já cadastrada na instituição.", 'UTF-8', 'ISO-8859-1'),
            "descricao.max" => mb_convert_encoding("Excedido o limite máximo de 50 caracteres.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.required" => mb_convert_encoding("Instituição não informada para o cadastro da comissão.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.filled" => mb_convert_encoding("O código da instituição esta vazio.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.integer" => mb_convert_encoding("Código inválido da Instituição.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
